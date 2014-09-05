<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['uname']))  //untuk cek apakah sudah login
{  
	
			echo "Anda sudah login !!!";
			echo "<meta http-equiv=refresh content='3;url=?p=5'>";
	
}
else //untuk menolak akses langsung melalui url
{
	?>
	<form method="post" action="?p=pacc&aksi=login" name="loginform" id="loginform">  
							<fieldset>  
								<label for="username" class="login-label">Username  </label><input type="text" name="uname" id="uname" class="login-field"/> 
								<label for="password" class="login-label">Password  </label><input type="password" name="paswd" id="paswd" class="login-field"/> 
								<input type="submit" name="login" id="login" value="Login" class="login-button"/>  
							</fieldset>  
						</form> 
						<?php
}
?>				