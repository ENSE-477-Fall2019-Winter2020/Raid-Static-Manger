<?php
//session
session_start();
if (! isset($_SESSION["uid"])) {
    header("Location: rsmLogin.php");
    exit();
} else {
    $user_id = $_SESSION["uid"];
    $username = $_SESSION["uname"];
//connection check
    $con = new mysqli("localhost", "gaoha202", "project", "gaoha202");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
}

//retriving data
$member = "SELECT * FROM Members WHERE uid='$user_id'";
$members = $con->query($member);

//add new memebres
if (isset($_POST["add"])) {
    $mname = $_POST["mname"];
    $job = $_POST["job"];
    $mbp = $_POST["mbp"];

    $add = "INSERT INTO Members(uname, job, BP, members_id,uid, date) VALUES ('$mname', '$job','$mbp',NULL, '$user_id',NOW())";
    $added = $con->query($add);
    header("location:memberChange.php");
}

//remove members
if (isset($_POST["remove"])) {
    $id = $_POST["id"];
    $remove = "DELETE FROM Members WHERE uid = '$user_id' AND members_id = '$id'";
    $rm = $con->query($remove);
    header("location:memberChange.php");
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="en" xml:lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="style.css">
<title>Members Change</title>
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
	<!-- main -->
	<main>
	<table style="margin-bottom: 10px">
		<tbody>
			<tr>
				<td width="25%"><img style="height: 600px"
					src="artResources/character1.jpg" alt="" class="img" /></td>
				<td width="50%">
					<div class="history-box">
						<div class="title cl">
							<h3>Change Members</h3>
						</div>
						<div style="padding-bottom: 10px">
							<form class="rsmadd" action="memberChange.php" method="post"
								enctype="multipart/form-data">
								<table>
									<tbody>
										<tr>
											<td>Member Name:</td>
											<td><input class="right_msg" type="text" name="mname"
												size="20" /></td>
											<td>Job:</td>
											<td><input class="right_msg" type="text" name="job" size="5" /></td>
											<td>BP:</td>
											<td><input class="right_msg" type="text" name="mbp" size="1" /></td>
											<td></td>
											<td><input class="btn" type="submit" name="add"
												value="Add New Member" /></td>
										</tr>

									</tbody>
								</table>
							</form>
						</div>


						<div class="history-table">
							<div class="table-head">
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr class="bt_ph">
											<td>Name</td>
											<td width="25%">Job</td>
											<td width="15%">BP</td>
											<td width="15%">Operation</td>
										</tr>
									</tbody>
								</table>
							</div>
							
							<div class="table-body progress_scroll" style="height: 450px">
								<table style="border-collapse: collapse;" width="100%"
									border="0" cellpadding="0" cellspacing="0">
									<tbody>
                                <?php
                                while ($row = $members->fetch_assoc()) {
                                    ?>
                                <form class="rsmadd"
											action="memberChange.php" method="post"
											enctype="multipart/form-data">
											<tr>
												<td><?=$row["uname"]?></td>
												<td width="25%"><?=$row["job"]?></td>
												<td width="15%"><?=$row["BP"]?></td>
												<td><input type="hidden" name="id"
													value=<?=$row["members_id"]?></td>
												<td width="15%"><input type="submit" class="btn"
													name="remove" value="remove" /></td>
											</tr>
										</form>
                   	<?php }?>
                                </tbody>
								</table>
							</div>
						</div>
					</div>
				</td>
				<td width="25%"><img style="height: 600px"
					src="artResources/character2.jpg" alt="" class="img fr" /></td>
			</tr>
		</tbody>
	</table>
	<footer>&copy;gaoha202@uregina.ca</footer> </main>
</body>
</html>