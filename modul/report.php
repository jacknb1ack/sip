<p style='padding:10px; border-radius: 5px; background-color: #F7B64A; text-align:center; font-size:12px; font-weight:bold; height:15px; color: blue;'>Pilih Jenis Laporan :</p><br />
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  //untuk cek apakah sudah login
{
$now = date("Y");	
?>
<h2><a href="?p=report&option=periodic&tahun=<?php echo $now; ?>" style="
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
				Laporan Periodik</a></h2>
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
				Laporan Umum</a></h2>
				<div class="clear"></div>
<?php  
	if($_SESSION['type'] == 0 || $_SESSION['type'] == 1)  // code dibawah ini membatasi tipe user yang dapat mengakses
		{
			if($_GET['option'] == 'periodic')
			{
				
			$tahun = $_GET['tahun'];
			?>
			<p style='padding:10px; border-radius: 5px; background-color: #F7B64A; text-align:center; font-size:12px; font-weight:bold; height:15px; color: blue;'>Pilih Tahun :</p><br />
			<?php
			for($a = 2013; $a < 2025; $a++){
				echo "<a href='?p=report&option=periodic&tahun=".$a."' class='back-button' style='margin:5px;'>".$a."</a>";
				}
				echo "<div class='clear'></div>";
				?>
				
				<p style='padding:10px; border-radius: 5px; background-color: #F7B64A; text-align:center; font-size:16px; font-weight:bold; height:30px; color: blue;'>Laporan Perpustakaan Impulse Tahun <?php echo $tahun; ?></p><br />
				<!--Laporan untuk transaksi-->
				
				<div style='width: auto; margin:0 auto; display: block; float: left;'>
				   <table cellpadding="5px;">
						<thead>
							<tr>
								<th colspan='4' style='padding:15px; background-color: #416BCD; text-align:center; font-size:16px; font-weight:bold;  color:#ffffff;'>Transaksi Selama Tahun <?php echo $tahun; ?></th>
							</tr>
							<tr style='padding:15px; background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
								<th style="width: auto; padding: 5px 10px;">No</th>
								<th style="width: auto; padding: 5px 55px;">Judul</th>
								<th style="width: auto; padding: 5px 100px;">Keterangan</th>
								<th style="width: auto; padding: 5px 30px;">Nilai</th>
							</tr>
						</thead>
						<tbody style='padding: 2px; margin:2px 5px; background-color: #a4a6a6; text-align: center; font-size: 12px; color: #091697; vertical-align: middle; height: 20px; border: 1px solid black;'>
					
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">1</td>
								<td style="border-right: 1px solid;">Jumlah Peminjaman</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Peminjaman</td>	
								<td><?php $rent_total = mysql_num_rows(mysql_query("SELECT * FROM pinjam WHERE YEAR(tgl_pinjam)='$tahun'")); echo $rent_total; ?></td>	
							</tr>
							
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">2</td>
								<td style="border-right: 1px solid;">Jumlah Pengembalian</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Pengembalian</td>	
								<td><?php $back_total = mysql_num_rows(mysql_query("SELECT * FROM kembali WHERE YEAR(tgl_kembali)='$tahun'")); echo $back_total; ?></td>	
							</tr>
							
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">3</td>
								<td style="border-right: 1px solid;">Jumlah Transaksi</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Transaksi</td>	
								<td><?php echo $rent_total+$back_total; ?></td>	
							</tr>
							
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">4</td>
								<td style="border-right: 1px solid;">Jumlah Denda</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Denda</td>	
								<td><?php $denda = mysql_fetch_assoc(mysql_query("SELECT SUM(denda) AS total_denda FROM kembali WHERE YEAR(tgl_kembali)='$tahun'")); echo "Rp. ".$denda['total_denda']; ?></td>	
							</tr>
							
							<?php
							$bulan = array(1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September');
							for($x = 1; $x < 10; $x++){
							?>
							<tr style='padding:15px; background-color: #F7B64A; text-align: left; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
								<td colspan="4"><?php echo $x.". ".$bulan[$x]; ?></td>	
							</tr>
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">1</td>
								<td style="border-right: 1px solid;">Jumlah Peminjaman</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Peminjaman</td>	
								<td><?php $rent_total = mysql_num_rows(mysql_query("SELECT * FROM pinjam WHERE MONTH(tgl_pinjam)='0$x' AND YEAR(tgl_pinjam)='$tahun'")); echo $rent_total; ?></td>	
							</tr>
							
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">2</td>
								<td style="border-right: 1px solid;">Jumlah Pengembalian</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Pengembalian</td>	
								<td><?php $back_total = mysql_num_rows(mysql_query("SELECT * FROM kembali WHERE MONTH(tgl_kembali)='0$x' AND YEAR(tgl_kembali)='$tahun'")); echo $back_total; ?></td>	
							</tr>
							
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">3</td>
								<td style="border-right: 1px solid;">Jumlah Transaksi</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Transaksi</td>	
								<td><?php echo $rent_total+$back_total; ?></td>	
							</tr>
							
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">4</td>
								<td style="border-right: 1px solid;">Jumlah Denda</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Denda</td>	
								<td><?php $denda = mysql_fetch_assoc(mysql_query("SELECT SUM(denda) AS total_denda FROM kembali WHERE MONTH(tgl_kembali)='0$x' AND YEAR(tgl_kembali)='$tahun'")); echo "Rp. ".$denda['total_denda']; ?></td>	
							</tr>
							<?php
							}
							?>
							<?php
							$bulan = array(10 => 'Oktober','November','Desember');
							for($x = 10; $x < 13; $x++){
							?>
							<tr style='padding:15px; background-color: #F7B64A; text-align: left; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
								<td colspan="4"><?php echo $x.". ".$bulan[$x]; ?></td>	
							</tr>
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">1</td>
								<td style="border-right: 1px solid;">Jumlah Peminjaman</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Peminjaman</td>	
								<td><?php $rent_total = mysql_num_rows(mysql_query("SELECT * FROM pinjam WHERE MONTH(tgl_pinjam)='$x' AND YEAR(tgl_pinjam)='$tahun'")); echo $rent_total; ?></td>	
							</tr>
							
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">2</td>
								<td style="border-right: 1px solid;">Jumlah Pengembalian</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Pengembalian</td>	
								<td><?php $back_total = mysql_num_rows(mysql_query("SELECT * FROM kembali WHERE MONTH(tgl_kembali)='$x' AND YEAR(tgl_kembali)='$tahun'")); echo $back_total; ?></td>	
							</tr>
							
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">3</td>
								<td style="border-right: 1px solid;">Jumlah Transaksi</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Transaksi</td>	
								<td><?php echo $rent_total+$back_total; ?></td>	
							</tr>
							
							<tr style="border-bottom: 1px solid;">	
								<td style="border-right: 1px solid;">4</td>
								<td style="border-right: 1px solid;">Jumlah Denda</td>	
								<td style="border-right: 1px solid;">Jumlah Seluruh Denda</td>	
								<td><?php $denda = mysql_fetch_assoc(mysql_query("SELECT SUM(denda) AS total_denda FROM kembali WHERE MONTH(tgl_kembali)='$x' AND YEAR(tgl_kembali)='$tahun'")); echo "Rp. ".$denda['total_denda']; ?></td>	
							</tr>
							<?php
							}
							?>	
						</tbody>
						<tfoot>
							<tr style='background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
								<th >No</th>
								<th >Judul</th>
								<th >Keterangan</th>
								<th >Nilai</th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class='clear'></div>	
				<?php					
				
			}
			else
			{
			?>
			<p style='padding:10px; border-radius: 5px; background-color: #F7B64A; text-align:center; font-size:16px; font-weight:bold; height:30px; color: blue;'>Laporan Perpustakaan Impulse</p><br />
			<!--Laporan untuk buku-->
			<div style='width: auto; margin:0 auto; display: block; float: left;'>
			   <table cellpadding="5px;">
					<thead>
						<tr>
							<th colspan='4' style='padding:15px; background-color: #416BCD; text-align:center; font-size:16px; font-weight:bold;  color:#ffffff;'>Buku</th>
						</tr>
						<tr style='padding:15px; background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
							<th style="width: auto; padding: 5px 5px;">No</th>
							<th style="width: auto; padding: 5px 30px;">Judul</th>
							<th style="width: auto; padding: 5px 100px;">Keterangan</th>
							<th style="width: auto; padding: 5px 100px;">Nilai</th>
						</tr>
					</thead>
					<tbody style='padding: 2px; margin:2px 5px; background-color: #a4a6a6; text-align: center; font-size: 12px; color: #091697; vertical-align: middle; height: 20px; border: 1px solid black;'>
					<?php
						$book =mysql_fetch_array(mysql_query("SELECT * FROM buku ORDER BY dipinjam DESC"));
					?>
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">1</td>
							<td style="border-right: 1px solid;">Jumlah Buku</td>	
							<td style="border-right: 1px solid;">Jumlah Seluruh Buku</td>	
							<td><?php $book_total = mysql_num_rows(mysql_query("SELECT * FROM buku")); echo $book_total." Buku"; ?></td>	
						</tr>
						
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">2</td>
							<td style="border-right: 1px solid;">Buku Tersedia</td>	
							<td style="border-right: 1px solid;">Jumlah Buku Tersedia di Perpustakaan</td>	
							<td><?php $book_ready = mysql_num_rows(mysql_query("SELECT * FROM buku WHERE stok>0")); echo $book_ready." Buku"; ?></td>	
						</tr>
						
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">3</td>
							<td style="border-right: 1px solid;">Buku Dipinjam</td>	
							<td style="border-right: 1px solid;">Jumlah Buku Dipinjam</td>	
							<td><?php echo $book_total - $book_ready." Buku"; ?></td>	
						</tr>
						
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">4</td>
							<td style="border-right: 1px solid;">Buku Favorit</td>	
							<td style="border-right: 1px solid;">Buku Paling Sering Dipinjam</td>	
							<td><?php echo $book['judul']; ?></td>	
						</tr>
							
					</tbody>
					<tfoot>
						<tr style='background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
							<th >No</th>
							<th >Judul</th>
							<th >Keterangan</th>
							<th >Nilai</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class='clear'></div>	

			<!--Laporan untuk anggota-->
			<div style='width: auto; margin:25px auto; display: block; float: left;'>
			   <table cellpadding="5px;">
					<thead>
						<tr>
							<th colspan='4' style='padding:15px; background-color: #416BCD; text-align:center; font-size:16px; font-weight:bold;  color:#ffffff;'>Anggota</th>
						</tr>
						<tr style='padding:15px; background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
							<th style="width: auto; padding: 5px 10px;">No</th>
							<th style="width: auto; padding: 5px 40px;">Judul</th>
							<th style="width: auto; padding: 5px 100px;">Keterangan</th>
							<th style="width: auto; padding: 5px 30px;">Nilai</th>
						</tr>
					</thead>
					<tbody style='padding: 2px; margin:2px 5px; background-color: #a4a6a6; text-align: center; font-size: 12px; color: #091697; vertical-align: middle; height: 20px; border: 1px solid black;'>
				
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">1</td>
							<td style="border-right: 1px solid;">Jumlah Anggota</td>	
							<td style="border-right: 1px solid;">Jumlah Seluruh Anggota</td>	
							<td><?php $member_total = mysql_num_rows(mysql_query("SELECT * FROM anggota")); echo $member_total; ?></td>	
						</tr>
						
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">2</td>
							<td style="border-right: 1px solid;">Anggota Aktif</td>	
							<td style="border-right: 1px solid;">Anggota Paling Sering Meminjam</td>	
							<td><?php $member =mysql_fetch_array(mysql_query("SELECT * FROM anggota ORDER BY meminjam DESC")); echo $member['nama']; ?></td>	
						</tr>
						
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">3</td>
							<td style="border-right: 1px solid;">Anggota Terbaru</td>	
							<td style="border-right: 1px solid;">Anggota Terbaru</td>	
							<td><?php $member =mysql_fetch_array(mysql_query("SELECT * FROM anggota ORDER BY no_urut DESC")); echo $member['nama']; ?></td>	
						</tr>
							
					</tbody>
					<tfoot>
						<tr style='background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
							<th >No</th>
							<th >Judul</th>
							<th >Keterangan</th>
							<th >Nilai</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class='clear'></div>	

			<!--Laporan untuk transaksi-->
			<div style='width: auto; margin:0 auto; display: block; float: left;'>
			   <table cellpadding="5px;">
					<thead>
						<tr>
							<th colspan='4' style='padding:15px; background-color: #416BCD; text-align:center; font-size:16px; font-weight:bold;  color:#ffffff;'>Transaksi</th>
						</tr>
						<tr style='padding:15px; background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
							<th style="width: auto; padding: 5px 10px;">No</th>
							<th style="width: auto; padding: 5px 55px;">Judul</th>
							<th style="width: auto; padding: 5px 100px;">Keterangan</th>
							<th style="width: auto; padding: 5px 30px;">Nilai</th>
						</tr>
					</thead>
					<tbody style='padding: 2px; margin:2px 5px; background-color: #a4a6a6; text-align: center; font-size: 12px; color: #091697; vertical-align: middle; height: 20px; border: 1px solid black;'>
				
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">1</td>
							<td style="border-right: 1px solid;">Jumlah Peminjaman</td>	
							<td style="border-right: 1px solid;">Jumlah Seluruh Peminjaman</td>	
							<td><?php $rent_total = mysql_num_rows(mysql_query("SELECT * FROM pinjam")); echo $rent_total; ?></td>	
						</tr>
						
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">2</td>
							<td style="border-right: 1px solid;">Jumlah Pengembalian</td>	
							<td style="border-right: 1px solid;">Jumlah Seluruh Pengembalian</td>	
							<td><?php $back_total = mysql_num_rows(mysql_query("SELECT * FROM kembali")); echo $back_total; ?></td>	
						</tr>
						
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">3</td>
							<td style="border-right: 1px solid;">Jumlah Transaksi</td>	
							<td style="border-right: 1px solid;">Jumlah Seluruh Transaksi</td>	
							<td><?php echo $rent_total+$back_total; ?></td>	
						</tr>
						
						<tr style="border-bottom: 1px solid;">	
							<td style="border-right: 1px solid;">4</td>
							<td style="border-right: 1px solid;">Jumlah Denda</td>	
							<td style="border-right: 1px solid;">Jumlah Seluruh Denda</td>	
							<td><?php $denda = mysql_fetch_assoc(mysql_query("SELECT SUM(denda) AS total_denda FROM kembali")); echo "Rp. ".$denda['total_denda']; ?></td>	
						</tr>
						
						
						
						
							
					</tbody>
					<tfoot>
						<tr style='background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
							<th >No</th>
							<th >Judul</th>
							<th >Keterangan</th>
							<th >Nilai</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class='clear'></div>	
			<?php
			}
		}
	
	else // code dibawah untuk tipe user yang tidak memiliki akses
		{
			echo "Anda tidak dapat mengakses halaman ini !!!";
			echo "<meta http-equiv=refresh content='3;url=?p=5'>";
		}
}
else //untuk menolak akses langsung melalui url
{
	echo "<h2>Anda tidak dapat mengakses halaman ini !!! >/h2><br />	<input type=button onclick=\"javascript:history.back()\" value=\"&#60;&#60; Kembali\" class=\"back-button\"> ";
	echo "atau <button class=\"back-button\"><a href='?p=acc'>Login</a></button> ";
}
?>