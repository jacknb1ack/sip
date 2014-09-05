<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  //untuk cek apakah sudah login
{  
	if($_SESSION['type'] == 0 || $_SESSION['type'] == 1) // code dibawah ini membatasi tipe user yang dapat mengakses
		{
			if(isset($_GET['aksi']))
			{
				$book_id = $_GET['book_id']; //the product id from the URL 
				$aksi = $_GET['aksi']; //the action from the URL 

				switch($aksi) 
				{ //decide what to do 

				    case "tambah":
				        $_SESSION['cart'][$book_id]= $book_id; 
						echo "<meta http-equiv=refresh content='0;url=?p=buku'>";
				    break;

				    case "hapus":
				     unset($_SESSION['cart'][$book_id]);
				   		echo "<meta http-equiv=refresh content='0;url=?p=buku'>";
				    break;

				    case "empty":
				        unset($_SESSION['cart']); 
				   		echo "<meta http-equiv=refresh content='0;url=?p=buku'>";
				   break;
				   
				   case "insert":
				   	$date = date("Y-m-d");
					$due = date('Y-m-d',strtotime("+6 day")); 
					$anggota = $_POST['no_anggota'];
					$buku_raw = $_POST['kode_buku'];
					$operator = $_POST['operator'];
					
					$kode_buku = explode(',', $buku_raw);
					$buku = serialize($kode_buku);
					
					foreach($kode_buku as $kode)
					{
						mysql_query("UPDATE buku SET stok=if(stok > 1,stok-1,0),dipinjam=dipinjam+1 WHERE kode_buku='$kode'");
					}
					
					$query="INSERT INTO pinjam(no_anggota,kode_buku,tgl_pinjam,tgl_habis,pemberi)
							VALUES('$anggota','$buku','$date','$due','$operator')";
					
					$add_member = mysql_query($query);
					
					if(mysql_affected_rows()>0)
					{		
						unset($_SESSION['cart']); //unset the whole cart, i.e. empty the cart. 
						mysql_query("update anggota set meminjam=meminjam+1 where no_anggota='$anggota'");
					   	echo "<meta http-equiv=refresh content='0;url=?p=buku'>";
					}
				   break;
				   
				   case "proses":
				   	$carts = implode(',', $_SESSION['cart']);
					?>
						<form method="post" action="?p=pinjam&aksi=insert" id="add-form" name="add-form">
						<h2>Form Peminjaman Buku</h2><hr />
							<div id="label-style">
								<label for="no_anggota" class="form-label">No Anggota</label>
								
								<label for="kode_buku" class="form-label">Buku</label>
								<label for="operator" class="form-label">Operator</label>
							</div>
							
							<div id="input-style">
								<input type="text" name="no_anggota" id="no_anggota" class="form-field" value="" maxlength="16" size="16" />
								<input type="text" name="kode_buku" id="kode_buku" class="form-field" value="<?php echo $carts; ?>" size="25"/>
								<?php
									$sql="SELECT uname FROM users WHERE type=3";
									$result=mysql_query($sql);
								
								echo "					
								<select name='operator' id='operator' class='form-field'>
									";
										while ($row=mysql_fetch_array($result)) {
										$name=$row["uname"];
										
										echo "
											<option value=".$name.">".$name."</option>
											"; }
									?>
									
								</select>								
							<div style='clear:both;display:block;'></div>
							<input type="submit" name="submit" value="Tambahkan" class="back-button"/>
							<input type=button onclick="javascript:history.back()" value="&#60;&#60; Batal" class="back-button">
							</div>
							
						</form>
					<?php
					break;		
				}
			}	
			else
			{
				
			}
		}
	
	else // code dibawah untuk tipe user yang tidak memiliki akses
		{
			echo "Anda tidak dapat mengakses halaman ini !!!";
			echo "<meta http-equiv=refresh content='3;url=?p=home'>";
		}
}
else //untuk menolak akses langsung melalui url
{
	echo "<h2>Anda tidak dapat mengakses halaman ini !!! >/h2><br />	<input type=button onclick=\"javascript:history.back()\" value=\"&#60;&#60; Kembali\" class=\"back-button\"> ";
	echo "atau <button class=\"back-button\"><a href='?p=acc'>Login</a></button> ";
	}
?>