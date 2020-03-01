<?php
session_start();
$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : 0;
if (! $item_id) {
    echo "Unavaliable id";
    exit();
}

if (! isset($_SESSION["uid"])) {
    header("Location: rsmLogin.php");
    exit();
} else {
    $user_id = $_SESSION["uid"];
    $username = $_SESSION["uname"];

    $con = new mysqli("localhost", "gaoha202", "project", "gaoha202");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
}

$tmp_sql = "SELECT * FROM Dropped WHERE item_id = '$item_id'";
$result = $con->query($tmp_sql);
$dropped_info = $result->fetch_assoc();
if (! $dropped_info) {
    header("location:itemAuction.php?item_id='$item_id'");
    exit(0);
}

if (isset($_POST["bid"])) {
    
    $mname = $_POST["mname"];
    $job = $_POST["job"];
    $mbp = $_POST["mbp"];
    $battle_id = $dropped_info['battle_id'];
    $uid = $dropped_info['uid'];
    
    $add = "INSERT INTO Auction(item_id, members_name, job,bp, date,battle_id,uid) VALUES ('$item_id', '$mname','$job','$mbp',NOW(),'$battle_id','$uid')";
    $added = $con->query($add);
    header("location:itemAuction.php?item_id=$item_id");
    exit(0);
}
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="rsmMain.css" type="text/css" />
</head>
<body>

	<header>
		<h1>
			<p>
				<img src="ffxiv.png" alt="" style="position: inline" width="100%"
					height="20%" />Raid Static Manager
			</p>

		</h1>


		<div id="header">
			<span class="quicklink"><a href="mainpage.php">Home</a></span> <span
				class="quicklink"><a href="newRecord.php">Add New Record</a></span><span
				class="quicklink"><a href="raidRecord.php">Raid Record </a></span> <span
				class="quicklink"><a href="memberDetail.php">Members Detail</a></span>
			<span class="quicklink"><a href="memberChange.php">Add/Remove Members</a></span>
			<span class="welcome"><?php echo "Welcome ! Dear User "?></span><span
				class="welcome" id="username"><?php echo $username;?></span> <span
				class="logout"><a href="rsmLogout.php">Log out</a></span>
		</div>
	</header>
	<section>

		<div id="auctions">
			<p>Auction : <?=$dropped_info['item_name'];?></p>
			<form class="rsmadd" action="itemAuction.php?item_id=<?=$item_id;?>"
				method="post" enctype="multipart/form-data">
				<tr>
					<td>Member Name:</td>
					<td><input class="right_msg" type="text" name="mname" size="20" /></td>
					<td>Job:</td>
					<td><input class="right_msg" type="text" name="job" size="5" /></td>
					<td>BP:</td>
					<td><input class="right_msg" type="text" name="mbp" size="1" /></td>
					<td></td>
					<td><input class="add" type="submit" name="bid" value="Bid" /></td>

				</tr>
			</form>
			<table>
				<tr>
					<td><p>Member Name</p></td>
					<td><p>Job</p></td>
					<td><p>BP</p></td>
				</tr>
				 <?php
    $tmp_sql = "select * from Auction WHERE item_id = '$item_id' LIMIT 8";
    $bid_list = $con->query($tmp_sql);
    while ($tmp_row = $bid_list->fetch_assoc()) {
        ?><tr>

					<td><?=$tmp_row["members_name"]?></td>
					<td><p><?=$tmp_row["job"]?></p></td>
					<td><p><?=$tmp_row["bp"]?></p></td>
				</tr>
                                    <?php }?>
                                    
			</table>

			<hr />
            
<?php

$con->close();
?>
</div>
	</section>
	<hr />

	<footer> @copy right @gaoha202 </footer>

</body>
</html>