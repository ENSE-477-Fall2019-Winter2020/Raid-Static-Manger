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

    $battle = "INSERT INTO History (battle_id, uid, location, date, dps, time) VALUES (null, '$user_id', '$battleArea','$date','$tdps','$time')";
    $summary = $con->query($battle);

    $battle_id = mysqli_insert_id($con);

    $dm = "INSERT INTO Dropped (item_id, battle_id, uid, item_name) VALUES (null, '$battle_id', '$user_id', '$item1'),
    (null, '$battle_id', '$user_id', '$item2'), (null, '$battle_id', '$user_id', '$item3'), (null, '$battle_id', '$user_id', '$item4'), (null, '$battle_id', '$user_id', '$item5'),
    (null, '$battle_id', '$user_id', '$item6')";
    $rm = "DELETE FROM Dropped WHERE item_name = ''";
    $items = $con->query($dm);
    $remove = $con->query($rm);

    foreach ($uname as $_idx => $_tmp_uname) {
        $tmp_atd = $atd[$_idx];
        $tmp_dps = $dps[$_idx];
        $tmp_amistake = $mistake[$_idx];
        $tmp_death = $death[$_idx];
        $tmp_bp = $bp[$_idx];
        $mp = "INSERT INTO Performance (battle_id,uid,members_name,attendance,dps,mistake,death,bp) VALUES ('$battle_id','$user_id','$_tmp_uname','$tmp_atd','$tmp_dps','$tmp_amistake','$tmp_death','$tmp_bp')";
        $mbc = "UPDATE Members SET BP = BP + '$tmp_bp' WHERE uname ='$_tmp_uname' AND uid = '$user_id'";
        $performance = $con->query($mp);
        $bpChange = $con->query($mbc);
    }
    header("location:mainpage.php");
}
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="rsmADD.css" type="text/css" />
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
				class="quicklink"><a href="newRecord.php">Add New Record</a></span>
			<span class="quicklink"><a href="raidRecord.php">Raid Record</a></span>
			<span class="quicklink"><a href="memberDetail.php">Members Detail</a></span>
			<span class="quicklink"><a href="memberChange.php">Add/Remove Members</a></span>
			<span class="welcome"><?php echo "Welcome ! Dear User "?></span><span
				class="welcome" id="username"><?php echo $username;?></span> <span
				class="logout"><a href="rsmLogout.php">Log out</a></span>
		</div>
	</header>
	<section>
		<p class="titles">New Record</p>
		<div id="newRecord">
			<form id="record" action="newRecord.php" method="post">
				<table id="summary">
					<tr>
						<td><p>Battle Area:</p></td>
						<td><input class="right_msg" type="text" name="area" size="20" /></td>
						<td></td>
						<td></td>
						<td></td>
						<td><p>DATE</p></td>
						<td><input class="right_msg" type="datetime-local" name="date" /></td>
					</tr>
					<tr>
						<td><p>TOTAL DPS:</p></td>
						<td><input class="right_msg" type="text" name="tdps" size="20" /></td>
						<td></td>
						<td></td>
						<td></td>
						<td><p>TOTAL TIME:</p></td>
						<td><input class="right_msg" type="time" name="time" /></td>
						<td></td>
					</tr>
				</table>

				<br /> <br />
				<table>
					<tr>
						<td><p>Member Name</p></td>
						<td><p>Attendance(Y/N)</p></td>
						<td><p>DPS</p></td>
						<td><p>Mistakes</p></td>
						<td><p>Deaths</p></td>
						<td><p>BP(+/-)</p></td>
					</tr>
				<?php
    while ($row = $members->fetch_assoc()) {

        ?>
				<tr>
						<td><?=$row["uname"]?><input type="hidden" name="uname[]"
							value="<?=$row["uname"]?>" /></td>
						<td><input class="right_msg" type="text" name="atd[]" size="5" /></td>
						<td><input class="right_msg" type="text" name="dps[]" size="5" /></td>
						<td><input class="right_msg" type="text" name="mistake[]" size="5" />times</td>
						<td><input class="right_msg" type="text" name="death[]" size="5" />times</td>
						<td><input class="right_msg" type="text" name="bp[]" size="5" /></td>
					</tr>
					
				<?php }?>
		</table>
				<tr>
					<td></td>
					<td> 
							<?php if( isset( $error1 ) ):?>
                            <p class="err_msg"><?php echo $error1;?></p>
                            <?php endif;?>
                       </td>
				</tr>
				</table>
				<p class="titles">Dropped Items</p>
				<table>
					<tr>
						<td>item1<input class="right_msg" type="text" name="item1"
							size="5" /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>item2<input class="right_msg" type="text" name="item2"
							size="5" /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>item3<input class="right_msg" type="text" name="item3"
							size="5" /></td>
					</tr>
					<tr>
						<td>item4<input class="right_msg" type="text" name="item4"
							size="5" /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>item5<input class="right_msg" type="text" name="item5"
							size="5" /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>item6<input class="right_msg" type="text" name="item6"
							size="5" /></td>
					</tr>
				</table>

				<p>
					<input class="right_msg" type="submit" name="record" value="record" />
				</p>
			</form>
		
<?php
$con->close();
?>
	</div>
	</section>
	<hr />
	<footer> copy right @gaoha202</footer>

</body>
</html>