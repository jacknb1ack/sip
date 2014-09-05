<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  //untuk cek apakah sudah login
{  
	if($_SESSION['type'] == 0 || $_SESSION['type'] == 3) // code dibawah ini membatasi tipe user yang dapat mengakses
		{
			if($_GET['aksi'] == 'tambah')
			{
			?>
			
			<form method="post" action="?p=pmember&aksi=insert" id="add-form" name="add-form" enctype="multipart/form-data">
				<h2>Form Pendaftaran Anggota</h2><hr />
					<div id="label-style">
						<label for="no_anggota" class="form-label">No Anggota</label>
						<label for="nama" class="form-label">Nama Lengkap</label>
						<label for="jenis_id" class="form-label">Jenis ID</label>
						<label for="no_id" class="form-label">No Identitas</label>
						<label for="phone" class="form-label">No Telp</label>
						<label for="foto" class="form-label">Pas Foto</label>
						<label for="alamat" class="form-label">Alamat</label>
					</div>
					
					<div id="input-style">
						<input type="text" name="no_anggota" id="no_anggota" class="form-field" value="<?php $val_id = isset($_SESSION['no_anggota']) ? $_SESSION['no_anggota'] : 'format no anggota'; echo $val_id; ?>" maxlength="16" size="16" onclick="this.value=(this.value == 'format no anggota' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'format no anggota' : this.value);"/>
						
						<input type="text" name="nama" id="nama" class="form-field" value="<?php $val_nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Nama Lengkap...'; echo $val_nama; ?>" size="50" onclick="this.value=(this.value == 'Nama Lengkap...' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'Nama Lengkap...' : this.value);"/>
						
						<!--<input type="text" name="jenis_id" id="jenis_id" class="form-field" value="<?php $val_auth = isset($_SESSION['pengarang']) ? $_SESSION['pengarang'] : 'Pengarang...'; echo $val_auth; ?>" size="40" onclick="this.value=(this.value == 'Pengarang...' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'Pengarang...' : this.value);"/>
						-->
						<select name="jenis_id"  class="form-field">	
							<option value="KTP" <?php $val_id = ($_SESSION['jenis_id'] == 'KTP') ? 'selected="selected"' : ''; echo $val_jenis; ?>>KTP</option>
							<option value="SIM" <?php $val_id = ($_SESSION['jenis_id'] == 'SIM') ? 'selected="selected"' : ''; echo $val_jenis; ?>>SIM</option>
							<option value="KTM/PELAJAR" <?php $val_id = ($_SESSION['jenis_id'] == 'KTM/PELAJAR') ? 'selected="selected"' : ''; echo $val_jenis; ?>>KTM/PELAJAR</option>
						</select>
						
						<input type="text" name="no_id" id="no_id" class="form-field" value="<?php $val_nomer = isset($_SESSION['no_id']) ? $_SESSION['no_id'] : 'no_id...'; echo $val_nomer; ?>" size="20" onclick="this.value=(this.value == 'no_id...' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'no_id...' : this.value);"/>
						
						<input type="text" name="phone" id="phone" class="form-field" value="<?php $val_phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '0XXX-XXXX-XXXX'; echo $val_phone; ?>" size="16" maxlength="16" onclick="this.value=(this.value == '0XXX-XXXX-XXXX' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? '0XXX-XXXX-XXXX' : this.value);"/>
						
						<input type="file" name="foto" id="foto" class="form-field"/>
						
						<textarea name="alamat" id="alamat" class="form-field" cols="40" rows="3"><?php $val_address = isset($_SESSION['alamat']) ? $_SESSION['alamat'] : ''; echo $val_address; ?></textarea>
					
					<div style='clear:both;display:block;'></div>
					<input type="submit" name="submit" value="Tambahkan" class="back-button"/>
					<input type=button onclick="javascript:history.back()" value="&#60;&#60; Batal" class="back-button">
					</div>
					
					
				
			</form>
			
			
			<?php
			}
			elseif($_GET['aksi'] == 'detail')
			{
				//kalau perlu diadain detail untuk member
			}
			else
			{
			?>
			
			<h2><a href="?p=member&aksi=tambah" style="
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
				Tambah Anggota</a></h2><br/>
			<div id="dynamic">
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
					<thead>
						<tr>
							<th width="5%" rowspan="2">No</th>
							<th width="25%" rowspan="2">Nama</th>
							<th width="15%" rowspan="2">No Anggota</th>
							<th width="15%" rowspan="2">Telp</th>
							<th width="4%" colspan="2" align="center">Aksi</th>
						</tr>
						<tr>
							<th>Edit</th>
							<th>Del</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="6" class="dataTables_empty">Loading data from server</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">Nama</th>
							<th rowspan="2">No Anggota</th>
							<th rowspan="2">Telp</th>
							<th></th>
							<th></th>
							
						</tr>
						<tr>
							<th colspan="2" align="center">Aksi</th>
						</tr>
					</tfoot>
				</table>
				
			<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					"bJQueryUI": true,
					
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "process/member-list.php",
					"aoColumns": [
						null,
						null,
						null,
						null,
						/*{
						"mData": null,
						"fnRender": function (oObj) 
							{
							return '<a href="?p=member&aksi=detail&member_id=' + oObj.aData[2] + '" ><img src="images/mag.png"/></a>'
							}
						},*/
						{
						"mData": null,
						"fnRender": function (oObj) 
							{
							return '<a href="?p=pmember&aksi=edit&member_id=' + oObj.aData[2] + '" ><img src="images/edit.png"/></a>'
							}
						},
						{
						"mData": null,
						"fnRender": function (oObj) 
							{
							return "<a href='?p=pmember&aksi=delete&member_id=" + oObj.aData[2] + "' onclick='return navConfirm(this.href);'><img src='images/delete.png'/></a>"
							}
						}
						
					]
				} );
			} );



			function navConfirm(loc) { 
			if (confirm('Yakin mau ngapus tu anggota?')) { 
			window.location.href = loc; 
			} 
			return false; 
			} 


			</script>

			</div>
			<div class="spacer"></div>
			
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
	echo "<h2>Anda tidak dapat mengakses halaman ini !!! >/h2><br />	<input type=button onclick=\"javascript:history.back()\" value=\"&#60;&#60; Kembali\" class=\"back-button\"> ";
	echo "atau <button class=\"back-button\"><a href='?p=acc'>Login</a></button> ";
}
?>