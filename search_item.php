<?php

include('lib/common.php');
// written by tli372

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

/* if form was submitted, then execute query to search for friends */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $keyword = mysqli_real_escape_string($db, $_POST['keyword']);
    $minimum_price = mysqli_real_escape_string($db, $_POST['minimum_price']);
    $maximum_price = mysqli_real_escape_string($db, $_POST['maximum_price']);
    $category = mysqli_real_escape_string($db, $_POST['category']);
    $condition = mysqli_real_escape_string($db, $_POST['condition']);

    if ($condition == 'select') {
        $condition = NULL;
    } elseif ($condition == 'New') {
        $condition = 1;
    } elseif ($condition == 'Very Good') {
        $condition = 2;
    } elseif ($condition == 'Good') {
        $condition = 3;
    } elseif ($condition == 'Fair') {
        $condition = 4;
    } elseif ($condition == 'Poor') {
        $condition = 5;
    }

    if ($category == 'select') {
        $category = NULL;
    }elseif ($category != 'select'){
        $category = $category;
    }

    $query = "SELECT Item.ItemID AS ID, Item.item_name AS Item_Name, Item.description, Item.categoryname, Item.condition_state, A.max_bid_amount AS Current_Bid, A.username AS High_Bidder, Item.get_it_now_price AS Get_It_Now_Price, Date_Add(Item.start_sell_time, INTERVAL Item.auction_length Day) AS Auction_Ends " .
             "FROM Item " .
             "LEFT OUTER JOIN " .
             "  (SELECT Bid.ItemID, Bid.username, Max_Bid.max_bid_amount, Bid.bid_time " .
             "  FROM (SELECT ItemID, max(bid_amount) as max_bid_amount FROM Bid GROUP BY ItemID) AS Max_Bid " .
             "  LEFT JOIN " .
             "  Bid" .
             "  ON Bid.ItemID = Max_Bid.ItemID AND Bid.bid_amount = Max_Bid.max_bid_amount) AS A " .
             "ON Item.ItemID = A.ItemID " .
             "WHERE Date_Add(Item.start_sell_time, INTERVAL Item.auction_length Day) > NOW() " .
             "AND (CASE " .
             "     WHEN Item.get_it_now_price = NULL THEN 1=1" .
             "     WHEN Item.get_it_now_price >0 THEN COALESCE(A.max_bid_amount, Item.starting_bid) < Item.get_it_now_price" .
             "     ELSE 1=1" .
             "     END )" ;

    if (empty($keyword)) {
        $keywordErr = "Keyword cannot be empty.";
        array_push($error_msg,  "Error: You must provide a keyword ");
    }

    if (!empty($keyword) or !empty($category) or !empty($minimum_price) or !empty($maximum_price) or !empty($condition)) {
        $query = $query . " AND (1=1 ";

        if (!empty($keyword)) {
            $query = $query . " AND (Item.item_name LIKE '%$keyword%' OR Item.description LIKE '%$keyword%')";
        }

        if (!empty($category)) {
            $query = $query . " AND Item.categoryname = '$category' ";
        }
        if (!empty($minimum_price)) {
            $query = $query . " AND COALESCE(A.max_bid_amount, Item.starting_bid) >= $minimum_price ";
        }
        if (!empty($maximum_price)) {
            $query = $query . " AND COALESCE(A.max_bid_amount, Item.starting_bid) <= $maximum_price ";
        }
        if (!empty($condition)) {
            $query = $query . " AND Item.condition_state <= $condition ";
        }
        $query = $query . ") ";


        $query = $query . " ORDER BY Date_Add(Item.start_sell_time, INTERVAL Item.auction_length Day) ASC ";

        $result = mysqli_query($db, $query);

        include('lib/show_queries.php');

        if (mysqli_affected_rows($db) == -1) {
            array_push($error_msg, "SELECT ERROR:Failed to search items ... <br>" . __FILE__ . " line:" . __LINE__);
        }
    }
}
?>

