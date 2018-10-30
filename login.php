<?php
include('lib/common.php');
if($showQueries){
    array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}
if( $_SERVER['REQUEST_METHOD'] == 'POST') {

	$enteredEmail = mysqli_real_escape_string($db, $_POST['username']);       // 转义，避免SQL注入
	$enteredPassword = mysqli_real_escape_string($db, $_POST['password']);
	if (empty($enteredEmail)) {
            array_push($error_msg,  "Please enter an email address.");
    }

	if (empty($enteredPassword)) {
			array_push($error_msg,  "Please enter a password.");
	}
	if ( !empty($enteredEmail) && !empty($enteredPassword) )   { 
		$query = "SELECT password FROM User WHERE username='$enteredEmail'";
		$result = mysqli_query($db, $query);
        include('lib/show_queries.php');
		$count = mysqli_num_rows($result);

		if (!empty($result) && ($count > 0) ) {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$storedPassword = $row['password']; 

			$options = [
                'cost' => 8,
            ];

            $storedHash = password_hash($storedPassword, PASSWORD_DEFAULT , $options);
            $enteredHash = password_hash($enteredPassword, PASSWORD_DEFAULT , $options);
            if($showQueries){
                array_push($query_msg, "Plaintext entered password: ". $enteredPassword);
                //Note: because of salt, the entered and stored password hashes will appear different each time
                array_push($query_msg, "Entered Hash:". $enteredHash);
                array_push($query_msg, "Stored Hash:  ". $storedHash . NEWLINE);  //note: change to storedHash if tables store the plaintext password value
                //unsafe, but left as a learning tool uncomment if you want to log passwords with hash values
                //error_log('email: '. $enteredEmail  . ' password: '. $enteredPassword . ' hash:'. $enteredHash);
            }
            if (password_verify($enteredPassword, $storedHash) ) {
                array_push($query_msg, "Password is Valid! ");
                $_SESSION['username'] = $enteredEmail;
                array_push($query_msg, "logging in... ");
                header(REFRESH_TIME . 'url=main_menu.php');		//to view the password hashes and login success/failure

            } else {
            	array_push($error_msg, "Login failed: " . $enteredEmail . NEWLINE);
                array_push($error_msg, "To demo enter: ". NEWLINE . "michael@bluthco.com". NEWLINE ."michael123");
            } 

        } else {
            	array_push($error_msg, "The username entered does not exist: " . $enteredEmail);
            }
    }
}
?>

<?php
header('Cache-Control:no-cache,must-revalidate');
header('Pragma:no-cache');
?>

<?php include("lib/header.php"); ?>
<html>
<head>
    <title>GTBay Login</title>
</head>
<body onload="document.loginform.Username.focus()">
	<div id="main_container">
		<div id="header">
			<div class="logo">
				<img src="img/GTBay-biglogo.png" title="GTBay-biglogo"/>
			</div>
		</div>
		<div class="center_content">
			<div class="text_box">
				<form action="login.php" method="post" name="loginform" enctype="multipart/form-data">
					<div class="title">GTBay Login</div>
					<table class="inputtable" summary="This data table is used to format the user login fields">
						<tr class="login_form_row">
							<td class="login_label" scope="row"><label for=Username><SPAN class="fieldlabeltext"><b>Username</b></SPAN></label></td>
							<td class="login_input"><input type="text" name="username" value="michael@bluthco.com" ID="Username" /></td>

						</tr>
						<tr class="login_form_row">
							<td class="login_label" scope="row"><label for=Password><SPAN class="fieldlabeltext"><b>Password</b></SPAN></label></td>
							<td class="login_input"><input type="text" name="password" value="michael123" ID="Password" /></td>
						</tr>
					</table>
					<button class="button" type="button" onclick="this.form.submit();"><span>Login</span></button>
				</form>
				<div>
					<button class="button" type="button" onclick=window.open("registration.php")><span>Register</span></button>
				</div>
			</div>
            <?php include("lib/error.php");?>
		</div>
	</div>
</body>
</html>
