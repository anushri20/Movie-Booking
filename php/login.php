<?php 

if(isset($_POST['login-submit'])){
	
	require 'dbh.php';

	$email = $_POST['email'];
	$password = $_POST['password'];

if(empty($email) || empty($password)){
	header("location:formlogin.php?error=emptyfile");
	exit();
}
else{
$sql = "SELECT * FROM user WHERE Email=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
	header("location:formlogin.php?error=sqlerror");
	exit();
}
else{
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($result)) {
		$pwdCheck = $row['password'];
		if($pwdCheck == false){
			header("location:formlogin.php?error=wrongpwd");
			exit();
		}
		else if($pwdCheck == true){
			session_start();
			$_SESSION['userId'] = $row['ID'];
			$_SESSION['userUid'] = $row['Username'];

			header("location:index.php?login=success");
			exit();
		}
		else {
			header("location:formlogin.php?error=wrongpwd");
			exit();
		}
	}
	else{
		header("location:formlogin.php?error=nouser");
		exit();
	}
}
}
}
else{
	header("location:formlogin.php");
}

?>