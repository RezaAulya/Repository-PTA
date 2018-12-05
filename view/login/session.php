<?php
function isLoginSessionExpired() {
	$login_session_duration = 30; 
	$current_time = time(); 
	if(isset($_SESSION['login_time']) and isset($_SESSION["iduserkaryawan"])){  
		if(((time() - $_SESSION['login_time']) > $login_session_duration)){ 
			return true; 
		}else{
			$_SESSION['login_time'] = time();
		} 
	}
	return false;
}
?>