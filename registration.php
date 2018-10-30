<?php
include('lib/common.php');
// written by mni37

if($showQueries){
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}

//Note: known issue with _POST always empty using PHPStorm built-in web server: Use *AMP server instead
if( $_SERVER['REQUEST_METHOD'] == 'POST') {

	$enteredFirstName = mysqli_real_escape_string($db, $_POST['ufirstname']);
    $enteredLastName = mysqli_real_escape_string($db, $_POST['ulastname']);
    $enteredUsername = mysqli_real_escape_string($db, $_POST['uusername']);
	$enteredPassword = mysqli_real_escape_string($db, $_POST['pass1']);
    $enteredConfirmPassword = mysqli_real_escape_string($db, $_POST['pass2']);

    if (empty($enteredFirstName)) {
//             array_push($error_msg,  "Please enter Firstname.");
//             header("Refresh:3"); 
			$firstnameErr = "First name can not be empty.";
    }

    if (empty($enteredLastName)) {
//         array_push($error_msg,  "Please enter Lastname.");
//         header("Refresh:3"); 
			$lastnameErr = "Last name can not be empty.";
    }

    if (empty($enteredUsername)) {
//         array_push($error_msg,  "Please enter Username.");
//         header("Refresh:3"); 
		$usernameErr = "Username can not be empty.";
    }

    if (empty($enteredPassword)) {
// 			array_push($error_msg,  "Please enter a password.");
// 			header("Refresh:3"); 
			$pass1Err = "Password can not be empty.";
	}

    if (empty($enteredConfirmPassword)) {
//         array_push($error_msg,  "Please enter Confirmed password.");
//         header("Refresh:3"); 
			$pass2Err = "Password can not be empty.";

    }

//    check whether password and confirm password consistent
    if ($enteredPassword != $enteredConfirmPassword) {
//         array_push($error_msg,  "Oops! Password did not match! Try again.");
//         header("Refresh:3"); 
		$pass2Err = "Oops! Password did not match! Try again.";
    }
	
    if ( !empty($enteredFirstName)  && !empty($enteredLastName)  && !empty($enteredUsername) && !empty($enteredPassword) && !empty($enteredConfirmPassword) && $enteredPassword == $enteredConfirmPassword )   {

//        Used to confirm whether the username has been existed or not
        $query = "SELECT username FROM User WHERE username='$enteredUsername'";
        $queryInsert = "INSERT INTO User (username, password, first_name, last_name) VALUES ('$enteredUsername','$enteredPassword', '$enteredFirstName','$enteredLastName')";
        
        $result = mysqli_query($db, $query);
//         echo $result;
        include('lib/show_queries.php');
        $count = mysqli_num_rows($result); 

        $resultRegistration = mysqli_query($db, $queryInsert);
//            To confirm whether the insertion is successful or not, if succed, redirect to menu page
		if($count==1){
			$usernameErr = "Oops, the name has been registered!";			
		}else{
		
        	if($resultRegistration){
//      //          redirection page
				$_SESSION['username'] = $enteredUsername;
				array_push($query_msg,  "Congratulations! You have registered successfully. You are going to Home Page......");
            	header("Refresh:3; url= main_menu.php");
        	}else{
            array_push($error_msg,  mysqli_error($db)."Registration failed!");
            mysqli_close($db);
        	}
        }
    }
}
?>



<?php include("lib/header.php"); ?>
<html>
<head>
    <title>GTBay Registration</title>
</head>
<body>
	<div id="main_container">
		<div id="header">
			<div class="logo">
				<img src="img/GTBay-biglogo.png" title="GTBay-biglogo"/>
			</div>
		</div>

		<div class="center_content">
			<div class="text_box">
				<form action="registration.php" method="post" name="registrationform" enctype="multipart/form-data">
					<div class="title">GTBay Registration</div>
					<table class="inputtable" summary="This data table is used to format the user registration fields">
						<table>
			
						<tr>
							<td class="item_label"><div style="width: 150px;">First Name</div></td>
							<td><input type="text" name="ufirstname"  value="<?php echo isset($_POST["ufirstname"]) ? $_POST["ufirstname"] : ''; ?>"/></td>
							<td><div style="width: 300px;color:red;"><?php echo $firstnameErr;?></div></td>
						</tr>
						<tr>
							<td class="item_label"><div style="width: 150px;">Last Name</div></td>
							<td><input type="text" name="ulastname"  value="<?php echo isset($_POST["ulastname"]) ? $_POST["ulastname"] : ''; ?>"/></td>
							<td><div style="width: 300px;color:red;"><?php echo $lastnameErr;?></div></td>
						</tr>
						
						<tr>
							<td class="item_label"><div style="width: 150px;">Username</div></td>
							<td><input type="text" name="uusername" ID="Username" value="<?php echo isset($_POST["uusername"]) ? $_POST["uusername"] : ''; ?>"/></td>
							<td><div style="width: 300px;color:red;"><?php echo $usernameErr;?></div></td>
						</tr>
						
						<tr>
							<td class="item_label"><div style="width: 150px;">Password</div></td>
							<td><input type="text" name="pass1" ID="Pass1" /></td>
							<td><div style="width: 300px;color:red;"><?php echo $pass1Err;?></div></td>
						</tr>
						<tr>
							<td class="item_label"><div style="width: 150px;">Confirm Password</div></td>						
							<td><input type="text" name="pass2" ID="Pass2" /></td>
							<td><div style="width: 300px;color:red;"><?php echo $pass2Err;?></div></td>
						</tr>
					</table>
					<button class="button" type="button" onclick="this.form.submit();"><span>Register Now!</span></button>
					<button class="button" type="button" onclick="window.location.href='login.php'"><span>Cancel</span></button>
				</form>
			</div>
            <?php include("lib/error_min.php");?>
		</div>
	</div>
</body>
</html>