<?php include("lib/header.php"); ?>
<html lang="de-DE">
<head>
    <title>Search Item</title>
    <style>
        .error {color: #000000;}
        .error1 {color: #FF0000}
        table {white-space: nowrap;}
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
            <li><a href="main_menu.php" <?php if($current_filename=='main_menu.php') echo "class='active'"; ?>>Home</a ></li>
            <li><a href="search_item.php" <?php if($current_filename=='search_item.php') echo "class='active'"; ?>>Search Item</a ></li>
            <li><a href="view_auction_results.php" <?php if($current_filename=='view_auction_results.php') echo "class='active'"; ?>>View Auction Results</a ></li>
            <li><a href="sell_item.php" <?php if($current_filename=='sell_item.php') echo "class='active'"; ?>>Sell Item</a ></li>
            <li><a href="logout.php" <span class='glyphicon glyphicon-log-out'></span>Log Out</a ></li>
        </ul>
    </div>

    <div class="center_content">
        <div class="center_left">

            <div class="features">

                <div class="profile_section">
                    <div class="subtitle">Item Search</div>
                    

                    <form name="searchform" method="POST">
                        <table>
                            <tr>
                                <td class="item_label"><div style="width: 150px;">Keyword</div></td>
                                <td><input type="text" name="keyword" value="<?php echo isset($_POST["keyword"]) ? $_POST["keyword"] : ''; ?>"/></td>
                                <td><div class="error1"><?php echo $keywordErr;?></div></td>
                            </tr>
                            <tr>
                                <td class="item_label"><div style="width: 150px;">Category</div></td>
                                <td><select id="category" name="category">
                                        <?php
                                        $sql_category = mysqli_query($db, "SELECT categoryname FROM Category");
                                        echo "<option value=\"select\"></option>";
                                        while ($row = $sql_category->fetch_assoc()){
                                            $categoryname = $row['categoryname'];
                                            echo "<option value=\"$categoryname\">" . $categoryname . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><div style="width: 1000px;"></div></td>
                            </tr>
                            <tr>
                                <td class="item_label"><div style="width: 150px;">Minimum Price $</div></td>
                                <td><input type="number" name="minimum_price" value="<?php echo isset($_POST["minimum_price"]) ? $_POST["minimum_price"] : ''; ?>"/></td>
                                <td><div style="width: 1000px;"></div></td>
                            </tr>
                            <tr>
                                <td class="item_label"><div style="width: 150px;">Maximum Price $</div></td>
                                <td><input type="number" name="maximum_price" value="<?php echo isset($_POST["maximum_price"]) ? $_POST["maximum_price"] : ''; ?>"/></td>
                                <td><div style="width: 1000px;"></div></td>
                            </tr>
                            <tr>
                                <td class="item_label"><div style="width: 150px;">Condition at least</div></td>
                                <td>
                                    <select name="condition">
                                        <option value="select"></option>
                                        <option value="New">New</option>
                                        <option value="Very Good">Very Good</option>
                                        <option value="Good">Good</option>
                                        <option value="Fair">Fair</option>
                                        <option value="Poor">Poor</option>
                                    </select>
                                </td>
                                <td><div style="width: 1000px;"></div></td>
                            </tr>

                        </table>
                        <div>
                            <button class="button" type="button" onclick="this.form.submit();showDiv();"><span>Search</span></button>
                            <button class="button" type="button" onclick="window.location.href='main_menu.php'"><span>Cancel</span></button>
                        </div>
                    </form>
                </div>

                <div class='profile_section'>
                    <div class='subtitle'>Search Results</div>
                    <table class='table' border="1" style="width=500px" alisn="center">
                        <tr>
                            <td class='heading'>ID</td>
                            <td class='heading'>Item_Name</td>
                            <td class='heading'>Current_Bid</td>
                            <td class='heading'>High_Bidder</td>
                            <td class='heading'>Get_It_Now_Price</td>
                            <td class='heading'>Auction_ends</td>
                        </tr>
                        <?php
                        if (isset($result)) {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                $id = urlencode($row['ID']);
                                print "<tr>";
                                print "<td>{$row['ID']}</td>";
                                print "<td><a href='view_item.php?id=$id'>{$row['Item_Name']}</a></td>";
                                print "<td>{$row['Current_Bid']}</td>";
                                print "<td>{$row['High_Bidder']}</td>";
                                print "<td>{$row['Get_It_Now_Price']}</td>";
                                print "<td>{$row['Auction_Ends']}</td>";
                                print "</tr>";
                            }
                        }	?>
                    </table>
                </div>

            </div>
        </div>

        <?php include("lib/error.php"); ?>

        <div class="clear"></div>
    </div>

    <?php include("lib/footer.php"); ?>

</div>
</body>
</html>
