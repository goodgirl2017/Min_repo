<?php
include('lib/common.php');
// written by mni37
if($showQueries){
    array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}

// check whether user has login or not
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}

// TODO: don't forget there is $_GET['id']
// TODO: the name should cosistent with values in the results from search item
// make sure the id for item exist
if (isset($_GET['id'])){
	$id = $_GET['id'];
	
} else{
// the search_item.php name may differ, if the itemID did not exist, go back to search
	header('Location: search_item.php');
// 	header('Location: main_menu.php');

//    $id = 0; // Just for testing
}

$conditionArray = ['','New','Very Good','Good','Fair','Poor'];
// Convert query result from Item table to associate array
$queryItem = "SELECT * FROM Item ";
$queryItem .= "WHERE ItemID='$id'";
$queryItemResult = mysqli_query($db, $queryItem);
$count = mysqli_num_rows($queryItemResult);
// echo "<script type='text/javascript'>alert('$count');</script>";
$queryItemRow = mysqli_fetch_assoc($queryItemResult);
// In case that the itemID in the url parameter is out of database range
if ($count==0){
// 	array_push($error_msg,  "Sorry, the item did not exist. You are heading back to search item......");
// 	echo '<script type="text/javascript">alert("Sorry, the item did not exist. You are heading back to search item......");</script>';
    header("url=search_item.php"); 
}
// release the data from database
mysqli_free_result($queryItemResult);

//get item condition
$condition = $conditionArray[(int)$queryItemRow['condition_state']];

// GEt it now price
$get_it_now_price = $queryItemRow['get_it_now_price'];

// 
$start_bid_amount = (float)$queryItemRow['starting_bid'];


//get returnable or not
$return = $queryItemRow['returnable'];

//calculate auction end time
$auctionLength = $queryItemRow['auction_length'];
$addTime = "+"."$auctionLength"." day";
$auctionEndTime = date('Y-m-d H:i:s A',strtotime($addTime, strtotime($queryItemRow['start_sell_time'])));

// Convert query result from Bid table to associate array
$queryBid = "SELECT * FROM Bid ";
$queryBid .= "WHERE ItemID='$id' ORDER BY bid_amount DESC LIMIT 4";
$queryBidResult = mysqli_query($db, $queryBid);
$count = mysqli_num_rows($queryBidResult);

//output maximum bidding amount for checking allowed inputting of bid amount
$queryBidMax = "SELECT MAX(bid_amount) FROM Bid ";
$queryBidMax .= "WHERE ItemID='$id'";
$queryBidMaxResult = mysqli_query($db, $queryBidMax);
$BidMax = (mysqli_fetch_row($queryBidMaxResult))[0];
$BidMaxNum = (float)$BidMax; //convert to number
$BidMaxNum=($BidMaxNum>=$start_bid_amount)? $BidMaxNum +=1 : $start_bid_amount;
// isset($BidMaxNum>=$start_bid_amount) ? $BidMaxNum +=1 : $BidMaxNum=$start_bid_amount;

