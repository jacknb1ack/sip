<?php
	if($_GET['aksi'] == insert)
	{
		$_SESSION['no_anggota'] = htmlentities(stripslashes($_POST['no_anggota']));
		$_SESSION['nama'] = htmlentities(stripslashes($_POST['nama']));
		$_SESSION['jenis_id'] = htmlentities(stripslashes($_POST['jenis_id']));
		$_SESSION['no_id'] = htmlentities(stripslashes($_POST['no_id']));
		$_SESSION['phone'] = htmlentities(stripslashes($_POST['phone']));
		$_SESSION['alamat'] = htmlentities(stripslashes($_POST['alamat']));
		
		$_SESSION['no_anggota'] = mysql_real_escape_string($_POST['no_anggota']);
		$_SESSION['nama'] = mysql_real_escape_string($_POST['nama']);
		$_SESSION['jenis_id'] = mysql_real_escape_string($_POST['jenis_id']);
		$_SESSION['phone'] = mysql_real_escape_string($_POST['phone']);
		$_SESSION['no_id'] = mysql_real_escape_string($_POST['no_id']);
		$_SESSION['alamat'] = mysql_real_escape_string($_POST['alamat']);
		
		$no_anggota = $_SESSION['no_anggota'];
		$nama = $_SESSION['nama'];
		$jenis_id = $_SESSION['jenis_id'];
		$no_id = $_SESSION['no_id'];
		$phone = $_SESSION['phone'];
		$alamat = $_SESSION['alamat'];
					
		// upload gambar
		$img_name = $_FILES['foto']['name'];
		$img_size = $_FILES['foto']['size'];
		$img_tmp = $_FILES['foto']['tmp_name'];
		
		// biar cuma file gambar yang boleh diupload
		$allowed_ext = array('jpg','jpeg','png','gif');
		$img_ext = strtolower(substr($img_name, strrpos($img_name, '.') + 1 ));
		$add_error = array();
		
		// set nama dan lokasi penyimpanan gambar
		$foto_filename = $_SESSION['no_anggota'].'.'.$img_ext; 
		$location = "images/member/";
		
		// buat array isinya error
		
		if(empty($_SESSION['no_anggota']) || empty($_SESSION['nama']) || empty($_SESSION['jenis_id']) || empty($_SESSION['no_id']) || empty($_SESSION['alamat']) ) 
		{
			$add_error[] = 'Tidak boleh ada form yang kosong !';
		}
		
		else 
		{
			if(isset($_FILES['foto']))
			{
				if(in_array($img_ext, $allowed_ext) === false) 
				{ 
					$add_error[] = 'Gambar belum dipilih, atau format gambar salah !.'; 
				}
				
				else 
				{
					if(file_exists('images/member/'.$foto_filename))
					{
						$add_error[] = "Anggota dengan nomor ".$_SESSION['no_anggota']." sudah terdaftar, Tolong di cek lagi !";
					}	
					else // beneran upload gambar
					{
						move_uploaded_file($img_tmp, $location.$foto_filename);
					}
				}
			}
		}
		
		if(isset($add_error)) 
		{
			if(empty($add_error)) 
			{
				$query="INSERT INTO anggota(no_anggota,nama,jenis_identitas,no_identitas,phone,alamat,foto)
						VALUES('$no_anggota','$nama','$jenis_id','$no_id','$phone','$alamat','$foto_filename')";
						
				$add_member = mysql_query($query);
				
				if(mysql_affected_rows()>0)
				{		
					echo "<center><h2> Anggota dengan nomor ".$no_anggota." berhasil ditambahkan. </h2></center><br />" ;
					echo "<input type=button onclick=\"javascript:history.back()\" value=\"&#60;&#60; Kembali\" class=\"back-button\"> ";
					
					unset($_SESSION['no_anggota']);
					unset($_SESSION['nama']);
					unset($_SESSION['no_id']);
					unset($_SESSION['jenis_id']);
					unset($_SESSION['alamat']);
					unset($_SESSION['phone']);
				} 
				
			}
			else 
			{	
				echo "<center><h2 style='color:red;'>Data gagal ditambahkan karena :</h2></center><br>";	
				foreach ($add_error as $error) 
						{
						echo "<center><h3>".$error."</h3></center>"; 
						
						echo "<meta http-equiv=refresh content='3;url=?p=member&aksi=tambah'>";}		 
			}
		}
		
	} //end if tambah buku
	
	elseif($_GET['aksi'] == delete)
	{
		$member_id = $_GET['member_id'];
		$list = mysql_fetch_array(mysql_query("SELECT * FROM anggota WHERE no_anggota='$member_id'"));
		$foto = $list['foto'];
		unlink("images/member/".$foto);
		mysql_query("delete from anggota where no_anggota='$member_id'");
		echo "<h2 style='display:block; text-align:center;'>Anggota dengan nomor ".$member_id." berhasil dihapus dari database.</h2>";
		echo "<meta http-equiv=refresh content='3;url=?p=member'>";
		
	}
	
	elseif($_GET['aksi'] == edit)
	{
		$member_id = $_GET['member_id'];
		// query SQL untuk menampilkan data sesuai id
		$query = "SELECT * FROM anggota WHERE no_anggota='$member_id'";

		$result = mysql_query($query) or die('Error');
		
		while ($anggota = mysql_fetch_array($result)) { 
		echo "
			<form method='post' action='?p=pmember&aksi=update' id='add-form' name='add-form' enctype='multipart/form-data'>
				<h2>Form Pendaftaran Anggota</h2><hr />
					<div id='label-style'>
						<label for='no_anggota' class='form-label'>No Anggota</label>
						<label for='nama' class='form-label'>Nama Lengkap</label>
						<label for='jenis_id' class='form-label'>Jenis ID</label>
						<label for='no_id' class='form-label'>No Identitas</label>
						<label for='phone' class='form-label'>No Telefon</label>
						<label for='alamat' class='form-label'>Alamat</label>
						<label for='foto' class='form-label' style='margin-top:55px;'>Pas Foto</label>
					</div>
					
					<div id='input-style'>
						<label for='no_anggota' class='form-label' style='font-weight:bold; font-size:14px; color: red;'>".$anggota['no_anggota']."</label>
												
						<input type='text' name='nama' id='nama' class='form-field' value='".$anggota['nama']."' size='50' />
						
						<select name='jenis_id'  class='form-field'>	
							<option value='KTP'"; if($anggota['jenis_identitas']== 'KTP') {echo "selected='selected'";} else {} echo ">KTP</option>";
							echo "
							<option value='SIM'"; if($anggota['jenis_identitas']== 'SIM') {echo "selected='selected'";} else {} echo ">SIM</option>";
							echo "
							<option value='KTM/PELAJAR'"; if($anggota['jenis_identitas']== 'KTM/PELAJAR') {echo "selected='selected'";} else {} echo ">KTM/PELAJAR</option>";
							echo "
						</select>
						
						<input type='text' name='no_id' id='no_id' class='form-field' value='".$anggota['no_identitas']."' size='20' />
						
						<input type='text' name='phone' id='phone' class='form-field' value='".$anggota['phone']."' size='16' maxlength='16' />
						
						<textarea name='alamat' id='alamat' class='form-field' cols='40' rows='3'>".$anggota['alamat']."</textarea>"; ?>
						<p>* klik pada foto dua kali untuk mengganti Foto !!!</p>
						<img src='images/member/<?php echo $anggota['foto']; ?>' style='margin:2px; padding: 2px; width: 150px; height:200px; background-color: #ccc;'/>
						<script type='text/javascript'>
							var form="<input type='file'name='foto' id='foto' class='form-field'/>";
							$(document).ready(function(){
							  $("img").dblclick(function(){
							    $(this).slideUp("slow");
							    $(this).after(form);
							  });
							  
							  
							});
							
						
							
						</script>
						<?php echo "
						<div style='clear:both;display:block;'></div>
						<input type='hidden' name='id_member' value='".$anggota['no_anggota']."' />
						<input type='submit' name='submit' value='Update' class='back-button'/>
						<input type=button onclick='javascript:history.back()' value='&#60;&#60; Batal' class='back-button'>
					</div>
				</form>
			" ;
		}
		
	}
	
	elseif($_GET['aksi'] == update)
	{
				
		$no_anggota = $_POST['id_member'];
		$nama = $_POST['nama'];
		$jenis_id = $_POST['jenis_id'];
		$no_id = $_POST['no_id'];
		$phone = $_POST['phone'];
		$alamat = $_POST['alamat'];
		
		// upload gambar
		$img_name = $_FILES['foto']['name'];
		$img_size = $_FILES['foto']['size'];
		$img_tmp = $_FILES['foto']['tmp_name'];
		
		// set nama dan lokasi penyimpanan gambar
		$img_ext = strtolower(substr($img_name, strrpos($img_name, '.') + 1 ));
		$foto_filename = $no_anggota.'.'.$img_ext; 
		$location = "images/member/";
		$load = mysql_fetch_array(mysql_query("SELECT foto FROM anggota WHERE no_anggota='$no_anggota'"));
		$old_photo = $load['foto'];
		
		if(isset($_FILES['foto']))
		{
			unlink($location.$old_photo);
			move_uploaded_file($img_tmp, $location.$foto_filename);
			mysql_query("UPDATE anggota SET foto='$foto_filename',nama='$nama',jenis_identitas='$jenis_id',no_identitas='$no_id',phone='$phone',alamat='$alamat' WHERE no_anggota='$no_anggota'");
			echo "<h2 style='display:block; text-align:center;'>Anggota dengan nomor ".$no_anggota." berhasil diperbarui .</h2>";
			echo "<meta http-equiv=refresh content='2;url=?p=member'>";
			
		}
		else
		{
		mysql_query("UPDATE anggota SET nama='$nama',jenis_identitas='$jenis_id',no_identitas='$no_id',phone='$phone',alamat='$alamat' WHERE no_anggota='$no_anggota'");
		echo "<h2 style='display:block; text-align:center;'>Anggota dengan nomor ".$no_anggota." berhasil diperbarui .</h2>";
		echo "<meta http-equiv=refresh content='2;url=?p=member'>";	
		}
		
	}
	
	elseif(!isset($_GET['aksi']))
	{
		echo "<center><h2>Anda Tidak Dapat Mengakses Langsung Halaman Ini !!!</h2></center>";

		echo "<meta http-equiv=refresh content='1;url=index.php'>";
	}
?>