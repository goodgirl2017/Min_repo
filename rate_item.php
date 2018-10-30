<?php

include('lib/common.php');
// written by tli372
if($showQueries){
    array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])){
    $id = $_GET['id'];
} else{
    header('Location: view_item.php');
    $id = 0; // Just for testing
}

// Convert query result from Item table to associate array
$queryItem = "SELECT * FROM Item ";
$queryItem .= "WHERE ItemID='$id'";
$queryItemResult = mysqli_query($db, $queryItem);
$queryItemRow = mysqli_fetch_assoc($queryItemResult);
// release the data from database
mysqli_free_result($queryItemResult);

// Convert query result from Rating table to associate array
$queryRating = "SELECT * FROM Rating ";
$queryRating .= "WHERE ItemID='$id' ORDER BY rate_time DESC ";
$queryRatingResult = mysqli_query($db, $queryRating);
//$queryRatingRow = mysqli_fetch_assoc($queryRatingResult);
$count = mysqli_num_rows($queryRatingResult);

//output average rating for checking allowed inputting of rating
$queryRatingAvg = "SELECT AVG(number_of_stars) FROM Rating ";
$queryRatingAvg .= "WHERE ItemID='$id'";
$queryRatingAvgResult = mysqli_query($db, $queryRatingAvg);
$RatingAvg = (mysqli_fetch_row($queryRatingAvgResult))[0];
$RatingAvgNum = round((float)$RatingAvg,1); //convert to number

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
//    tell which button is clicked

    if(isset($_POST['Rate'])) {

        $enteredStars = mysqli_real_escape_string($db, $_POST['number_of_stars']);

        if ($enteredStars == '0Unsatisfactory') {
            $enteredStars = 0;
        } elseif ($enteredStars == '1Poor') {
            $enteredStars = 1;
        } elseif ($enteredStars == '2Fair') {
            $enteredStars = 2;
        } elseif ($enteredStars == '3Average') {
            $enteredStars = 3;
        } elseif ($enteredStars == '4Good') {
            $enteredStars = 4;
        } elseif ($enteredStars == '5Excellent') {
            $enteredStars = 5;
        }

        $enteredComments = mysqli_real_escape_string($db, $_POST['comments']);
        if(is_numeric($enteredStars)){
            $sqlInsert = "INSERT INTO Rating (ItemID, username, comments, number_of_stars, rate_time) VALUES ('$id', '{$_SESSION['username']}', '$enteredComments', '$enteredStars', NOW())";
            $resultInsert = mysqli_query($db, $sqlInsert);
                      //                check whether insert succeed or not
            if ($resultInsert) {
                 array_push($query_msg, "Congratulations! You have rated the item! ");
                 header("Refresh:3");
              } else {
                 array_push($error_msg, "Oops, rate did not succeed!");
                 header("Refresh:3");
              }
        } else{
            array_push($error_msg,  "Please Enter Rating.");
            header("Refresh:3");
        }

    }elseif(isset($_POST['cancel'])){
        //array_push($error_msg,  "You are returning back to Item Description......");
        //header('Refresh:1;url=view_item.php?id="."$id');
        echo "<script type='text/javascript'>alert('You are returning back to Item Description......');
            			window.location='view_item.php?id="."$id';</script>";

    } elseif(isset($_POST['deleteRating'])){
        $sqlDelete = "DELETE FROM Rating WHERE ItemID = '$id' AND username = '{$_SESSION['username']}'";
        $resultDelete = mysqli_query($db, $sqlDelete);
        //   check whether update description succeed or not
        if ($resultDelete){
            array_push($query_msg, "Congratulations! Rating has been deleted.");
            header("Refresh:3"); // refresh the page
        } else{
            array_push($error_msg,  "Oops, rating failed to be deleted!");
            header("Refresh:3"); // refresh the page
        }

    }

}
?>