if( $_SERVER['REQUEST_METHOD'] == 'POST') {
//    tell which button is clicked
// 	if（）{
// 		
// 	}else{
// 	}
	
    
    if(isset($_POST['getItNow'])){
        $sqlInsertGetItNow = "INSERT INTO Bid (ItemID, username, bid_time, bid_amount) VALUES ('$id', '{$_SESSION['username']}', NOW(), '{$queryItemRow['get_it_now_price']}');";
// TODO: since there is no auction_end_time attribute, so it is discarded.
//         $sqlUpdateItem = "UPDATE Item SET auction_end_time = NOW() WHERE ItemID = '$id'";
        $resultInsert = mysqli_query($db, $sqlInsertGetItNow);
//         $resultUpdate = mysqli_query($db, $sqlUpdateItem);
     // check whether insert and update succeed or not
//         if ($resultInsert && $resultUpdate){
		$sqlWinner = "UPDATE Item SET winner = '{$_SESSION['username']}' WHERE ItemID = '$id' LIMIT 1";		
		$resultWinner = mysqli_query($db, $sqlWinner);
		if ($resultInsert && $resultWinner){			
//             array_push($query_msg, "Congratulations! You get it! You will going to main menu now.....");
//             header('Refresh: 2; url=main_menu.php'); // After get it now, go back to main memu page
            echo "<script type='text/javascript'>alert('Congratulations! You get it! You are going to main menu now.....');
            window.location='main_menu.php';</script>";
        } else{
            array_push($error_msg,  "Oops, Get It Now did not succeed!");
//             header("Refresh:2"); 
			echo "<script type='text/javascript'>alert('Oops, Get It Now did not succeed!');
			</script>";
        }


    }elseif(isset($_POST['bid'])){
        $enteredBidAmount = mysqli_real_escape_string($db, $_POST['bidamount']);
        if(is_numeric($enteredBidAmount)){
        if($enteredBidAmount >= $start_bid_amount){
//            make sure the bid amount is at least 1 dollar higher and less than get it now price
// 			$v = $enteredBidAmount - $BidMaxNum;
            if ($enteredBidAmount - $BidMaxNum >= 0){
                if (($enteredBidAmount < $get_it_now_price) || ! $get_it_now_price) {
                    $sqlInsert = "INSERT INTO Bid (itemID, username, bid_time, bid_amount) VALUES ('$id', '{$_SESSION['username']}', NOW(), '$enteredBidAmount')";
                    $resultInsert = mysqli_query($db, $sqlInsert);
                    //                check whether insert succeed or not
                    if ($resultInsert) {
   //                      array_push($query_msg, "Congratulations! You get it!  You will going to main menu now.....");
//                         header('Refresh: 3; url=main_menu.php'); // After get it now, go back to main memu page
                        // echo "<script type='text/javascript'>alert('Congratulations! You get it! ');
//            			// </script>";
                        array_push($query_msg, "Congratulations! You bid successfully!");
            			header('Refresh:3');
                    } else {
//                         array_push($error_msg, "Oops, bid did not succeed, please try again!");
//                         header("Refresh:3"); 
                        $bidErr = "Oops, bid did not succeed, please try again!";
                    }
                } else {
//                     array_push($error_msg,  "Oops, your bidding amount is too high, consider get it now option!");
                    $bidErr = "your bid is too high, consider get it now!";
//                     header("Refresh:3"); 
                }
            } else {
//                 array_push($error_msg,  "Oops, Bid Amount should be at least one dollar higher than present maximum bidding!");
//                 header("Refresh:3"); 
                $bidErr = "Oops, Bid Amount should be at least one dollar higher than present maximum bidding!";
            }
            }else{
            	$bidErr = "Oops, Bid Amount is too low!";
            }

        } else{
//             array_push($error_msg,  "Bid Amount should be number!");
//             header("Refresh:3"); 
            $bidErr = "Oops, Bid Amount should be number!";
        }


    }elseif(isset($_POST['cancel'])){
//         array_push($error_msg,  "You are returning back to Search Item......");    
//         header('Refresh:3;url=search_item.php');
        echo "<script type='text/javascript'>alert('You are returning back to Search Item......');
    	window.location='search_item.php';</script>";        

        
    } elseif(isset($_POST['editDescription'])){
        $enteredDescription = mysqli_real_escape_string($db, $_POST['description']);
        $sqlUpdateDescription = "UPDATE Item SET description = '$enteredDescription' WHERE ItemID = '$id' LIMIT 1";
        $resultUpdate = mysqli_query($db, $sqlUpdateDescription);
    //   check whether update description succeed or not
        if ($resultUpdate){
//             array_push($query_msg, "Congratulations! Description is changed");
//             header("Refresh:3"); // refresh the page
            echo "<script type='text/javascript'>alert('Congratulations! Description is changed!');</script>";        
                        
        } else{
        	echo "<script type='text/javascript'>alert('Oops, description failed to be changed!');
    		window.location.reload(true);</script>";        
//         	array_push($error_msg,  "Oops, description failed to be changed!");
//         	header("Refresh:3"); // refresh the page
        }

    }

    }
?>



<?php include("lib/header.php"); ?>
<html lang="de-DE">
	<head>
    	<title>View and Edit Item</title>
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
			<div class="min_box">

		<form action= "<?php echo "view_item.php?id="."$id"; ?>" method="post" enctype="multipart/form-data">
			<div class="title">Item Details</div>
			</br>
					<table class="inputtable" summary="This data table is used to format the user registration fields">
						<table>
			
						<tr>
							<td class="item_label"><div style="width: 150px;">Item ID</div></td>
							<td><?php echo "$id"."          " ?> <a href="<?php echo "rate_item.php?id="."$id"?>">View Ratings </a></td>
