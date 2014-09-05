<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  //untuk cek apakah sudah login
{  
	if($_SESSION['type'] == 0 || $_SESSION['type'] == 3) // code dibawah ini membatasi tipe user yang dapat mengakses
		{ ?>
		<h2><a href="?p=transaksi&aksi=kembali" style="
													display: inline-block;
													background-color: #cccccc;
													float: left;
													width: auto;
													padding: 0 20px;
													margin-bottom: 5px;
													margin-right: 5px;
													text-align: center;
													font-size: 14px;
													font-style: normal;
													border-radius: 4px;
												    color: blue;
												    													   ">
				Daftar Pengembalian Buku</a></h2>
<h2><a href="?p=transaksi&aksi=belum_kembali" style="
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
				Daftar Peminjaman Buku</a></h2>
				<div class="clear"></div>
		<?php
			
		$aksi = $_GET['aksi'];
		switch($aksi){
			case "renew":
			$trans_id = $_GET['trans_id'];
			// query SQL untuk menampilkan data sesuai id
			$query = "SELECT * FROM pinjam WHERE no='$trans_id'";

			$result = mysql_query($query) or die('Error');
			
			while ($list = mysql_fetch_array($result)) {
				$books = unserialize($list['kode_buku']);
				$book_hidden = implode(' ', $books);
				
				?>
				<form method="post" action="?p=transaksi&aksi=insert&rent_id=<?php echo $trans_id; ?>" id="add-form" name="add-form">
				<h2>Form Perpanjangan Peminjaman Buku</h2><hr />
					<div id="label-style">
						<label for="no_anggota" class="form-label">No Anggota</label>
						<label for="operator" class="form-label">Operator</label>
						<label for="kode_buku" class="form-label">Buku</label>
						
					</div>
					
					<div id="input-style">
						<input type="text" name="no_anggota" id="no_anggota" class="form-field" value="<?php echo $list['no_anggota']; ?>" maxlength="16" size="16" />
							
						<!--	<input type="text" name="kode_buku" id="kode_buku" class="form-field" value="<?php echo $book; ?>" size="25"/>-->
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
							foreach($books as $book)
							{
								//$result=mysql_query("SELECT judul FROM buku WHERE kode_buku='$book'");
								$list = mysql_fetch_array(mysql_query("SELECT judul FROM buku WHERE kode_buku='$book'"));
								echo "<input type='checkbox' name='judul[]' id='judul[]' value='".$book."'><span style='color:blue; font-weight:bold;'>".$list['judul']."</span></input><br/>";
								
							}
							echo "<input type='hidden' name='kode_hidden' id='kode_hidden' value='".$book_hidden."'/>";
							?>
							
						</select>								
					<div style='clear:both;display:block;'></div>
					<input type="submit" name="submit" value="Renew" class="back-button"/>
					<input type=button onclick="javascript:history.back()" value="&#60;&#60; Batal" class="back-button">
					</div>
					
				</form>
				<?php
			} 
				break;
			
			case "insert":
				$rent_id = $_GET['rent_id'];
			   	$date = date("Y-m-d");
				$due = date('Y-m-d',strtotime("+6 day")); 
				$anggota = $_POST['no_anggota'];
				$kode_buku = $_POST['judul'];
				$operator = $_POST['operator'];
								
				$buku = serialize($kode_buku);
				
				// bikin supaya bisa cuma renew beberapa buku
				$buku_hidden = $_POST['kode_hidden'];
				$buku_raw = implode(' ',$_POST['judul']);
				$buku_asal = str_replace($buku_raw, "", $buku_hidden);
				$buku_kembali = explode(' ', $buku_asal);
				foreach($buku_kembali as $kembali)
				{
					mysql_query("UPDATE buku SET stok=stok+1 WHERE kode_buku='$kembali'");
				}
						
				foreach($kode_buku as $kode)
				{
					mysql_query("UPDATE buku SET stok=if(stok > 1,stok-1,0),dipinjam=dipinjam+1 WHERE kode_buku='$kode'");
				}
				
				$query="INSERT INTO pinjam(no_anggota,kode_buku,tgl_pinjam,tgl_habis,pemberi)
						VALUES('$anggota','$buku','$date','$due','$operator')";
				
				mysql_query($query);
				
				if(mysql_affected_rows()>0)
				{	
					mysql_query("UPDATE pinjam SET status=1 WHERE no='$rent_id' ");	
					mysql_query("update anggota set meminjam=meminjam+1 where no_anggota='$anggota'");
				   	echo "<meta http-equiv=refresh content='0;url=?p=transaksi'>";
					
				}
				break;
				
			case "return":
				$trans_id = $_GET['trans_id'];
			
				$list = mysql_fetch_array(mysql_query("SELECT * FROM pinjam WHERE no='$trans_id'"));
				$tgl_habis = $list['tgl_habis'];
				$now = date("Y-m-d");
				$operator = $_SESSION['uname'];
				
				$books = unserialize($list['kode_buku']);
				$jumlah = count($books);
				
				// script menghitung selisih tanggal thanks to http://blog.rosihanari.net/mencari-selisih-hari-dari-dua-buah-tanggal-dengan-php-tanpa-query-sql/
				$pecah1 = explode("-", $now);
				$date1 = $pecah1[2];
				$month1 = $pecah1[1];
				$year1 = $pecah1[0];

				// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
				// dari tanggal kedua

				$pecah2 = explode("-", $tgl_habis);
				$date2 = $pecah2[2];
				$month2 = $pecah2[1];
				$year2 =  $pecah2[0];

				// menghitung JDN dari masing-masing tanggal

				$jd1 = GregorianToJD($month1, $date1, $year1);
				$jd2 = GregorianToJD($month2, $date2, $year2);

				// hitung selisih hari kedua tanggal

				$selisih = $jd1 - $jd2;
				
				
				if($selisih > 0) {
					$denda = $selisih * 1000 * $jumlah;
				} else {
					$denda = '0';
				}
							
				mysql_query("INSERT INTO kembali(no_pinjam,tgl_kembali,penerima,denda) VALUES('$trans_id','$now','$operator','$denda')");
				if(mysql_affected_rows()>0)
					{		
					   	mysql_query("UPDATE pinjam SET status=1 WHERE no='$trans_id' ");
						foreach($books as $book)
						{
							mysql_query("UPDATE buku SET stok=stok+1 WHERE kode_buku='$book'");
						}	
						echo "<meta http-equiv=refresh content='0;url=?p=transaksi'>";
					}
				break;
			
			case "belum_kembali":
			?>
				<table class="display" id="example" cellpadding="0" cellspacing="0" border="0" >
				
					<thead>
						<tr>
							<th colspan="8" style="font-size: 24px; color:#150c8b; text-align: center; padding-top: 12px; height: 30px;">Data Peminjaman Buku</th>
						</tr>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">Peminjam</th>
							<th rowspan="2">Tgl Habis</th>
							<th rowspan="2">Petugas</th>
							<th rowspan="2">Buku</th>
							<th rowspan="2">Denda</th>
							<th colspan="2" align="center">Aksi</th>
						</tr>
						<tr>
							<th width="5px">Renew</th>
							<th width="5px">Return</th>
						</tr>
					</thead>	
					<tbody>
					<?php
					$query = 	"SELECT p.*, a.nama 
								FROM pinjam p, anggota a
								WHERE a.no_anggota = p.no_anggota AND status=0
								
								";


					$result = mysql_query($query) or die('Data tidak tersedia !!!');
					while ($list = mysql_fetch_array($result)) 
						{
							$no = $list['no'];
							$member = $list['nama'];
							$tgl_pinjam = $list['tgl_pinjam'];
							$tgl_habis = $list['tgl_habis'];
							$now = date("Y-m-d");
							$operator = $list['pemberi'];
							$books = unserialize($list['kode_buku']);
							$jumlah = count($books);
							
							// script menghitung selisih tanggal thanks to http://blog.rosihanari.net/mencari-selisih-hari-dari-dua-buah-tanggal-dengan-php-tanpa-query-sql/
							$pecah1 = explode("-", $now);
							$date1 = $pecah1[2];
							$month1 = $pecah1[1];
							$year1 = $pecah1[0];

							// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
							// dari tanggal kedua

							$pecah2 = explode("-", $tgl_habis);
							$date2 = $pecah2[2];
							$month2 = $pecah2[1];
							$year2 =  $pecah2[0];

							// menghitung JDN dari masing-masing tanggal

							$jd1 = GregorianToJD($month1, $date1, $year1);
							$jd2 = GregorianToJD($month2, $date2, $year2);

							// hitung selisih hari kedua tanggal

							$selisih = $jd1 - $jd2;
							
							
							if($selisih > 0) {
								$denda = $selisih * 1000 * $jumlah;
							} else {
								$denda = '0';
							}
							
							
									echo "<tr>";
									echo "<td>".$no ."</td>";
									echo "<td>".$member ."</td>";
									
									echo "<td>".$tgl_habis ."</td>";
									echo "<td>".$operator ."</td>";
									
									echo "<td>";
									foreach($books as $book)
									{
										$querys = mysql_fetch_array(mysql_query("select judul from buku where kode_buku='$book'"));
										echo $querys['judul']."<br />";
									}
									echo "</td>";
									echo "<td> Rp. ".$denda ."</td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "</tr>";
									
								
							
						
						}
							
							

					?>
						</tbody>
						<tfoot>
						
						<tr>
							<th >No</th>
							<th >Peminjam</th>
							<th >Tgl Habis</th>
							<th >Petugas</th>
							<th >Buku</th>
							<th >Denda</th>
							<th colspan="2" align="center">Aksi</th>
							
							
						</tr>
						
						
					</tfoot>	
				</table>
				<script type="text/javascript">
				$(document).ready(function() {
					$('#example').dataTable({
						"bJQueryUI": true,
						"aaSorting": [[0,'desc']],
						"bAutoWidth": false,
						"aoColumns": [
							null,
							null,
							null,
							null,
							{
								"bSortable": false
							},
							{
								"bSortable": false
							},
							{
							"mData": null,
							"bSortable": false,
							"fnRender": function (oObj) 
								{
								return '<a href="?p=transaksi&aksi=renew&trans_id=' + oObj.aData[0] + '" ><img src="images/update.png" style="border:none;"/></a>'
								}
							},
							{
							"mData": null,
							"bSortable": false,
							"fnRender": function (oObj) 
								{
								return "<a href='?p=transaksi&aksi=return&trans_id=" + oObj.aData[0] + "' onclick='return navConfirm(this.href);'><img src='images/success.png' style='border:none;'/></a>"
								}
							}
							
						]				
					});
					
					});
				</script>
				<?php
				break;
				
			case "kembali":
			?>
			<table class="display" id="example" cellpadding="0" cellspacing="0" border="0" >
			
				<thead>
					<tr>
						<th colspan="8" style="font-size: 24px; color:#150c8b; text-align: center; padding-top: 12px; height: 30px;">Daftar Pengembalian Buku</th>
					</tr>
					<tr>
						<th>No</th>
						<th>Tgl Pinjam</th>
						<th>Tgl Kembali</th>
						<th>Op. Penerima</th>
						<th>Denda</th>
					</tr>
					
				</thead>	
				<tbody>
				<?php
				$query = 	"SELECT k.*, p.tgl_pinjam
							FROM pinjam p, kembali k
							WHERE p.no = k.no_pinjam
							
							";


				$result = mysql_query($query) or die('Data tidak tersedia !!!');
				while ($list = mysql_fetch_array($result)) 
					{
						$no = $list['no'];
						$tgl_pinjam = $list['tgl_pinjam'];
						$tgl_kembali = $list['tgl_kembali'];
						$operator = $list['penerima'];
						$denda = $list['denda'];
			
							echo "<tr>";
							echo "<td>".$no ."</td>";
							echo "<td>".$tgl_pinjam ."</td>";
							echo "<td>".$tgl_kembali ."</td>";
							echo "<td>".$operator ."</td>";
							echo "<td> Rp. ".$denda ."</td>";
							echo "</tr>";
					
					}
				?>
					</tbody>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Tgl Pinjam</th>
							<th>Tgl Kembali</th>
							<th>Op. Penerima</th>
							<th>Denda</th>
						</tr>
					</tfoot>	
			</table>
			<script type="text/javascript">
			$(document).ready(function() {
				$('#example').dataTable({
					"bJQueryUI": true,
					"aaSorting": [[0,'desc']],
					"bAutoWidth": false
								
				});
				
				});
			</script>
			<?php
				break;
				
			default:
			?>
			<table class="display" id="example" cellpadding="0" cellspacing="0" border="0" >
			
				<thead>
					<tr>
						<th colspan="8" style="font-size: 24px; color:#150c8b; text-align: center; padding-top: 12px; height: 30px;">History Transaksi</th>
					</tr>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Tgl Pinjam</th>
						<th>Tgl Kembali</th>
						<th>Op. Pemberi</th>
						<th>Op. Penerima</th>
						<th>Buku</th>
						<th>Denda</th>
					</tr>
					
				</thead>	
				<tbody>
				<?php
				$query = 	"SELECT p.*, k.*, a.nama
							FROM pinjam p, kembali k, anggota a
							WHERE p.no = k.no_pinjam AND a.no_anggota = p.no_anggota
							
							";


				$result = mysql_query($query) or die('Data tidak tersedia !!!');
				while ($list = mysql_fetch_array($result)) 
					{
						$no = $list['no'];
						$nama = $list['nama'];
						$tgl_pinjam = $list['tgl_pinjam'];
						$tgl_kembali = $list['tgl_kembali'];
						$pemberi = $list['pemberi'];
						$penerima = $list['penerima'];
						$denda = $list['denda'];
						$books = unserialize($list['kode_buku']);
			
							echo "<tr>";
							echo "<td>".$no ."</td>";
							echo "<td>".$nama ."</td>";
							echo "<td>".$tgl_pinjam ."</td>";
							echo "<td>".$tgl_kembali ."</td>";
						
							echo "<td>".$pemberi ."</td>";
							echo "<td>".$penerima ."</td>";
							echo "<td>";
							foreach($books as $book)
									{
										$querys = mysql_fetch_array(mysql_query("select judul from buku where kode_buku='$book'"));
										echo $querys['judul']."<br />";
									}
							echo "</td>";
							echo "<td> Rp. ".$denda ."</td>";
							echo "</tr>";
					
					}
				?>
					</tbody>
					<tfoot>
						<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Tgl Pinjam</th>
						<th>Tgl Kembali</th>
						<th>Op. Pemberi</th>
						<th>Op. Penerima</th>
						<th>Buku</th>
						<th>Denda</th>
						</tr>
					</tfoot>	
			</table>
			<script type="text/javascript">
			$(document).ready(function() {
				$('#example').dataTable({
					"bJQueryUI": true,
					"aaSorting": [[0,'desc']],
					"bAutoWidth": false
								
				});
				
				});
			</script>
			<?php
				break;
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