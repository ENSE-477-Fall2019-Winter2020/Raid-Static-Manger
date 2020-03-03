<?php
session_start();
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

$member = "SELECT * FROM Members WHERE uid='$user_id'";
$members = $con->query($member);

if (isset($_POST["record"])) {

    $battleArea = $_POST["area"];
    $date = $_POST["date"];
    $tdps = $_POST["tdps"];
    $time = $_POST["time"];
    $uname = $_POST["uname"];
    $atd = $_POST["atd"];
    $dps = $_POST["dps"];
    $mistake = $_POST["mistake"];
    $death = $_POST["death"];
    $bp = $_POST["bp"];
    $item1 = $_POST["item1"];
    $item2 = $_POST["item2"];
    $item3 = $_POST["item3"];
    $item4 = $_POST["item4"];
    $item5 = $_POST["item5"];
    $item6 = $_POST["item6"];
    $auction_start_date = date("Y-m-d");
    $auction_end_date = date("Y-m-d", strtotime("+1 days"));
    $battle = "INSERT INTO History (battle_id, uid, location, date, dps, time,auction_start_date,auction_end_date) VALUES (null, '$user_id', '$battleArea','$date','$tdps','$time','$auction_start_date','$auction_end_date')";
    $summary = $con->query($battle);

    $battle_id = mysqli_insert_id($con);

    $dm = "INSERT INTO Dropped (item_id, battle_id, uid, item_name) VALUES (null, '$battle_id', '$user_id', '$item1'),
    (null, '$battle_id', '$user_id', '$item2'), (null, '$battle_id', '$user_id', '$item3'), (null, '$battle_id', '$user_id', '$item4'), (null, '$battle_id', '$user_id', '$item5'),
    (null, '$battle_id', '$user_id', '$item6')";
    $rm = "DELETE FROM Dropped WHERE item_name = ''";
    $items = $con->query($dm);
    $remove = $con->query($rm);
    foreach ($uname as $_idx => $_uname) {
        $tmp_atd = $atd[$_idx];
        $tmp_dps = $dps[$_idx];
        $tmp_amistake = $mistake[$_idx];
        $tmp_death = $death[$_idx];
        $tmp_bp = $bp[$_idx];
        $mp = "INSERT INTO Performance (battle_id,uid,members_name,attendance,dps,mistake,death,bp) VALUES ('$battle_id','$user_id','$_uname','$tmp_atd','$tmp_dps','$tmp_amistake','$tmp_death','$tmp_bp')";
        $mbc = "UPDATE Members SET BP = BP + '$tmp_bp' WHERE uname ='$_uname' AND uid = '$user_id'";
        $performance = $con->query($mp);
        $bpChange = $con->query($mbc);
    }
    header("location:raidRecord.php");
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en" xml:lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="style.css">
<title>New Record</title>
</head>

<body>
	<header></header>
	<nav class="nav clearfix">
		<ul>
			<li class="nav-item"><a href="mainpage.php">Home</a></li>
			<li class="nav-item"><a href="newRecord.php">Add New Record</a></li>
			<li class="nav-item"><a href="raidRecord.php">Raid Record</a></li>
			<li class="nav-item"><a href="memberDetail.php">Members Detail</a></li>
			<li class="nav-item"><a href="memberChange.php">Add/Remove Members</a></li>
		</ul>
		<ul class="fr">
			<li class="nav-item">
				<?php echo "Welcome ! Dear User ";echo $username; ?></li>
			<li class="nav-item"><a href="rsmLogout.php">Log out</a></li>
		</ul>
	</nav>
	<!-- main -->
	<main class="clearfix">
	<table style="margin-bottom: 10px">
	
			<tr>
				<td width="25%"><img style="height: 600px"
					src="artResources/character1.jpg" alt="" class="img" /></td>
				<td width="50%" class="valignt">
					<div class="history-box">
						<div class="title cl">
							<h3>New Record</h3>
						</div>
						<div id="newRecord">
							<form id="record" action="newRecord.php" method="post">
								<table id="summary" class="widthfull">
									<tr>
										<td><p>Battle Area:</p></td>
										<td><input class="right_msg" type="text" name="area" size="20" /></td>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td><p>DATE</p></td>
										<td><input class="right_msg" type="datetime-local" name="date" /></td>
									</tr>
									<tr>
										<td><p>TOTAL DPS:</p></td>
										<td><input class="right_msg" type="text" name="tdps" size="20" /></td>
										<td></td>
										<td><p>TOTAL TIME:</p></td>
										<td><input class="right_msg" type="time" name="time" /></td>
										<td></td>
									</tr>
								</table>

								<br />
								<table class="textac widthfull">
									<tr class="titles">
										<td><p>MemberName</p></td>
										<td width="25%"><p>Attendance(Y/N)</p></td>
										<td width="10%"><p>DPS</p></td>
										<td width="15%"><p>Mistake Times</p></td>
										<td width="15%"><p>Death Times</p></td>
										<td width="10%"><p>BP(+/-)</p></td>
									</tr>
							<?php
                        while ($row = $members->fetch_assoc()) {
                            ?>
				<tr>
										<td><?=$row["uname"]?><input type="hidden" name="uname[]" value="<?=$row["uname"]?>" /></td>
										<td><input class="right_msg" type="text" name="atd[]" size="5" /></td>
										<td><input class="right_msg" type="text" name="dps[]" size="5" /></td>
										<td><input class="right_msg" type="text" name="mistake[]" size="5" /></td>
										<td><input class="right_msg" type="text" name="death[]" size="5" /></td>
										<td><input class="right_msg" type="text" name="bp[]" size="5" /></td>
									</tr>
					
				<?php }?>
		</table>

								<br />
								<p class="titles">DroppedItems</p>
								<table class="history-box widthfull">
									<tr>
										<td>Item1:</td>
										<td><input class="right_msg" type="text" name="item1"
											size="15" /></td>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td>Item2:</td>
										<td><input class="right_msg" type="text" name="item2"
											size="15" /></td>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td>Item3:</td>
										<td><input class="right_msg" type="text" name="item3"
											size="15" /></td>
									</tr>
									<tr>
										<td>Item4:</td>
										<td><input class="right_msg" type="text" name="item4"
											size="15" /></td>
										<td></td>
										<td>Item5:</td>
										<td><input class="right_msg" type="text" name="item5"
											size="15" /></td>
										<td></td>
										<td>Item6:</td>
										<td><input class="right_msg" type="text" name="item6"
											size="15" /></td>
									</tr>
								</table>
								
								<div class="btn-add textac">
									<input class="right_msg btn" type="submit" name="record" value="AddRecord" />
								</div>
							</form>
						</div>
					</div>
				</td>
				<td width="25%"><img style="height: 600px"
					src="artResources/character2.jpg" alt="" class="img fr" /></td>
			</tr>
		
	</table>
	<?php
    $con->close();
    ?>
	<footer>&copy;gaoha202@uregina.ca</footer> </main>
</body>
</html>