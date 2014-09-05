<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  //untuk cek apakah sudah login
{  
	if($_SESSION['type'] == 0 || $_SESSION['type'] == 3) // code dibawah ini membatasi tipe user yang dapat mengakses
		{
			if($_GET['aksi'] == 'tambah')
			{
			?>
			
			<form method="post" action="?p=pbook&aksi=insert" id="add-form" name="add-form" enctype="multipart/form-data">
				<h2>Form Penambahan Buku</h2><hr />
					<div id="label-style">
						<label for="kode_buku" class="form-label">Kode Buku</label>
						<label for="judul" class="form-label">Judul</label>
						<label for="pengarang" class="form-label">Pengarang</label>
						<label for="penerbit" class="form-label">Penerbit</label>
						<label for="tahun_terbit" class="form-label">Tahun Terbit</label>
						<label for="isbn" class="form-label">ISBN</label>
						<label for="cover" class="form-label">Cover</label>
						<label for="sinopsis" class="form-label">Sinopsis</label>
					</div>
					
					<div id="input-style">
						<input type="text" name="kode_buku" id="kode_buku" class="form-field" value="<?php $val_id = isset($_SESSION['kode_buku']) ? $_SESSION['kode_buku'] : 'X-00'; echo $val_id; ?>" maxlength="4" size="4" onclick="this.value=(this.value == 'X-00' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'X-00' : this.value);"/>
						
						<input type="text" name="judul" id="judul" class="form-field" value="<?php $val_judul = isset($_SESSION['judul']) ? $_SESSION['judul'] : 'Judul...'; echo $val_judul; ?>" size="70" onclick="this.value=(this.value == 'Judul...' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'Judul...' : this.value);"/>
						
						<input type="text" name="pengarang" id="pengarang" class="form-field" value="<?php $val_auth = isset($_SESSION['pengarang']) ? $_SESSION['pengarang'] : 'Pengarang...'; echo $val_auth; ?>" size="40" onclick="this.value=(this.value == 'Pengarang...' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'Pengarang...' : this.value);"/>
						
						<input type="text" name="penerbit" id="penerbit" class="form-field" value="<?php $val_press = isset($_SESSION['penerbit']) ? $_SESSION['penerbit'] : 'Penerbit...'; echo $val_press; ?>." size="40" onclick="this.value=(this.value == 'Penerbit...' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? 'Penerbit...' : this.value);"/>
						
						<input type="text" name="tahun_terbit" id="tahun_terbit" class="form-field" value="<?php $val_year = isset($_SESSION['tahun_terbit']) ? $_SESSION['tahun_terbit'] : '0000'; echo $val_year; ?>" size="4" maxlength="4" onclick="this.value=(this.value == '0000' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? '0000' : this.value);"/>
						
						<input type="text" name="isbn" id="isbn" class="form-field" value="<?php $val_isbn = isset($_SESSION['isbn']) ? $_SESSION['isbn'] : '000-000000-0'; echo $val_isbn; ?>" onclick="this.value=(this.value == '000-000000-0' ? '' : this.value);" onfocus="this.select()" onblur="this.value = (this.value == '' ? '000-000000-0' : this.value);"/>
						
						<input type="file" name="cover" id="cover" class="form-field"/>
						
						<textarea name="sinopsis" id="sinopsis" class="form-field" cols="55" rows="10"><?php $val_sin = isset($_SESSION['sinopsis']) ? $_SESSION['sinopsis'] : ''; echo $val_sin; ?></textarea>
					
					<div style='clear:both;display:block;'></div>
					<input type="submit" name="submit" value="Tambahkan" class="back-button"/>
					<input type=button onclick="javascript:history.back()" value="&#60;&#60; Batal" class="back-button">
					</div>
					
					
				
			</form>
			
			
			<?php
			}
			else
			{
			 include "process/cart.php";    
	
			?>
			
			<h2><a href="?p=buku&aksi=tambah" style="
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
				Tambah Buku</a></h2><div class="clear"></div>
			
			<div class="clear"></div>
			<div id="dynamic">
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
					<thead>
						<tr>
							<th width="1%" rowspan="2">No</th>
							<th width="5%" rowspan="2">Kode Buku</th>
							<th width="50%" rowspan="2">Judul</th>
							<th width="20%" rowspan="2">Pengarang</th>
							<th width="17%" rowspan="2">Penerbit</th>
							<th width="3%" rowspan="2">Stok</th>
							<th width="4%" colspan="3" align="center">Aksi</th>
						</tr>
						<tr>
							<th>Rent</th>
							<th>Edit</th>
							<th>Del</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="9" class="dataTables_empty">Loading data from server</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">Kode</th>
							<th rowspan="2">Judul</th>
							<th rowspan="2">Pengarang</th>
							<th rowspan="2">Penerbit</th>
							<th rowspan="2">Stok</th>
							<th>Rent</th>
							<th>Edit</th>
							<th>Del</th>
							
						</tr>
						<tr>
							<th colspan="3" align="center">Aksi</th>
						</tr>
					</tfoot>
				</table>
				
			<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					"bJQueryUI": true,
				
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "process/book-list.php",
					"aoColumns": [
						null,
						null,
						null,
						null,
						null,
						null,
						{
						"mData": null,
						"fnRender": function (oObj) 
							{
							return '<a href="?p=pinjam&aksi=tambah&book_id=' + oObj.aData[1] + '" ><img src="images/add.png"  style="margin:0 auto; border:none;"/></a>'
							}
						},
						{
						"mData": null,
						"fnRender": function (oObj) 
							{
							return '<a href="?p=pbook&aksi=edit&book_id=' + oObj.aData[1] + '" ><img src="images/edit.png" style="margin:0 auto; border:none;"/></a>'
							}
						},
						{
						"mData": null,
						"fnRender": function (oObj) 
							{
							return "<a href='?p=pbook&aksi=delete&book_id=" + oObj.aData[1] + "' onclick='return navConfirm(this.href);'><img src='images/delete.png' style='margin:0 auto; border:none;'/></a>"
							}
						}
						
					]
				} );
			} );



			function navConfirm(loc) { 
			if (confirm('Yakin mau ngapus tu buku?')) { 
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