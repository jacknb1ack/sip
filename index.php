<?php
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();
	date_default_timezone_set("Asia/Jakarta");
	include "include/connect.php" ;
	
	include "include/gets.php";
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Perpustakaan Impulse Yogyakarta</title>

	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8"/>
	<meta http-equiv="content-style-type" content="text/css"/>
	
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="plugins/jquery-ui.css"> 
	<link rel="stylesheet" type="text/css" href="plugins/datatable/themes/ui-lightness/jquery-ui-1.8.4.custom.css"> 
	<link rel="stylesheet" type="text/css" href="plugins/datatable/css/jquery.dataTables.css"> 
	<link rel="stylesheet" type="text/css" href="plugins/datatable/css/jquery.dataTables_themeroller.css"> 
	
	<script type="text/javascript" src="plugins/jquery.js"></script>
	<script type="text/javascript" src="plugins/jquery.min.js"></script>
	<script type="text/javascript" src="plugins/jquery-ui.js"></script>
	<script type="text/javascript" src="plugins/datatable/js/jquery.dataTables.js"></script> 
	


</head>

<body>
	<!-- main container start -->
	<div id="container">
		<!--header start-->
		<?php include "include/header.php"; ?>
		<!--header end-->
		
		
		<!-- navigation start -->
		<?php include "include/nav.php"; ?>
		<!-- navigations ends -->
		
		<!-- content start -->
		<div id="content">
			<!-- actual content start -->
			<div id="left">
				<!-- post start -->
				<div class="a-post">
					
					
					<div class="post-title">
						<!--<h2>Katalog Buku Perpustakaan Impulse</h2>-->
											
					</div>
					
					<div class="clear"></div>
					
					<div class="post-desc">
					<?php
						if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  
						{  
						   
								
								 if(!isset($_GET['p']))
								{
								include $pages['home'].".php";
								}
																
								else { 	 
								include $pages[$_GET['p']].".php"; 
								}
						}
						
						else  
						{  
						    if(!isset($_GET['p']))
								{
								
								include $pages['catalog'].".php";											}
																
								else { 	 
								include $pages[$_GET['p']].".php"; 
								}
						}  

				
				
					
					?>
						
					</div>
				</div>
				<!-- post end -->
			</div>		
			<!-- actual content end -->
			
			
		</div>
		<!-- content end -->
	</div>
	<!-- main container ends -->
	
	<!-- footer starts --> 
	<?php include "include/footer.php"; ?>
	<!-- footer ends -->
	
</body>
</html>