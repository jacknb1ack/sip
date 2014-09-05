<?php
	if($_GET['aksi'] == insert)
	{
		$_SESSION['kode_buku'] = htmlentities(stripslashes($_POST['kode_buku']));
		$_SESSION['judul'] = htmlentities(stripslashes($_POST['judul']));
		$_SESSION['pengarang'] = htmlentities(stripslashes($_POST['pengarang']));
		$_SESSION['penerbit'] = htmlentities(stripslashes($_POST['penerbit']));
		$_SESSION['tahun_terbit'] = htmlentities(stripslashes($_POST['tahun_terbit']));
		$_SESSION['isbn'] = htmlentities(stripslashes($_POST['isbn']));
		$_SESSION['sinopsis'] = htmlentities(stripslashes($_POST['sinopsis']));
		
		$_SESSION['kode_buku'] = mysql_real_escape_string($_POST['kode_buku']);
		$_SESSION['judul'] = mysql_real_escape_string($_POST['judul']);
		$_SESSION['pengarang'] = mysql_real_escape_string($_POST['pengarang']);
		$_SESSION['penerbit'] = mysql_real_escape_string($_POST['penerbit']);
		$_SESSION['tahun_terbit'] = mysql_real_escape_string($_POST['tahun_terbit']);
		$_SESSION['isbn'] = mysql_real_escape_string($_POST['isbn']);
		$_SESSION['sinopsis'] = mysql_real_escape_string($_POST['sinopsis']);
		
		$kode_buku = $_SESSION['kode_buku'];
		$judul = $_SESSION['judul'];
		$pengarang = $_SESSION['pengarang'];
		$penerbit = $_SESSION['penerbit'];
		$tahun_terbit = $_SESSION['tahun_terbit'];
		$isbn = $_SESSION['isbn'];
		$sinopsis = $_SESSION['sinopsis'];
					
		// upload gambar
		$img_name = $_FILES['cover']['name'];
		$img_size = $_FILES['cover']['size'];
		$img_tmp = $_FILES['cover']['tmp_name'];
		
		// biar cuma file gambar yang boleh diupload
		$allowed_ext = array('jpg','jpeg','png','gif');
		$img_ext = strtolower(substr($img_name, strrpos($img_name, '.') + 1 ));
		$add_error = array();
		
		// set nama dan lokasi penyimpanan gambar
		$cover_filename = $_SESSION['kode_buku'].'.'.$img_ext; 
		$location = "images/cover/";
		
		// buat array isinya error
		
		if(empty($_SESSION['kode_buku']) || empty($_SESSION['judul']) || empty($_SESSION['pengarang']) || empty($_SESSION['penerbit']) || empty($_SESSION['tahun_terbit']) || empty($_SESSION['isbn']) || empty($_SESSION['sinopsis']) ) 
		{
			$add_error[] = 'Tidak boleh ada form yang kosong !';
		}
		
		else 
		{
			if(isset($_FILES['cover']))
			{
				if(in_array($img_ext, $allowed_ext) === false) 
				{ 
					$add_error[] = 'Gambar belum dipilih, atau format gambar salah !.'; 
				}
				
				else 
				{
					if(file_exists('images/cover/'.$cover_filename))
					{
						$add_error[] = "Buku dengan kode ".$_SESSION['kode_buku']." sudah tersimpan, Tolong di cek lagi !";
					}	
					else // beneran upload gambar
					{
						move_uploaded_file($img_tmp, $location.$cover_filename);
					}
				}
			}
		}
		
		if(isset($add_error)) 
		{
			if(empty($add_error)) 
			{
				$query="INSERT INTO buku(kode_buku,judul,penerbit,pengarang,tahun_terbit,isbn,cover,sinopsis)
						VALUES('$kode_buku','$judul','$penerbit','$pengarang','$tahun_terbit','$isbn','$cover_filename','$sinopsis')";
						
				$add_book = mysql_query($query);
				
				if(mysql_affected_rows()>0)
				{		
					unset($_SESSION['kode_buku']);
					unset($_SESSION['judul']);
					unset($_SESSION['pengarang']);
					unset($_SESSION['penerbit']);
					unset($_SESSION['tahun_terbit']);
					unset($_SESSION['isbn']);
					unset($_SESSION['sinopsis']);
							
					echo "<center><h2> Buku ".$judul." berhasil ditambahkan. </h2></center><br />" ;
					echo "<input type=button onclick=\"javascript:history.back()\" value=\"&#60;&#60; Kembali\" class=\"back-button\"> ";
				} 
				
			}
			else 
			{	
				echo "<center><h2 style='color:red;'>Data gagal ditambahkan karena :</h2></center><br>";	
				foreach ($add_error as $error) 
						{
						echo "<center><h3>".$error."</h3></center>"; 
						
						echo "<meta http-equiv=refresh content='3;url=?p=buku&aksi=tambah'>";}		 
			}
		}
		
	} //end if tambah buku
	
	elseif($_GET['aksi'] == delete)
	{
		$bookid = $_GET['book_id'];
		$list = mysql_fetch_array(mysql_query("SELECT * FROM buku WHERE kode_buku='$bookid'"));
		$cover = $list['cover'];
		unlink("images/cover/".$cover);
		mysql_query("delete from buku where kode_buku='$bookid'");
		echo "<h2 style='display:block; text-align:center;'>Buku dengan kode buku ".$bookid." berhasil dihapus dari database.</h2>";
		echo "<meta http-equiv=refresh content='3;url=?p=buku'>";
		
	}
	
	elseif($_GET['aksi'] == edit)
	{
		$bookid = $_GET['book_id'];
		// query SQL untuk menampilkan data sesuai id
		$query = "SELECT * FROM buku WHERE kode_buku='$bookid'";

		$result = mysql_query($query) or die('Error');
		
		while ($buku = mysql_fetch_array($result)) { 
		echo "
			
					<form method='post' action='?p=pbook&aksi=update&book_id=".$bookid."' id='add-form' name='add-form' enctype='multipart/form-data'>
				<h2>Form Penambahan Buku</h2><hr />
					<div id='label-style'>
						<label for='kode_buku' class='form-label'>Kode Buku</label>
						<label for='judul' class='form-label'>Judul</label>
						<label for='pengarang' class='form-label'>Pengarang</label>
						<label for='penerbit' class='form-label'>Penerbit</label>
						<label for='tahun_terbit' class='form-label'>Tahun Terbit</label>
						<label for='isbn' class='form-label'>ISBN</label>
						
						<label for='sinopsis' class='form-label' style='margin-top:10px;'>Sinopsis</label>
						<label for='cover' class='form-label' style='margin-top:183px;'>Cover</label>
					</div>
					
					<div id='input-style'>
						<label for='kode_buku' class='form-label' style='font-weight:bold; font-size:14px; color: red;'>".$buku['kode_buku']."</label>
						
						<input type='text' name='judul' id='judul' class='form-field' value='".$buku['judul']."' size='70' />
						
						<input type='text' name='pengarang' id='pengarang' class='form-field' value='".$buku['pengarang']."' size='40' />
						
						<input type='text' name='penerbit' id='penerbit' class='form-field' value='".$buku['penerbit']."' size='40' />
						
						<input type='text' name='tahun_terbit' id='tahun_terbit' class='form-field' value='".$buku['tahun_terbit']."' size='4' maxlength='4'/>
						
						<input type='text' name='isbn' id='isbn' class='form-field' value='".$buku['isbn']."' />
						
						<textarea name='sinopsis' id='sinopsis' class='form-field' cols='55' rows='10'>".$buku['sinopsis']."</textarea>"; ?>
						<p>* klik pada gambar dua kali untuk mengganti Cover !!!</p>
						<img src='images/cover/<?php echo $buku['cover']; ?>' style='margin:2px; padding: 2px; width: 430px; height:300px; background-color: #ccc;'/>
						<script type='text/javascript'>
							var form="<input type='file'name='cover' id='cover' class='form-field'/>";
							$(document).ready(function(){
							  $("img").dblclick(function(){
							    $(this).slideUp("slow");
							    $(this).after(form);
							  });
							  
							  
							});
							
						
							
						</script>
						<?php echo "
						
						
						
						
					
					<div style='clear:both;display:block;'></div>
					<input type='submit' name='submit' value='Update' class='back-button'/>
					<input type=button onclick='javascript:history.back()' value='&#60;&#60; Batal' class='back-button'>
					</div>
			</form>
			" ;
		}
		
	}
	
	elseif($_GET['aksi'] == update)
	{
		$kode_buku = $_GET['book_id'];
		$judul = $_POST['judul'];
		$pengarang = $_POST['pengarang'];
		$penerbit = $_POST['penerbit'];
		$tahun_terbit = $_POST['tahun_terbit'];
		$isbn = $_POST['isbn'];
		$sinopsis = $_POST['sinopsis'];
		
		// upload gambar
		$img_name = $_FILES['cover']['name'];
		$img_size = $_FILES['cover']['size'];
		$img_tmp = $_FILES['cover']['tmp_name'];
		
		// set nama dan lokasi penyimpanan gambar
		$img_ext = strtolower(substr($img_name, strrpos($img_name, '.') + 1 ));
		$cover_filename = $kode_buku.'.'.$img_ext; 
		$location = "images/cover/";
		
		$load = mysql_fetch_array(mysql_query("SELECT cover FROM buku WHERE kode_buku='$kode_buku'"));
		$old_photo = $load['cover'];
		
		if(isset($_FILES['cover']))
		{
			unlink($location.$old_photo);
			move_uploaded_file($img_tmp, $location.$cover_filename);
			mysql_query("UPDATE buku SET cover='$cover_filename',judul='$judul',pengarang='$pengarang',penerbit='$penerbit',tahun_terbit='$tahun_terbit',isbn='$isbn',sinopsis='$sinopsis' WHERE kode_buku='$kode_buku'");
			echo "<h2 style='display:block; text-align:center;'>Buku dengan kode buku ".$kode_buku." berhasil diperbarui .</h2>";
			echo "<meta http-equiv=refresh content='2;url=?p=buku'>";
		}
		else
		{
			mysql_query("UPDATE buku SET judul='$judul',pengarang='$pengarang',penerbit='$penerbit',tahun_terbit='$tahun_terbit',isbn='$isbn',sinopsis='$sinopsis' WHERE kode_buku='$kode_buku'");
			echo "<h2 style='display:block; text-align:center;'>Buku dengan kode buku ".$kode_buku." berhasil diperbarui .</h2>";
			echo "<meta http-equiv=refresh content='2;url=?p=buku'>";
		}
	}
	
	elseif(!isset($_GET['aksi']))
	{
		echo "<center><h2>Anda Tidak Dapat Mengakses Langsung Halaman Ini !!!</h2></center>";

		echo "<meta http-equiv=refresh content='1;url=index.php'>";
	}
?>