<!-- 							<td><a href="<?php echo "rate_item.php?id="."$id"?>">View Ratings </a> </td> -->
						</tr>
						<tr>
							<td class="item_label"><div style="width: 150px;">Item Name</div></td>
							<td><?php echo  $queryItemRow['item_name']; ?></td>
						</tr>										
						
						<tr>
							<td class="item_label"><div style="width: 150px;">Description</div></td>
							<td>
							<?php
                    			if($_SESSION['username'] == $queryItemRow['username']){ 
                    		?>
                    			<textarea rows="4" cols="30" id="description" name="description">
								<?php echo isset($_POST["description"]) ? $_POST["description"] : $queryItemRow['description']; ?>
                        		</textarea>
                        		<input type="submit" name="editDescription" value="Edit Description" />
                    		<?php
                    			} else{ ?>
                    				<?php echo $queryItemRow['description']; ?>
                    		<?php
                    			}
                    		?>

							</td>
						</tr>											
						
						<tr>
							<td class="item_label"><div style="width: 150px;">Category</div></td>						
							<td><div style="width: 300px;"><?php echo $queryItemRow['categoryname']; ?></div></td>
						</tr>

						<tr>
							<td class="item_label"><div style="width: 150px;">Condition</div></td>
							<td><div style="width: 300px;"><?php echo $condition;?></div></td>
						</tr>
						
						<tr>
							<td class="item_label"><div style="width: 150px;">Returns Accepted</div></td>
							<td><div style="width: 300px;">
								<?php
									if ($return == "True"){ 
								?>
								<input type="checkbox" disabled="disabled" checked="checked">
								<?php
									}else{ 
								?>
										<input type="checkbox"  disabled="disabled" >
								<?php
									} 
								?>
								</div></td>
						</tr>													
						
						<tr>
							<td class="item_label"><div style="width: 150px;">Get it Now Price</div></td>
							<?php 
								if($get_it_now_price){ ?>
									<td><?php echo "$".$get_it_now_price ?>  <input type="submit" name="getItNow" value="Get It Now" /></td>
								<?php
								}
							?>
							
<!-- 							<td><input type="submit" name="getItNow" value="Get It Now" /></td>                         -->
						</tr>
						
						<tr>
							<td class="item_label"><div style="width: 150px;">Auction Ends</div></td>
							<td><div style="width: 300px;"><?php echo $auctionEndTime ?></div></td>
						</tr>																		
						
						<tr>
							<td class="item_label"><div style="width: 150px;">Latest Bids</div></td>
							<td><div style="width: 600px;">
								<table class="table" border="1" style="width=500px" align="center"  >

            					<col width="100">
            					<col width="200">
            					<col width="200">
                				<thead>
                				<tr>
                    				<th style = "text-align: center;"><u>Bid Amount</u></th>
                    				<th style = "text-align: center;"><u>Time of Bid</u></th>
                    				<th style = "text-align: center;"><u>Username</u></th>
                				</tr>
               				 </thead>
                			<tbody>
                			<?php 
                				for ($i=0;$i<$count;$i++){
                				$bid = mysqli_fetch_assoc($queryBidResult);
                			?>
                			<tr>
                    			<td style = "text-align: center;">
                        		<?php
                        			$bidAmount = $bid['bid_amount'];
                        			echo "$"."$bidAmount";
                        		?>
                    			</td>
                    			<td style = "text-align: center;">
                    			<?php
                    				$bidDate = $bid['bid_time'];
                        			echo $bidDate;
                        		?>
                    			</td>
                    			<td style = "text-align: center;">
                        			<?php
                        				$Bidusername = $bid['username'];
                        				echo $Bidusername;
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
							<td class="item_label"><div style="width: 150px;">Your Bid</div></td>
							<td><div style="width: 10px;"><input type="text" name="bidamount" value="<?php echo isset($_POST["bidamount"]) ? $_POST["bidamount"] : ''; ?>"/></div><div style="width: 300px;color:red;"><?php echo $bidErr;?></div></td>
<!-- 							<td><div style="width: 300px;color:red;"><?php echo $bidErr;?></div></td> -->
						</tr>
						
						<tr>
							<td class="item_label"><div style="width: 150px;"></div></td>
							<td>(minimum bid $<?php echo $BidMaxNum ?>)</td>
<!-- 
							<td>(a bid $<?php echo gettype($enteredBidAmount) ?>)</td>
							<td>(i bid $<?php echo gettype($BidMaxNum) ?>)</td>
							<td>(m bid $<?php $v =$BidMaxNum-$enteredBidAmount; echo $v ?>)</td>
 -->
						</tr>
						
					</table>
			
			</br>


            <div class="buttons">
<!--                Only provide this option, when get it now price is available-->
<!-- 
 -->
				<input type="submit" name="cancel" value="Cancel" />
				<input type="submit" name="bid" value="Bid on this Item"/>
			</div>
			</div>
		</form>
		
        <?php include("lib/error.php");?>
<!--     </div> -->
		</div>
	</div>
	</body>
</html>


