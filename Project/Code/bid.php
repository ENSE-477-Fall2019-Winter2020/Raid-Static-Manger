<?php

/**
 * This file is using to check the hightest bider,
 * and automatically assign the item and update the 
 * BP for the particular user.
 */

// connect to database
$con = new mysqli("localhost", "gaoha202", "project", "gaoha202");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// check the auction status : -2-> on sale; 1-> sold
$now_date = date("Y-m-d");
$sql = "SELECT * FROM History WHERE auction_status = -2 and auction_end_date < '$now_date'";
$list = $con->query($sql);

// Auction system
while ($row = $list->fetch_assoc()) {
    $battle_id = $row['battle_id'];
    $uid = $row['uid'];
    $auction_end_date = $row['auction_end_date'] . " 23:59:59";

    // Find the highest bider.
    $sql = "SELECT * FROM (
          SELECT * FROM Auction WHERE battle_id = '$battle_id'
          and date <= '$auction_end_date' order by bp desc limit 10000 ) AS tmp group by item_id";
    $list = $con->query($sql);

    // Searching from the dropped trable
    while ($row = $list->fetch_assoc()) {
        $dropped_id = $row['item_id'];
        $sql = "SELECT * FROM Dropped WHERE item_id = '$dropped_id'";
        $result = $con->query($sql);
        $dropped_info = $result->fetch_assoc();
        if (! $dropped_info) {
            continue;
        }
        $bid_bp = $row['bp'];

        // Assign the item
        $name = $row['members_name'];
        $uid = $row['uid'];
        $item = $dropped_info['item_name'];
        $sql = "INSERT INTO Obtained ('uname','item','uid',)  VALUES ('$name','$item','$uid')";
        $con->query($sql);

        //Update the BP
        $sql = "SELECT * FROM Performance WHERE battle_id = {$battle_id}";
        $result = $con->query($sql);
        while ($performance_row = $result->fetch_assoc()) {

            $member_name = $performance_row['members_name'];
            $sql = "UPDATE Members SET BP = BP - '$bid_bp'  WHERE uname = '$member_name' and uid = '$uid'";
            $con->query($sql);
            
        }

        //Update auction status
        $sql = "UPDATE Auction SET status = 1 WHERE id = " . $row['id'];
        $con->query($sql);
        $sql = "UPDATE History SET auction_status = 1 WHERE battle_id = '$battle_id'";
        $con->query($sql);
    }
}
echo "Staring Working...."
?>