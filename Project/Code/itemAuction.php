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

    if ($mname==""||$job==""||$mbp == "") {
        $error = "Input cannot be empty!";
    } else {
        $error = "";
        $add = "INSERT INTO Auction(item_id, members_name, job,bp, date,battle_id,uid) VALUES ('$item_id', '$mname','$job','$mbp',NOW(),'$battle_id','$uid')";
        $added = $con->query($add);
        header("location:itemAuction.php?item_id=$item_id");
       
    }
  
}

$bid = "select * from Auction WHERE item_id = '$item_id' LIMIT 8";
$bids = $con->query($bid);
?>
<!DOCTYPE>
<html dir="ltr" lang="en" xml:lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="rsmMain.css">
<link rel="stylesheet" type="text/css" href="error.css" />

<title>MainPage</title>
</head>
<body>
	<header></header>
	<nav class="nav clearfix">
		<ul>
			<li class="nav-item"><a href="mainpage.php">Home</a></li>
			<li class="nav-item"><a href="newRecord.php">Add New Record</a></li>
			<li class="nav-item"><a href="raidRecord.php">Raid Record </a></li>
			<li class="nav-item"><a href="memberDetail.php">Members Detail</a></li>
			<li class="nav-item"><a href="memberChange.php">Add/Remove Members</a></li>
		</ul>
		<ul class="fr">
			<li class="nav-item"><?php echo "Welcome ! Dear User ";  echo $username;?></li>
			<li class="nav-item"><a href="rsmLogout.php">Log out</a></li>
		</ul>
	</nav>
	<main class="clearfix">

		<div id="auctions">
			<p>Auction : <?=$dropped_info['item_name'];?></p>
			<form class="rsmadd" action="itemAuction.php?item_id=<?=$item_id;?>"
				method="post" enctype="multipart/form-data">
				<tr>
					<p class="err_msg"><?php echo "$error";?></p>
				</tr>
				<tr>
					<td>Member Name (full):</td>
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
    while ($list = $bids->fetch_assoc()) {
        ?><tr>

					<td><?=$list["members_name"]?></td>
					<td><p><?=$list["job"]?></p></td>
					<td><p><?=$list["bp"]?></p></td>
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