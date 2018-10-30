<?php
include('lib/common.php');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT first_name, last_name " .
    "From User " .
    "WHERE User.username = '{$_SESSION['username']}'";

$result = mysqli_query($db, $query);
include('lib/show_queries.php');
if (!is_bool($result) && (mysqli_num_rows($result) > 0)){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows(($result));
    $user_name = $row['first_name'] . " " . $row['last_name'];
} else {
    array_push($error_msg, "SELECT ERROR: User profile <br>" . __FILE__ ."line:". __LINE__);
}

$query = "SELECT A.ItemID AS ID, item_name AS Item_Name, max_bid AS Sale_Price, username AS Winner, bid_time AS Auction_Ended " .
    "FROM Bid INNER JOIN " .
    "(SELECT Item.ItemID, Item.item_name, max(Bid.bid_amount) AS max_bid " .
    "FROM (Item INNER JOIN Bid ON Item.ItemID = Bid.ItemID) " .
    "WHERE Item.get_it_now_price = Bid.bid_amount OR (Bid.bid_amount > Item.minimum_sale_price AND DATE_ADD(Item.start_sell_time, INTERVAL Item.auction_length DAY) < NOW()) " .
    "GROUP BY Bid.ItemID, Item.item_name) A " .
    "ON Bid.ItemID = A.ItemID AND Bid.bid_amount=A.max_bid " .
    "ORDER BY Auction_Ended DESC";

$result = mysqli_query($db, $query);
include('lib/show_queries.php');
if (mysqli_affected_rows($db) == -1) {
    array_push($error_msg,  "SELECT ERROR:Failed to find Item ... <br>" . __FILE__ ." line:". __LINE__ );
}

if (isset($result)) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $query= "UPDATE item SET winner='{$row['Winner']}' WHERE ItemID='{$row['ID']}'";
        $winner = mysqli_query($db, $query);
        if (!empty($winner) && (mysqli_num_rows($winner) == 0) ) {
            array_push($error_msg,  "SELECT ERROR: find Winner <br>" . __FILE__ ." line:". __LINE__ );
        }
    }
}
?>


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
<title>View User Report</title>
</head>
	
	<body>
        <div id="main_container">
<!--		    --><?php //include("lib/menu.php"); ?>
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
                        	<div class="subtitle" style="text-emphasis-color: #ff2b3e">User Report</div>
							<table name="view_user_result_table" id="auction_result" align="center">
								<tr>
                                    <th><b><u>Username</u></b></th>
                                    <th><b><u>Listed</u></b></th>
                                    <th><b><u>Sold</u></b></th>
                                    <th><b><u>Purchased</u></b></th>
                                    <th><b><u>Rated</u></b></th>
								</tr>
																
								<?php
                                $query = "SELECT G.username, Listed, Sold, Purchased, Rated " .
                                    "FROM (SELECT C.username, Listed, Sold, Purchased " .
                                    "FROM(SELECT A.username, A.Listed, IFNULL(B.Sold, 0) AS Sold " .
                                    "FROM(SELECT User.username AS Username, COUNT(Item.username) AS Listed " .
                                    "FROM User LEFT OUTER JOIN Item ON User.username = Item.username " .
                                    "GROUP BY User.username) A LEFT OUTER JOIN " .
                                    "(SELECT User.username AS Username, COUNT(Item.username) AS Sold " .
                                    "FROM User LEFT OUTER JOIN Item ON User.username = Item.username " .
                                    "WHERE Item.winner IS NOT NULL GROUP BY User.username) B " .
                                    "ON A.username = B.username) C LEFT OUTER JOIN (SELECT username, IFNULL(Purchased, 0) AS Purchased " .
                                    "FROM (SELECT User.username AS username FROM User) D LEFT OUTER JOIN " .
                                    "(SELECT Item.winner AS winner, count(Item.winner) AS Purchased FROM Item " .
                                    "GROUP BY Item.winner) E ON D.username = E.winner) F ON C.username = F.username) G " .
                                    "LEFT OUTER JOIN(SELECT H.username, IFNULL(Rated, 0) AS Rated " .
                                    "FROM (SELECT User.username AS username FROM User) H " .
                                    "LEFT OUTER JOIN(SELECT Rating.username, count(*) AS Rated FROM Rating " .
                                    "GROUP BY Rating.username) I ON H.username = I.username) J " .
                                    "ON G.username = J.username ORDER BY Listed DESC;";
                                             
                                    $result = mysqli_query($db, $query);
                                     if (!empty($result) && (mysqli_num_rows($result) == 0) ) {
                                         array_push($error_msg,  "SELECT ERROR: find Friendship <br>" . __FILE__ ." line:". __LINE__ );
                                    }
                                    
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        print '<tr>';
                                        print '<td>' . $row['username'] . '</td>';
                                        print '<td>' . $row['Listed'] . '</td>';
                                        print '<td>' . $row['Sold'] . '</td>';
                                        print '<td>' . $row['Purchased'] . '</td>';
                                        print '<td>' . $row['Rated'] . '</td>';
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