<?php include("lib/header.php"); ?>
<html lang="de-DE">
<head>
    <title>Rate Item</title>
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
            <form action= "<?php echo "rate_item.php?id="."$id"; ?>" method="post" enctype="multipart/form-data">
                <div class="title">Item Ratings</div>

                </br>
                <table class="inputtable" summary="This data table is used to format the item rating fields">
                    <table>

                        <tr>
                            <td class="item_label"><div style="width: 150px;">Item ID</div></td>
                            <td><?php echo "$id"."          " ?></td>

                        </tr>
                        <tr>
                            <td class="item_label"><div style="width: 150px;">Item Name</div></td>
                            <td><?php echo  $queryItemRow['item_name'];  ?></td>
                        </tr>

                        <tr>
                            <td class="item_label"><div style="width: 150px;">Average Rating</div></td>
                            <td>
                                <?php
                                if ($RatingAvgNum > 0){
                                    ?>
                                    <?php
                                    echo $RatingAvgNum;
                                    ?>
                                    <?php
                                } else { ?>
                                    <?php ;
                                    echo ''; ?>
                                    <?php
                                }
                                ?>
                        </tr>

                        <tr>
                            <td class="item_label"><div style="width: 150px;">Latest Ratings</div></td>
                            <td><div style="width: 600px;">
                                    <table class="table" border="1" style="width=500px" align="center"  >

                                        <col width="300">
                                        <col width="600">
                                        <col width="300">
                                        <col width="1000">
                                        <thead>
                                        <tr>
                                            <th style = "text-align: center;"><u>Rated by</u></th>
                                            <th style = "text-align: center;"><u>Date</u></th>
                                            <th style = "text-align: center;"><u>Rating</u></th>
                                            <th style = "text-align: center;"><u>Comments</u></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($i=0;$i<$count;$i++){
                                            $rating = mysqli_fetch_assoc($queryRatingResult);
                                            ?>
                                            <tr>
                                                <td style = "text-align: center;">
                                                    <?php
                                                      if ($_SESSION['username'] == $rating['username']){
                                                    ?>
                                                    <?php
                                                    $ratingUsername = $rating['username'];
                                                    echo $ratingUsername;
                                                    ?><input type="submit" name="deleteRating" value="Delete My Rating" />
                                                    <?php
                                                    } else { ?>
                                                          <?php $ratingUsername = $rating['username'];
                                                          echo $ratingUsername; ?>
                                                          <?php
                                                      }
                                                    ?>
                                                </td>
                                                <td style = "text-align: center;">
                                                    <?php
                                                    $ratingDate = $rating['rate_time'];
                                                    echo $ratingDate;
                                                    ?>
                                                </td>
                                                <td style = "text-align: center;">
                                                    <?php
                                                    $ratingStars = $rating['number_of_stars'];
                                                    echo $ratingStars;
                                                    ?>
                                                </td>
                                                <td style = "text-align: center;">
                                                    <?php
                                                    $ratingComments = $rating['comments'];
                                                    echo $ratingComments;
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label"><div style="width: 150px;">My Rating</div></td>
                            <td><div class="column right">
                                <select name="number_of_stars" maxlength="50"  />
                                <option value="select">--Select--</option>
                                <option value="0Unsatisfactory">0Unsatisfactory</option>
                                <option value="1Poor">1Poor</option>
                                <option value="2Fair">2Fair</option>
                                <option value="3Average">3Average</option>
                                <option value="4Good">4Good</option>
                                <option value="5Excellent">5Excellent</option>
                                </select></br>
                            </div></td>
                        </tr>


                        <tr>
                            <td class="item_label"><div style="width: 150px;">Comments</div></td>
                            <td><div style="width: 10px;"><input type="text" name="comments" value="<?php echo isset($_POST["comments"]) ? $_POST["comments"] : ''; ?>"/></div></td>
                            <td><div style="width: 300px;color:red;"><?php echo $bidErr;?></div></td>
                        </tr>
                    </table>
                    </br>


                    <div class="buttons">
                        <input type="submit" name="cancel" value="Cancel"/>
                        <input type="submit" name="Rate" value="Rate This Item"/>
                    </div>
    </div>
    </form>

    <?php include("lib/error.php");?>

</div>
</div>
</body>
</html>