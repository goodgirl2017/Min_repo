<?php
include('lib/common.php');
header('Cache-control: private, must-revalidate');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$item_nameErr = $descriptionErr = $categoryErr = $conditionErr = $start_auction_biddingErr = $minimum_sale_priceErr = $auction_ends_inErr = $get_it_now_priceErr = "";
$start_minimumErr = $get_minimumErr = "";

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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = mysqli_real_escape_string($db, $_POST['item_name']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $category = mysqli_real_escape_string($db, $_POST['category']);
    $condition = mysqli_real_escape_string($db, $_POST['condition']);
    $start_auction_bidding = mysqli_real_escape_string($db, $_POST['start_auction_bidding']);
    $minimum_sale_price = mysqli_real_escape_string($db, $_POST['minimum_sale_price']);
    $auction_ends_in = mysqli_real_escape_string($db, $_POST['auction_ends_in']);
    $get_it_now_price = mysqli_real_escape_string($db, $_POST['get_it_now_price']);
    $return_accepted = mysqli_real_escape_string($db, $_POST['return_accepted']);
    $start_sell_time = date('Y-m-d h:i:s', time());

    if ($start_auction_bidding > $minimum_sale_price) {
        array_push($error_msg, "Please enter an minimum sales price larger than start auction price.");
        $start_minimumErr = "Please enter an minimum sales price larger than start auction price.";
    } elseif (!empty($get_it_now_price) && $get_it_now_price < $minimum_sale_price) {
        array_push($error_msg, "Please enter an get it now price larger than minimum sales price.");
        $get_minimumErr = "Please enter an get it now price larger than minimum sales price.";
    } else {

        if ($return_accepted == 'on') {
            $return_accepted = 'True';
        } else {
            $return_accepted = 'False';
        }

        if ($auction_ends_in == 'select') {
            array_push($error_msg, "Please enter auction duration.");
            $auction_ends_inErr = "Auction length is required";
        } elseif ($auction_ends_in == '1 days') {
            $auction_ends_in = '1';
        } elseif ($auction_ends_in == '3 days') {
            $auction_ends_in = '3';
        } elseif ($auction_ends_in == '5 days') {
            $auction_ends_in = '5';
        } else {
            $auction_ends_in = '7';
        }

        if ($condition == 'select'){
            array_push($error_msg, "Please select item condition.");
            $conditionErr = "Condition is required";
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

        if (empty($item_name)) {
            array_push($error_msg, "Please enter item name.");
            $item_nameErr = "Item name is required";
        }
        if (empty($description)) {
            array_push($error_msg, "Please enter item description.");
            $descriptionErr = "Description is required.";
        }
        if ($category == 'select') {
            array_push($error_msg, "Please select item category.");
            $categoryErr = "Category is required.";
        }
        if (empty($start_auction_bidding)) {
            array_push($error_msg, "Please enter start auction price.");
            $start_auction_biddingErr = "Start bidding price is required.";
        }
        if (empty($minimum_sale_price)) {
            array_push($error_msg, "Please enter minimum price.");
            $minimum_sale_priceErr = "Minimum sale price is required.";
        }

        if($showQueries) {
            array_push($query_msg, "Item Name: ". $item_name);
            array_push($query_msg, "Description: ". $description);
            array_push($query_msg, "Category: ". $category );
            array_push($query_msg, "Condition: ". $condition);
            array_push($query_msg, "Start Price: ". $start_auction_bidding);
            array_push($query_msg, "Minimum Price:". $minimum_sale_price);
            array_push($query_msg, "Auction Ends In:". $auction_ends_in);
            array_push($query_msg, "Get It Now Price: ". $get_it_now_price);
            array_push($query_msg, "Return_accepted: ". $return_accepted);
        }

        if (!empty($item_name) && !empty($description) && !empty($category) && !empty($condition) && !empty($start_auction_bidding) && !empty($minimum_sale_price) && !empty($get_it_now_price) && !empty($return_accepted)) {
            $query = "INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,get_it_now_price,start_sell_time) VALUES ('{$_SESSION['username']}', '$category', '$return_accepted', '$condition', '$item_name', '$description', '$minimum_sale_price', '$start_auction_bidding', '$auction_ends_in', '$get_it_now_price','$start_sell_time')";
            $result = mysqli_query($db, $query);
            if (mysqli_affected_rows($db) == -1) {
                array_push($error_msg, "UPDATE ERROR: Regular User... <br>" . __FILE__ . " line:" . __LINE__);
            } else {
                array_push($query_msg, "Item was successfully put on Sale!");
                echo "<script type='text/javascript'>alert('Your item has been successfully listed!');window.location='main_menu.php';</script>";
            }
        } elseif (!empty($item_name) && !empty($description) && !empty($category) && !empty($condition) && !empty($start_auction_bidding) && !empty($minimum_sale_price) && !empty($get_it_now_price) && !empty($return_accepted)) {
            $query = "INSERT INTO Item (username,categoryname,returnable,condition_state,item_name,description,minimum_sale_price,starting_bid,auction_length,start_sell_time) VALUES ('{$_SESSION['username']}', '$category', '$return_accepted', '$condition', '$item_name', '$description', '$minimum_sale_price', '$start_auction_bidding', '$auction_ends_in', '$start_sell_time')";
            $result = mysqli_query($db, $query);
            if (mysqli_affected_rows($db) == -1) {
                array_push($error_msg, "UPDATE ERROR: Regular User... <br>" . __FILE__ . " line:" . __LINE__);
            } else {
                array_push($query_msg, "Item was successfully put on Sale!");
                echo "<script type='text/javascript'>alert('Your item has been successfully listed!');window.location='main_menu.php';</script>";
            }
        }
    }
}

?>

<?php include("lib/header.php"); ?>

<html>
<head>
    <title>Sell an item</title>
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

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

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
            <b><span class="error">* All fields are required.</span></b>
            <p><b><span class="error1"><?php echo $start_minimumErr;?></span></b></p>
            <p><b><span class="error1"><?php echo $get_minimumErr;?></span></b></p>
                    <form name="sell_item_form" action="sell_item.php" method="POST">
                          <table>
                              <tr>
                                  <td class="item_label"><div style="width: 240px;">Item Name</div></td>
                                  <td><input type="text" id="item_name" name="item_name" value="<?php echo isset($_POST["item_name"]) ? $_POST["item_name"] : ''; ?>" /></td>
                                  <td><div class="error1"><?php echo $item_nameErr;?></div></td>
                              </tr>
                              <tr>
                                  <td class="item_label">Description</td>
                                  <td><textarea rows="4" cols="18" id="description" name="description"><?php if(isset($_POST['description'])) {echo htmlentities ($_POST['description']); }?></textarea></td>
                                  <td><div class="error1"><?php echo $descriptionErr;?></div></td>
                              </tr>
                              <tr>
                                  <td class="item_label"><div style="width: 240px;">Category</div></td>
                                  <td><select id="category" name="category">
                                          <?php
                                          $sql_category = mysqli_query($db, "SELECT categoryname FROM Category");
                                          while ($row = $sql_category->fetch_assoc()){
                                              $categoryname = $row['categoryname'];
                                                echo "<option value=\"$categoryname\">" . $categoryname . "</option>";
                                          }
                                          ?>
                                        </select>
                                  </td>
                                  <td><div class="error1"><?php echo $categoryErr;?></div></td>
                              </tr>
                              <tr>
                                  <td class="item_label">Condition</td>
                                  <td>
                                      <select name="condition">
                                          <option value="select">--Select--</option>
                                          <option value="New">New</option>
                                          <option value="Very Good">Very Good</option>
                                          <option value="Good">Good</option>
                                          <option value="Fair">Fair</option>
                                          <option value="Poor">Poor</option>
                                      </select>
                                  </td>
                                  <td><div class="error1"><?php echo $conditionErr;?></div></td>
                              </tr>
                              <tr>
                                  <td class="item_label">Start auction bidding at $</td>
                                  <td><input type="number" id="start_auction_bidding" name="start_auction_bidding" value="<?php echo isset($_POST["start_auction_bidding"]) ? $_POST["start_auction_bidding"] : ''; ?>"/></td>
                                  <td><div class="error1"><?php echo $start_auction_biddingErr;?></div></td>
                              </tr>
                              <tr>
                                  <td class="item_label">Minimum sale price $</td>
                                  <td><input type="number" id="minimum_sale_price" name="minimum_sale_price" value="<?php echo isset($_POST["minimum_sale_price"]) ? $_POST["minimum_sale_price"] : ''; ?>" /></td>
                                  <td><div class="error1"><?php echo $minimum_sale_priceErr;?></div></td>
                              </tr>
                              <tr>
                                  <td class="item_label">Auction ends in</td>
                                  <td><select name="auction_ends_in">
                                          <option value="select">--Select--</option>
                                          <option value="1 days">1 days</option>
                                          <option value="3 days">3 days</option>
                                          <option value="5 days">5 days</option>
                                          <option value="7 days">7 days</option>
                                      </select>
                                  </td>
                                  <td><div class="error1"><?php echo $auction_ends_inErr;?></td>
                              </tr>
                              <tr>
                                  <td class="item_label">Get It Now Price $ (Optional)</td>
                                  <td><input type="number" id="get_it_now_price" name="get_it_now_price" value="<?php echo isset($_POST["get_it_now_price"]) ? $_POST["get_it_now_price"] : ''; ?>"/></td>
                                  <td><div class="error1"><?php echo $get_it_now_priceErr;?></div></td>
                              </tr>
                              <tr>
                                  <td class="item_label">Returns Accepted?</td>
                                  <td><input type="checkbox" name="return_accepted" /></td>
                              </tr>
                          </table>
                        <br>
                        <br>
                        <div>
                            <button class="button" type="button" onclick="this.form.submit();"><span>List Item!</span></button>
                            <button class="button" type="button" onclick="window.location.href='main_menu.php'"><span>Cancel</span></button>
                        </div>
                    </form>
                <?php include("lib/error.php"); ?>
        </div>
    </div>
</body>
</html>