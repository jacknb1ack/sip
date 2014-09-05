<?php
$id = $_GET['book_id'];

$query = "SELECT * FROM buku WHERE kode_buku='$id'";
$result = mysql_query($query) or die('Data tidak tersedia !!!');
while ($book = mysql_fetch_array($result)) 
	{
		$judul = $book['judul'];
		$pengarang = $book['pengarang'];
		$penerbit = $book['penerbit'];
		$tahun = $book['tahun_terbit'];
		$isbn = $book['isbn'];
		$cover = $book['cover'];
		$sinopsis = $book['sinopsis'];
		$stok = $book['stok'];
		
		
?>

<div class='det-view'>  
<p style='font-weight: bold;font-size: 16px; color: purple'><span>Judul</span>&emsp;:&emsp;<span><?php echo $judul; ?></span></p>   <hr> 
<p><span>Pengarang</span>&emsp;:&emsp;<span><?php echo $pengarang; ?></span></p>     
   
<p><span>Penerbit</span>&emsp;:&emsp;<span><?php echo $penerbit; ?></span></p>     
<p>Tahun Terbit&emsp;:&emsp;<?php echo $tahun; ?></p>  
<p><span>Status</span>&emsp;:&emsp;<span><?php if($stok == 1) { echo "Tersedia"; } else echo "Dipinjam"; ?></span></p> <hr>      
<p><span>Sinopsis :</span></p><br><span><?php echo $sinopsis; ?></span> 
</div> 
<div class='img-view'><?php echo "<a href='images/cover/".$cover."' target='_blank'><img src='images/cover/".$cover."' width='300px' height='400px'/><br>Klik Untuk Memperbesar</a>" ; ?></div>
  
<div style='clear:both;display:block;'></div>
<input type=button onclick="javascript:history.back()" value="&#60;&#60; Kembali" class="back-button">
</div>

<?php }; ?>