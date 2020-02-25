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
				class="quicklink"><a href="newRecord.php">Add New Record</a></span><span
				class="quicklink"><a href="raidRecord.php">Raid Record</a></span> <span
				class="quicklink"><a href="memberDetail.php">Members Detail</a></span>
			<span class="quicklink"><a href="memberChange.php">Add/Remove Members</a></span>
			<span class="welcome"><?php echo "Welcome ! Dear User "?></span><span
				class="welcome" id="username"><?php echo $username;?></span> <span
				class="logout"><a href="rsmLogout.php">Log out</a></span>
		</div>
	</header>
	<section>
		<div class="content">
			<div id="recordList">
                <?php
                $history = "SELECT * FROM History WHERE uid = '$user_id' ORDER BY date DESC LIMIT 8";
                $his = $con->query($history);
                while ($row = $his->fetch_assoc()) {
                    ?>
                    <div class="summary">
					<table>
						<tr>
							<td><p class="titles"><?=$row['location'];?></p></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>

							<td>Date:</td>
							<td> <?=$row['date'];?> </td>

						</tr>
						<tr>
							<td><p>DPS:</p></td>
							<td><?=$row["dps"]?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>

							<td><p>Total Time:</p></td>
							<td><?=$row["time"]?></td>
						</tr>
						</div>
					</table>
					<br />
					<table>
						<tr>
							<td>Member Name</td>
							<td>Attendance(Y/N)</td>
							<td>DPS</td>
							<td>Mistakes</td>
							<td>Deaths</td>
							<td>BP(+/-)</td>
						</tr>

                                    <?php
                    $tmp_sql = "select * from Performance where uid = '$user_id' and battle_id = {$row['battle_id']}";
                    $performance_list = $con->query($tmp_sql);
                    while ($tmp_row = $performance_list->fetch_assoc()) {
                        ?>
                                    <tr>
							<td><?=$tmp_row['members_name'];?></td>
							<td><?=$tmp_row['attendance'];?></td>
							<td><?=$tmp_row['dps'];?></td>
							<td><?=$tmp_row['mistake'];?></td>
							<td><?=$tmp_row['death'];?></td>
							<td><?=$tmp_row['bp'];?></td>
						</tr>
                                    <?php }?>
                                </table>
					<br />
					
							<p>Dropped Items</p>
						<table>
						<tr>
                                    <?php
                    $tmp_sql = "select * from Dropped where uid = '$user_id' and battle_id = {$row['battle_id']}";
                    $drop_list = $con->query($tmp_sql);
                    while ($tmp_row = $drop_list->fetch_assoc()) {
                        $id = $tmp_row['item_id'];
                        ?>
                         
                         <td>Item:</td>
							<td><a href="itemAuction.php?itme_id=<?=$tmp_row['item_id']?>"><?=$tmp_row['item_name'];?></a></td>
						<td></td><td></td><td></td><td></td>
                                    <?php }?>
                                    </tr>
                                </table>

					<hr />
                <?php }?>
            </div>
			</div>
	
	</section>

	<hr />
	<footer> copy right @gaoha202</footer>
    <?php
    $con->close();
    ?>
</body>
</html>