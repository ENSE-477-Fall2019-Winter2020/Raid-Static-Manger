<?php
$con = new mysqli("localhost", "gaoha202", "project", "gaoha202");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$now_date = date("Y-m-d");
$tmp_sql = "SELECT * FROM History WHERE auction_status = -2 and auction_end_date < '$now_date'";
$list = $con->query($tmp_sql);

while ( $row = $list->fetch_assoc() ) {
    $tmp_battle_id = $row['battle_id'];
    $tmp_uid = $row['uid'];
    $tmp_auction_end_date = $row['auction_end_date']." 23:59:59";
    
    
    $tmp_sql = "SELECT * FROM (
          SELECT * FROM Auction WHERE battle_id = '$tmp_battle_id'
          and date <= '$tmp_auction_end_date' order by bp desc limit 10000 ) AS tmp group by item_id";
    $tmp_list = $con->query($tmp_sql);
    
    while ( $tmp_row = $tmp_list->fetch_assoc() ) {
        $tmp_dropped_id = $tmp_row['item_id'];
        $tmp_sql = "SELECT * FROM Dropped WHERE item_id = '$tmp_dropped_id'";
        $tmp_result = $con->query($tmp_sql);
        $tmp_dropped_info  = $tmp_result->fetch_assoc();
        if( !$tmp_dropped_info ){
            continue;
        }
        $tmp_bid_bp = $tmp_row['bp'];
       
       
        $tmp_name = $tmp_row['members_name'];
        $tmp_uid = $tmp_row['uid'];
        $tmp_item = $tmp_dropped_info['item_name'];
        $tmp_sql = "INSERT INTO Obtained ('uname','item','uid',)  VALUES ('$tmp_name','$tmp_item','$tmp_uid')";
        $con->query( $tmp_sql );

       
        $tmp_sql = "SELECT * FROM Performance WHERE battle_id = {$tmp_battle_id}";
        $tmp_result = $con->query($tmp_sql);
        
        while ( $tmp_performance_row = $tmp_result->fetch_assoc() ){
           
            $tmp_member_name = $tmp_performance_row['members_name'];
            $tmp_sql = "UPDATE Members SET BP = BP - '$tmp_bid_bp'  WHERE uname = '$tmp_member_name' and uid = '$tmp_uid'";
            $con->query( $tmp_sql );
        }

       
        $tmp_sql = "UPDATE Auction SET status = 1 WHERE id = ".$tmp_row['id'];
        $con->query( $tmp_sql );
      
        $tmp_sql = "UPDATE History SET auction_status = 1 WHERE battle_id = '$tmp_battle_id'";
        $con->query( $tmp_sql );
    }
}
?>