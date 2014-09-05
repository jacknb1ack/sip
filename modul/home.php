<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  
{  
	if($_SESSION['type'] == 0)
		{
		?>
		<h2><a href="?p=report" style="
											display: inline-block;
											background-color: #cccccc;
											float: left;
											width: auto;
											padding: 0 20px;
											margin-bottom: 5px;
											text-align: center;
											font-size: 14px;
											font-style: normal;
											border-radius: 4px;
										    color: blue;
											
										    													   ">
		Lihat Laporan</a></h2>
		
		
		<h2><a href="?p=buku" style="
											display: inline-block;
											background-color: #cccccc;
											float: left;
											width: auto;
											padding: 0 20px;
											margin-bottom: 5px;
											text-align: center;
											font-size: 14px;
											font-style: normal;
											border-radius: 4px;
										    color: blue;
											margin-left: 15px;
										    													   ">
		Pengaturan Buku</a></h2>
	
		
		<h2><a href="?p=member" style="
											display: inline-block;
											background-color: #cccccc;
											float: left;
											width: auto;
											padding: 0 20px;
											margin-bottom: 5px;
											text-align: center;
											font-size: 14px;
											font-style: normal;
											border-radius: 4px;
										    color: blue;
											margin-left: 15px;
										    													   ">
		Pengaturan Anggota</a></h2>
		
		
		<h2><a href="?p=transaksi" style="
											display: inline-block;
											background-color: #cccccc;
											float: left;
											width: auto;
											padding: 0 20px;
											margin-bottom: 5px;
											text-align: center;
											font-size: 14px;
											font-style: normal;
											border-radius: 4px;
										    color: blue;
											margin-left: 15px;
										    													   ">
		Pengaturan Transaksi</a></h2>
		
		
		<h2><a href="?p=user" style="
											display: inline-block;
											background-color: #cccccc;
											float: left;
											width: auto;
											padding: 0 20px;
											margin-bottom: 5px;
											text-align: center;
											font-size: 14px;
											font-style: normal;
											border-radius: 4px;
										    color: blue;
											margin-left: 15px;
										    													   ">
		Pengaturan User</a></h2>
		
		<?php
		}
	elseif($_SESSION['type'] == 1)
		{
			include "modul/report.php";
		}
	elseif($_SESSION['type'] == 3)
		{
		$aksi = $_GET['aksi'];
		$uname = $_SESSION['uname'];
		switch($aksi){
			case "edit":
			$profil = mysql_fetch_array(mysql_query("select * from users where uname='$uname'"));
			$id = $profil['id'];
			?>
			<form method="post" action="?p=home&aksi=update" id="add-form" name="add-form">
				<h2>Form Edit Profile</h2><hr />
					<div id="label-style">
						
						<label for="nama" class="form-label">Nama Lengkap</label>
						<label for="username" class="form-label">Username</label>
						<label for="old_pass" class="form-label">Password Lama</label>
						<label for="new_pass" class="form-label">Password Baru</label>
						
					</div>
					
					<div id="input-style">
						
						<input type="text" name="nama" id="nama" class="form-field" value="<?php echo $profil['nama']; ?>" size="32"/>
						
						<input type="text" name="username" id="username" class="form-field" value="<?php echo $profil['uname']; ?>" maxlength="16" size="16" />
						
						<input type="text" name="old_pass" id="old_pass" class="form-field" value="" size="20" />
						
						<input type="text" name="new_pass" id="new_pass" class="form-field" value="" size="20" />
						<input type="hidden" name="id" id="id" value="<?php echo $profil['id']; ?>"/>
						
					<div style='clear:both;display:block;'></div>
					<input type="submit" name="submit" value="Update" class="back-button"/>
					<input type=button onclick="javascript:history.back()" value="&#60;&#60; Batal" class="back-button">
					</div>
			</form>	
			<?php
			break;
			
			case "update":
			$id = $_POST['id'];
			$old_pass = md5($_POST['old_pass']);
			$check = mysql_fetch_array(mysql_query("select * from users where id='$id'"));
			$pass = $check['paswd'];
			
			$uname = $_POST['username'];
			$nama = $_POST['nama'];
			$new_pass = md5($_POST['new_pass']);
			
			if($old_pass === $pass)
			{
				mysql_query("UPDATE users SET nama='$nama',uname='$uname',paswd='$new_pass' WHERE id='$id'");
				if(mysql_affected_rows()>0)
					{		
					echo "<p style='padding:10px; border-radius: 5px; background-color: #F7B64A; text-align:center; font-size:16px; font-weight:bold; height:30px; color: blue;'>Profil Telah Berhasil di Perbarui, Silahkan login kembali !</p><br />";
					session_destroy();
					echo "<meta http-equiv=refresh content='0;url=?p=acc'>";	
					}
			}
			else
			{
				echo "<p style='padding:10px; border-radius: 5px; background-color: #F7B64A; text-align:center; font-size:16px; font-weight:bold; height:30px; color: blue;'>Anda memasukkan password yang salah, silahkan coba lagi !</p><br />";
				echo "<input type=button onclick=\"javascript:history.back()\" value=\"&#60;&#60; Kembali\" class=\"back-button\">";
			}
			break;
			
			default:
			?>
			<p style='padding:10px; border-radius: 5px; background-color: #F7B64A; text-align:center; font-size:16px; font-weight:bold; height:30px; color: blue;'>Selamat Datang <?php echo $_SESSION['uname']; ?></p><br />
			<h2><a href="?p=home&aksi=edit" style="
													display: inline-block;
													background-color: #cccccc;
													float: left;
													width: auto;
													padding: 0 20px;
													margin-bottom: 5px;
													text-align: center;
													font-size: 14px;
													font-style: normal;
													border-radius: 4px;
												    color: blue;
												    													   ">
				Edit Profile</a></h2>
				
				
				<h2><a href="?p=buku" style="
													display: inline-block;
													background-color: #cccccc;
													float: left;
													width: auto;
													padding: 0 20px;
													margin-bottom: 5px;
													text-align: center;
													font-size: 14px;
													font-style: normal;
													border-radius: 4px;
												    color: blue;
													margin-left: 15px;
												    													   ">
				Pengaturan Buku</a></h2>
			
				
				<h2><a href="?p=member" style="
													display: inline-block;
													background-color: #cccccc;
													float: left;
													width: auto;
													padding: 0 20px;
													margin-bottom: 5px;
													text-align: center;
													font-size: 14px;
													font-style: normal;
													border-radius: 4px;
												    color: blue;
													margin-left: 15px;
												    													   ">
				Pengaturan Anggota</a></h2>
					
				
				<h2><a href="?p=transaksi" style="
													display: inline-block;
													background-color: #cccccc;
													float: left;
													width: auto;
													padding: 0 20px;
													margin-bottom: 5px;
													margin-left: 15px;
													text-align: center;
													font-size: 14px;
													font-style: normal;
													border-radius: 4px;
												    color: blue;
												    													   ">
				Pengaturan Transaksi</a></h2>
					
			<?php
			break;
		}
		
		}
}
else
{
	echo "<h2>Anda tidak dapat mengakses halaman ini !!! >/h2><br />	<input type=button onclick=\"javascript:history.back()\" value=\"&#60;&#60; Kembali\" class=\"back-button\"> ";
	echo "atau <button class=\"back-button\"><a href='?p=acc'>Login</a></button> ";
}
?>