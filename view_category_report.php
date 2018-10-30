<?php
/*
include('lib/common.php');
// written by GTusername3

if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit();
}

$query = "SELECT first_name, last_name " .
		 "FROM User " .
		 "INNER JOIN RegularUser ON User.email = RegularUser.email " .
		 "WHERE User.email = '{$_SESSION['email']}'";
         
$result = mysqli_query($db, $query);
include('lib/show_queries.php');
    
if (!empty($result) && (mysqli_num_rows($result) > 0) ) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    $user_name = $row['first_name'] . " " . $row['last_name'];
} else {
        array_push($error_msg,  "SELECT ERROR: User profile <br>" . __FILE__ ." line:". __LINE__ );
}

*/?>


<?php include("lib/common.php"); ?>
<?php include("lib/header.php"); ?>

<style>
    #auction_result {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 70%;
        margin: 0 auto;
        height: auto;
    }

    #auction_result td, #auction_result th {
        border: 1px solid #ddd;
        text-align: center;
        padding: 8px;
    }

    #auction_result tr:nth-child(even){background-color: #f2f2f2;}
    #auction_result tr:hover {background-color: #ddd;}

    #auction_result th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #4CAF50;
        color: white;
    }
</style>

<title>View Category Report</title>
</head>
	
	<body>
        <div id="main_container">
<!--            --><?php //include("lib/menu.php"); ?>
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
                    <li><a href=" " <?php if($current_filename=='view_profile.php') echo "class='active'"; ?>>Home</a></li>
                    <li><a href="search_item.php" <?php if($current_filename=='search_item.php') echo "class='active'"; ?>>Search Item</a></li>
                    <li><a href="view_auction_results.php" <?php if($current_filename=='view_auction_results.php') echo "class='active'"; ?>>View Auction Results</a></li>
                    <li><a href="sell_item.php" <?php if($current_filename=='sell_item.php') echo "class='active'"; ?>>Sell Item</a></li>
                    <li><a href="logout.php" <span class='glyphicon glyphicon-log-out'></span>Log Out</a></li>
                </ul>
            </div>
            
			<div class="center_content">
				<div class="center_content">
<!--					<div class="title_name">Category Report</div>-->
					<div class="auction_results">
                        	<div class="subtitle" style="text-emphasis-color: #ff2b3e">Category Report</div>
							<table name="view_category_result_table" id="auction_result" align="center">
								<tr>
                                    <th><b><u>Category</u></b></th>
                                    <th><b><u>Total Items</u></b></th>
                                    <th><b><u>Min Prices</u></b></th>
                                    <th><b><u>Max Prices</u></b></th>
                                    <th><b><u>Average Price</u></b></th>
								</tr>
																
								<?php
                                $query = "SELECT Category.categoryname AS Category, count(*) AS Total_Items," .
                                    "min(Item.get_it_now_price) AS Min_Price, max(Item.get_it_now_price) AS Max_Price," .
                                    "avg(Item.get_it_now_price) as Average_Price " .
                                    "FROM Category LEFT OUTER JOIN Item ON Category.categoryname = Item.categoryname " .
                                    "GROUP BY Category.categoryname " .
                                    "ORDER BY Category.categoryname ASC";
                                             
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "SELECT ERROR: find Friendship <br>" . __FILE__ ." line:". __LINE__ );
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print '<tr>';
                                        print '<td>' . $row['Category'] . '</td>';
                                        print '<td>' . $row['Total_Items'] . '</td>';
                                        print '<td>' . '$'. number_format($row['Min_Price'],2,'.','') . '</td>';
                                        print '<td>' .'$'. number_format($row['Max_Price'],2,'.','') . '</td>';
                                        print '<td>' . '$'. number_format($row['Average_Price'],2,'.','') . '</td>';
                                        print "</tr>";							
                                    }									
                                ?>
							</table>
                            <button class="button" type="button" onclick="window.location.href='main_menu.php'"><span>Done</span></button>
<!--                            <div class="center-block" align="center" style="background-color: #b3b5b4"> <input type="button" value="Done" onclick="location='main_menu_admin.php'" /> </div>-->
						</div>
				</div> 
                
                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 
			</div>    

               <?php include("lib/footer.php"); ?>
		 
		</div>
	</body>
</html>