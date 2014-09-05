<?php

	if($_GET['aksi'] == login)
	{
		 $uname = mysql_real_escape_string($_POST['uname']);  
		 $paswd = md5(mysql_real_escape_string($_POST['paswd']));  
		 $checklogin = mysql_query("SELECT * FROM users WHERE uname = '".$uname."' AND paswd = '".$paswd."'");  
		 if(mysql_num_rows($checklogin) == 1)  
	    {  
	        $row = mysql_fetch_array($checklogin);  
	        $type = $row['type'];  
	        $_SESSION['uname'] = $uname;  
	        $_SESSION['type'] = $type;  
	        $_SESSION['LoggedIn'] = 1; 
			 
	        echo "<meta http-equiv='refresh' content='=2;index.php' />";  
	    }  
	    else  
	    {  
	        echo "<h1>Error</h1>";  
	        echo "<p>Maaf, Username atau Password yang anda masukkan salah. Silahkan  <a href=\"?p=acc\">Klik untuk coba lagi</a>.</p>";  
	    }	
	}
	elseif($_GET['aksi'] == logout)
	{
		session_destroy();

		echo "<center><h2>Anda telah berhasil Logout</h2></center>";

		echo "<meta http-equiv=refresh content='1;url=index.php'>";
	}
	
	else
	{
		echo "<center><h2>Anda Tidak Dapat Mengakses Langsung Halaman Ini !!!</h2></center>";

		echo "<meta http-equiv=refresh content='1;url=index.php'>";
	}

?>		