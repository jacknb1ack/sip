<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  //untuk cek apakah sudah login
{  
	if($_SESSION['type'] == 0) // code dibawah ini menampilkan menu untuk admin
		{
			?>
			 <div id="nav">
				<ul class="nav_link">
					<li><a href="?p=home" >Home</a></li>			
					<li class="withdiv"><a href="?p=buku" >Buku</a></li>			
					<li class="withdiv"><a href="?p=report" >Report</a></li>			
					<li class="withdiv"><a href="?p=user" >User</a></li>			
					<li class="withdiv"><a href="?p=member" >Member</a></li>			
					<li class="withdiv"><a href="?p=transaksi" >Transaksi</a></li>			
				</ul>
			</div>
			<?php
		}
	
	elseif($_SESSION['type'] == 1) // code dibawah ini menampilkan menu untuk owner
		{
			?>
			<div id="nav">
				<ul class="nav_link">
					<li><a href="?p=home" >Home</a></li>			
					<!--<li class="withdiv"><a href="?p=report" >Report</a></li>	-->		
					<li class="withdiv"><a href="?p=user" >User</a></li>		
				</ul>
			</div>
			<?php
		}
	else // code dibawah ini menampilkan menu untuk operator
		{
			?>
			<div id="nav">
				<ul class="nav_link">
					<li><a href="?p=home" >Home</a></li>			
					<li class="withdiv"><a href="?p=buku" >Buku</a></li>			
					<li class="withdiv"><a href="?p=member" >Member</a></li>			
					<li class="withdiv"><a href="?p=transaksi" >Transaksi</a></li>		
				</ul>
			</div>
			<?php
		}
}

?>		