<?php

include('lib/common.php');
// written by mni37

// check whether the user has logged or not
// TODO: need to be added in login.php
if (($_SESSION['usertype']) != 'administrator') {
    header('Location: login.php');
    exit();
}
$query = "SELECT position " .
    "From administrativeuser " .
    "WHERE username = '{$_SESSION['username']}'";

$result = mysqli_query($db, $query);
$queryResult = mysqli_fetch_assoc($result);
$position = $queryResult['position'];

?>

<?php include("lib/header.php"); ?>
 <html>
<head>
<title>GTBay Main Menu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.vertical-menu {
    width: 200px;
}

.vertical-menu a {
    background-color: #eee;
    color: black;
    display: block;
    padding: 12px;
    text-decoration: none;
}

.vertical-menu a:hover {
    background-color: #ccc;
}

.vertical-menu a.active {
    background-color: #4CAF50;
    color: white;
}
</style>
</head>
<body>


<div id="main_container">
		<div id="header">
			<div class="logo">
				<img src="img/GTBay-biglogo.png" title="GTBay-biglogo"/>
			</div>
		</div>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		
		
		<div class="nav_bar">
    <ul>
        <li><a href="main_menu.php " <?php if($current_filename=='main_menu.php') echo "class='active'"; ?>>Home</a ></li>
        <li><a href="search_item.php" <?php if($current_filename=='search_item.php') echo "class='active'"; ?>>Search Item</a ></li>
        <li><a href="view_auction_results.php" <?php if($current_filename=='view_auction_results.php') echo "class='active'"; ?>>View Auction Results</a ></li>
        <li><a href="sell_item.php" <?php if($current_filename=='sell_item.php') echo "class='active'"; ?>>Sell Item</a ></li>
        <li><a href="logout.php" <span class='glyphicon glyphicon-log-out'></span>Log Out</a ></li>
    </ul>
</div>
		<div class="center_content">
			<div class="text_box">		

				<div class="vertical-menu">
					<div><b><u><font size="4">Main Menu </font></u></b></div>
					<div><b><u><font size="2">Position: <?php echo $position; ?></font></u></b></div>
					</br>
 	 				<a href="view_category_report.php" class="active">View Category Report</a>
 	 				<a href="view_user_report.php" class="active">View User Report</a>
 	 				<a href="view_auction_results.php"  class="active">View Auction Results</a> 	 				 	 				
 					<a href="search_item.php">Search for Item</a>
 	 				<a href="sell_item.php">Sell Item</a>
				</div>
			</div>
		</div>	
</div>

</body>
</html>