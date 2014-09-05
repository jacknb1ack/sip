<?php 

if($_SESSION['cart']) { //if the cart isn't empty
//show the cart
	$i=0;
   echo "
   <div style='width:360px; margin:0 auto; display:block;'>
   <table style='width:350px; display:block;'>
					<thead>
						<tr>
							<th colspan='3' style='padding:20px; background-color: #416BCD; text-align:center; font-size:16px; font-weight:bold; height:30px; color: blue;'>Daftar buku yang akan dipinjam</th>
						</tr>
						<tr style='background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
							<th width='10%'>No</th>
							<th width='80%'>Judul</th>
							<th width='10%'>Hapus</th>
						</tr>
					</thead>
					<tbody style='background-color: #a4a6a6; text-align: center; font-size: 12px; color: #091697; vertical-align: middle; height: 20px;'>
   ";
	
    //iterate through the cart, the $book_id is the key and $quantity is the value
    foreach($_SESSION['cart'] as $book_id => $quantity) { 

        //get the name, description and price from the database - this will depend on your database implementation.
        //use sprintf to make sure that $book_id is inserted into the query as a number - to prevent SQL injection
        $sql ="SELECT * FROM buku WHERE kode_buku = '$book_id'"; 
		$i++;
        $result = mysql_query($sql);

        //Only display the row if there is a product (though there should always be as we have already checked)
    

            $buku = mysql_fetch_array($result);

            //$line_cost = $price * $quantity; //work out the line cost
            //$total = $total + $line_cost; //add to the total cost
			
            echo 
			"
			<tr>	
			<td>".$i."</td>		
			<td>".$buku['judul']."</td>		
			<td><a href=\"?p=pinjam&aksi=hapus&book_id=$book_id\"><img src='images/delete.png' style='border:none;'></a></td>		
			</tr>		
					
			";
           

        }
	
    
	echo 
		"
		</tbody>
		<tfoot>
			<tr style='background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px;'>
				<th >No</th>
				<th >Judul</th>
				<th >Hapus</th>
			</tr>
			
			
		</tfoot>
		</table>
		<div style='float:left; padding:10px; background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px; margin:5px 0;'>
			<a href=\"?p=pinjam&aksi=proses\" >Proses</a>
		</div>
		
		<div style='float:right; padding:10px; background-color: #cccccc; text-align: center; font-size: 14px; font-weight: bold; color: #02156c; vertical-align: middle; height: 20px; margin:5px 10px;'> 
			<a href='?p=pinjam&aksi=empty' onclick=\"return confirm('Are you sure?');\">Kosongkan</a>
		</div>
			
		</div><div class='clear'></div>
		";
   

    //show the empty cart link - which links to this page, but with an action of empty. A simple bit of javascript in the onlick event of the link asks the user for confirmation
  


}else{
//otherwise tell the user they have no items in their cart
    echo "<p style='padding:10px; border-radius: 5px; background-color: #F7B64A; text-align:center; font-size:16px; font-weight:bold; height:30px; color: blue;'>Belum ada buku yang dipilih !</p><br />";

} 
?>