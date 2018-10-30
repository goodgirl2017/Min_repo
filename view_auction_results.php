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
         "UNION " .
         "SELECT B.ItemID AS ID, item_name AS Item_Name, '-' AS Sale_Price, '-' AS Winner, bid_time AS Auction_Ended " .
         "FROM Bid INNER JOIN " .
         "(SELECT Item.ItemID, Item.item_name, max(Bid.bid_amount) AS max_bid " .
         "FROM (Item INNER JOIN Bid ON Item.ItemID = Bid.ItemID) " .
         "WHERE Item.minimum_sale_price > Bid.bid_amount AND DATE_ADD(Item.start_sell_time, INTERVAL Item.auction_length DAY) < NOW() " .
         "GROUP BY Bid.ItemID, Item.item_name) B " .
         "ON Bid.ItemID = B.ItemID AND Bid.bid_amount=B.max_bid " .
         "ORDER BY Auction_Ended DESC";

$result = mysqli_query($db, $query);
include('lib/show_queries.php');
if (mysqli_affected_rows($db) == -1) {
    array_push($error_msg,  "SELECT ERROR:Failed to find Item ... <br>" . __FILE__ ." line:". __LINE__ );
}


?>


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

<html>
<head>
    <title>Auction Results</title>
</head>
<body>
    <div id="main_container">
        <div id="header">
            <div class="logo">
                <img src="img/GTBay-biglogo.png" title="GTBay-biglogo"/>
            </div>
        </div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="nav_bar">
            <ul>
                <li><a href="main_menu.php" <?php if($current_filename=='main_menu.php') echo "class='active'"; ?>>Home</a></li>
                <li><a href="search_item.php" <?php if($current_filename=='search_item.php') echo "class='active'"; ?>>Search Item</a></li>
                <li><a href="view_auction_results.php" <?php if($current_filename=='view_auction_results.php') echo "class='active'"; ?>>View Auction Results</a></li>
                <li><a href="sell_item.php" <?php if($current_filename=='sell_item.php') echo "class='active'"; ?>>Sell Item</a></li>
                <li><a href="logout.php" <span class='log-out'></span>Log Out</a></li>
            </ul>
        </div>
        <div class="center_content">
                <div class="auction_results">
                    <table name="auction_results_table" id="auction_result" aligh="center">
                        <tr>
                            <th><b><u>ID</u></b></th>
                            <th><b><u>Item Name</u></b></th>
                            <th><b><u>Sale Price</u></b></th>
                            <th><b><u>Winner</u></b></th>
                            <th><b><u>Auction Ended</u></b></th>
                        </tr>
                        <?php
                        if (isset($result)) {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                print "<tr>";
                                print "<td>{$row['ID']}</td>";
                                print "<td>{$row['Item_Name']}</td>";
                                print "<td>{$row['Sale_Price']}</td>";
                                print "<td>{$row['Winner']}</td>";
                                print "<td>{$row['Auction_Ended']}</td>";
                                print "</tr>";
                            }
                        }
                        ?>
                    </table>
                    <br>
                    <button class="button" type="button" onclick="window.location.href='main_menu.php'"><span>Done</span></button>
                </div>
        </div>
        <?php include("lib/error.php"); ?>
</body>
</html>