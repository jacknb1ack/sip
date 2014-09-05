<!-- top bar start -->
		<div id="top-bar">
			<ul class="nav1">
			<?php 
			if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  
						{  
						    ?> 
							<li><a href="?p=pacc&aksi=logout" >Logout</a></li>				
							<?php
						}  
						
						else  
						{  
						    ?> <li><a href="?p=acc" >Login</a></li> <?php
						}  ?>
				
				<li>|</li>
				<li><a href="http://impulse.or.id" target="_blank">Impulse.or.id</a></li>
			</ul>
			
			<ul class="nav2">
			
				<?php 
				if(isset($_SESSION['uname']))
					{ echo "<li>Selamat Datang ".$_SESSION['uname']."</li>"; }
				else
					{
						echo "" ;
					}
				?>
				
			</ul>
		</div>
		<!-- top bar ends -->
		
		<!-- header starts -->
		<div id="header">
			<div id="site-title">
				<h1>Impulse
					<span class="blue-title"><a href="./index.php">YOGYAKARTA</a></span>
				</h1>		
					<span class="slogan">"Institute for Multiculturalism and Pluralism Studies"</span>	
			</div>
				
			
		</div>
		<!-- header ends -->