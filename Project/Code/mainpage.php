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

if (isset($_POST["submit"])) {
    $comments = $_POST["comments"];
    $qc = "INSERT INTO Comments(comments_id, uid, comments, uname, date) values (null, '$user_id','$comments','$username',NOW() )";
    if (strlen($comments) == 0 || strlen($comments) > 1000) {
        $error = "Wrong Creation(blank or longer than 1000 characters)";
    } else {
        $result = $con->query($qc);
        header("Location:mainpage.php");
    }
}

if (isset($_POST["remove"])) {
    $id = $_POST["id"];
    $se = "DELETE FROM Comments WHERE uid='$user_id' AND comments_id = '$id'";
    $rm = $con->query($se);
    header("login.php");
}

$comm = "SELECT * FROM Comments WHERE uid ='$user_id' ORDER BY date DESC LIMIT 10";
$com = $con->query($comm);

$history = "SELECT * FROM History WHERE uid = '$user_id' ORDER BY date DESC LIMIT 5";
$his = $con->query($history);

$bp = "SELECT * FROM Members WHERE uid='$user_id' LIMIT 8";
$p = $con->query($bp);

$obtained = "SELECT * FROM Obtained WHERE uid='$user_id'ORDER BY date DESC LIMIT 8";
$obt = $con->query($obtained);
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
	<table style="margin-bottom: 10px">
		<tbody>
			<tr>
				<td width="25%"><img style="height: 900px"
					src="artResources/character1.jpg" alt="" class="img" /></td>
				<td width="50%">
					<div class="history-box">
						<div class="title cl">
							<h3>Battle History</h3>
						</div>
						<div class="history-table">
							<div class="table-head">
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr class="bt_ph">
											<td>Location</td>
											<td width="25%">Date/Time</td>
											<td width="15%">Total DPS</td>
											<td width="15%">Total Time</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="table-body progress_scroll">
								<table style="border-collapse: collapse;" width="100%"
									border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<?php
        while ($row = $his->fetch_assoc()) {
            ?>
				<tr>
											<td><P><?=$row["location"]?></P></td>
											<td><p><?=$row["date"]?></p></td>
											<td><p><?=$row["dps"]?></p></td>
											<td><p><?=$row["time"]?></p></td>
										</tr>			
				<?php }?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="s-table-box history-box fl">
							<div class="title cl">
								<h3>BP</h3>
							</div>
							<div class="history-table">
								<div class="table-head">
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr class="bt_ph">
												<td width="50%">Member Name</td>
												<td width="50%">BP Remaining</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="table-body progress_scroll">
									<table style="border-collapse: collapse;" width="100%"
										border="0" cellpadding="0" cellspacing="0">
										<tbody>
										<?php
        while ($row = $p->fetch_assoc()) {
            ?>
				<tr>
												<td width="50%"><P><?=$row["uname"]?></P></td>
												<td width="50%"><p><?=$row["BP"]?></p></td>
											</tr>
				<?php }?>
									</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="s-table-box history-box fr">
							<div class="title cl">
								<h3>Items Distribution</h3>
							</div>
							<div class="history-table">
								<div class="table-head">
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr class="bt_ph">
												<td width="50%">Member Name</td>
												<td width="50%">Obtained Item</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="table-body progress_scroll">
									<table style="border-collapse: collapse;" width="100%"
										border="0" cellpadding="0" cellspacing="0">
										<tbody>
										<?php
        while ($row = $obt->fetch_assoc()) {
            ?>
				<tr>
												<td width="50%"><P><?=$row["uname"]?></P></td>
												<td width="50%"><p><?=$row["item"]?></p></td>
											</tr>
	<?php }?>
									</tbody>
									</table>
								</div>
							</div>
						</div>
						<div style="padding-top: 290px">
							<div>
								<h3>Comments</h3>
							</div>
							<div style="padding-bottom: 10px">
								<form id="leaveComments" action="mainpage.php" method="post">
									<table>
										<tbody>
											<tr>
												<td><label id="comments_msg" class="err_msg"><?php echo $error;?></label></td>
											</tr>
											<tr>
												<td><textarea class="comments" name="comments"></textarea></td>
											</tr>
										</tbody>
									</table>

									<p class="div">
										<input type="submit" name="submit" value="Add Comment" />
									</p>
								</form>
							</div>
							<div class="history-table">
								<div class="table-head"></div>
								<div class="table-body1 progress_scroll">
									<table id="makeComments">
										<tbody>	
		<?php
while ($row = $com->fetch_assoc()) {
    ?>
									<form action="mainpage.php" method="post">
												<tr>
													<td><p>User:<?=$row["uname"]?></p></td>
													<td><p>Date:<?=$row["date"]?></p></td>
												</tr>
												<tr>
													<td style="word-break: break-all"><?=$row["comments"]?></td>
													<td><input type="hidden" name="id"
														value=<?=$row["comments_id"]?>></td>
													<td><input type="submit" name="remove" value="Delete" /></td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
											</form>
										<?php
}
$con->close();
?>						
									
									
									
									
									</table>
									<br />
								</div>
							</div>
						</div>
				
				</td>
				<td width="25%"><img style="height: 900px"
					src="artResources/character2.jpg" alt="" class="img fr" /></td>
			</tr>
		</tbody>
	</table>


	<hr />
	<footer>&copy;gaoha202@uregina.ca</footer> </main>
</body>
</html>