<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  //untuk cek apakah sudah login
{  
	if($_SESSION['type'] == 0 || $_SESSION['type'] == 1) // code dibawah ini membatasi tipe user yang dapat mengakses
		{
			if($_GET['aksi'] == 'tambah')
			{ ?>
			<form method="post" action="?p=user&aksi=insert" id="add-form" name="add-form" >
				<h2>Form Penambahan Operator</h2><hr />
					<div id="label-style">
						
						<label for="nama" class="form-label">Nama Lengkap</label>
						<label for="username" class="form-label">Username</label>
						<label for="password" class="form-label">Password</label>
						
					</div>
					
					<div id="input-style">
						
						<input type="text" name="nama" id="nama" class="form-field" value="<?php $val_nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Nama Lengkap...'; echo $val_nama; ?>" size="32" onclick="this.value=(this.value == 'Nama Lengkap...' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'Nama Lengkap...' : this.value);"/>
						
						<input type="text" name="username" id="username" class="form-field" value="<?php $val_uname = isset($_SESSION['username']) ? $_SESSION['username'] : 'Username...'; echo $val_uname; ?>" maxlength="16" size="16" onclick="this.value=(this.value == 'Username...' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'Username...' : this.value);"/>
						
						<input type="text" name="password" id="password" class="form-field" value="<?php $val_paswd = isset($_SESSION['password']) ? $_SESSION['password'] : 'Password...'; echo $val_paswd; ?>" size="20" onclick="this.value=(this.value == 'Password...' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'Password...' : this.value);"/>
						
					<div style='clear:both;display:block;'></div>
					<input type="submit" name="submit" value="Tambahkan" class="back-button"/>
					<input type=button onclick="javascript:history.back()" value="&#60;&#60; Batal" class="back-button">
					</div>
			</form>	
			<?php
			}
			elseif($_GET['aksi'] == 'insert')
			{
				$nama = $_POST['nama'];
				$username = $_POST['username'];
				$password = md5($_POST['password']);
				
				$query="INSERT INTO users(nama,uname,paswd)
						VALUES('$nama','$username','$password')";
						
				$add_user = mysql_query($query);
				
				if(mysql_affected_rows()>0)
				{		
					echo "<meta http-equiv=refresh content='0;url=?p=user'>";
				} 
			}
			elseif($_GET['aksi'] == 'delete')
			{
				$userid = $_GET['user_id'];
				mysql_query("delete from users where id='$userid'");
				echo "<meta http-equiv=refresh content='0;url=?p=user'>";
				
			}
			else
			{ 
			
					
		
			?>
				<h2><a href="?p=user&aksi=tambah" style="
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
				Tambah Operator</a></h2><br/>
				<div class="clear"></div>
				<table style="margin: 0 auto; width: 100%; vertical-align: middle;">
					<thead style="background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;">
						<tr >
							<th width="5%"  >No</th>
							<th width="25%" >Nama</th>
							<th width="15%" >Username</th>
							<th width="5%"  align="center">Del</th>
							
						</tr>
						
					</thead>
					<tbody style="background-color: #a4a6a6; text-align: center; font-size: 12px; color: #091697; vertical-align: middle; height: 20px;">
						<?php
								
						$i = 0;
						$query = "SELECT * FROM users WHERE type='3'";
						$result = mysql_query($query) or die('Data tidak tersedia !!!');
						while ($users = mysql_fetch_array($result)) 
							{
								$i++;
								$nama = $users['nama'];
								$uname = $users['uname'];
								$userid = $users['id'];
								echo "
								<tr style='border-bottom:1px solid grey'>
									<td style='border-right:1px solid grey'>".$i."</td>
									<td style='border-right:1px solid grey'>".$nama."</td>
									<td style='border-right:1px solid grey'>".$uname."</td>
									<td align='center' style='padding-left:10px;'><a href='?p=user&aksi=delete&user_id=".$userid."' onclick='return navConfirm(this.href);'><img src='images/delete.png' style='border:none;'/></a></td>
								</tr>
								
								";
									
							};	
						?>
					</tbody>
					<tfoot style="background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;">
						<tr>
							<th width="5%"  >No</th>
							<th width="25%" >Nama</th>
							<th width="15%" >Username</th>
							<th width="5%" align="center" >Del</th>
							
						</tr>
						
					</tfoot>
				</table>
				<script type="text/javascript">
				function navConfirm(loc) { 
					if (confirm('Yakin mau ngapus tu user?')) { 
					window.location.href = loc; 
					} 
					return false; 
					} 
				</script>
			<?php
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
	echo "Anda tidak dapat mengakses halaman ini, Silahkan <a href='?p=acc'>login</a> atau <a href='?p=1'>kembali</a> !!!";
}
?>