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
<!DOCTYPE html>
<html dir="ltr" lang="en" xml:lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="raidRecord.css">
<title>Rercord List</title>
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
				<?php echo "Welcome ! Dear User ";echo $username; ?>
			</li>
			<li class="nav-item"><a href="rsmLogout.php">Log out</a></li>
		</ul>
	</nav>
	<main class="clearfix">
	<table style="margin-bottom: 10px">
		<tbody>
			<tr>
				<td width="25%"><img style="height: 600px"
					src="artResources/character1.jpg" alt="" class="img" /></td>
				<td width="50%">
					<div class="history-box">
						<div class="title cl">
							<h3>RecordList</h3>
						</div>
						<div class="history-table" style="border: 0px">
							<div class="table-body2  progress_scroll"
								style="height: 520px; overflow-y: visible;">
								
								<div style="border: 2px solid black;">
 <?php
$history = "SELECT * FROM History WHERE uid = '$user_id' ORDER BY date DESC LIMIT 8";
$his = $con->query($history);
while ($row = $his->fetch_assoc()) {
    ?>
									<table style="border-collapse: collapse;" width="100%"
										border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td><h2 ><?=$row['location'];?></h2></td>
											</tr>
											<tr style="border-top: 1px solid black">
												<td><?=$row['date'];?></td>
												<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td>TotalDPS:&nbsp;<?=$row["dps"]?></td>
												<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td>TotalTime:&nbsp;<?=$row["time"]?></td>
											</tr>
										</tbody>
									</table>
									
									<table class="textac"
										style="border-collapse: collapse; color: #a2adde;"
										width="100%" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td><p>MemberName</p></td>
												<td width="20%"><p>Attendance(Y/N)</p></td>
												<td width="10%"><p>DPS</p></td>
												<td width="15%"><p>MistakeTimes</p></td>
												<td width="15%"><p>DeathTimes</p></td>
												<td width="10%"><p>BP(+/-)</p></td>
											</tr>
											
                                    <?php
    $plist = "select * from Performance where uid = '$user_id' and battle_id = {$row['battle_id']}";
    $perfList = $con->query($plist);
    while ($show_list = $perfList->fetch_assoc()) {
        ?>
                                    <tr>
												<td><?=$show_list['members_name'];?></td>
												<td><?=$show_list['attendance'];?></td>
												<td><?=$show_list['dps'];?></td>
												<td><?=$show_list['mistake'];?></td>
												<td><?=$show_list['death'];?></td>
												<td><?=$show_list['bp'];?></td>
											</tr>
                                    <?php }?>
											
										</tbody>
									</table>

									<table style="border-collapse: collapse;" width="80%"
										border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td><h4>Dropped Items:</h4></td>
											</tr>
											<tr>
												<?php
                    $item = "select * from Dropped where uid = '$user_id' and battle_id = {$row['battle_id']}";
                    $items = $con->query($item);
                    while ($itemList = $items->fetch_assoc()) {
                        $id = $itemList['item_id'];
                        ?>

												<td>Item:&nbsp;</td>
												<td><a
													href="itemAuction.php?item_id=<?=$itemList['item_id']?>"><?=$itemList['item_name'];?></a></td>
												<?php }?>
											  </tr>
										</tbody>
									</table>
									<hr />
									<?php }?>
									<br />
								</div>
								<div class="history-box"
									style="color: #ff0000; text-align: center;">&copy;gaoha202@uregina.ca</div>
							</div>
						</div>
					</div>
				</td>
				<td width="25%"><img style="height: 600px"
					src="artResources/character2.jpg" alt="" class="img fr" /></td>
			</tr>
		</tbody>
	</table>
	</main>
</body>		
</html>
	<?php
$con->close();
?>		