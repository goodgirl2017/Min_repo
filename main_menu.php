<?php

include('lib/common.php');
// written by mni37

// check whether the user has logged or not
// TODO: need to be added in login.php
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

    // ERROR: demonstrating SQL error handlng, to fix
    // replace 'sex' column with 'gender' below:
//     $query = "SELECT first_name, last_name, gender, birthdate, current_city, home_town " .
// 		 "FROM User INNER JOIN RegularUser ON User.email=RegularUser.email " .
// 		 "WHERE User.email='{$_SESSION['email']}'";
// To check whether the user is administrator
    $query = "SELECT username FROM AdministrativeUser WHERE username = '{$_SESSION['username']}'";
    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');

if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
    $_SESSION['usertype'] = 'administrator';
    header('Location: main_menu_admin.php');
    exit();
    } else {
    $_SESSION['usertype'] = 'normaluser';
    header('Location: main_menu_normal.php');
//     header('Location:registration.php');
    exit();
    }
?>

