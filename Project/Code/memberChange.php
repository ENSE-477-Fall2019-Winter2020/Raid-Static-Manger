<?php
session_start();
if (! isset($_SESSION["uid"])) {
    header("Location: rsmLogin.php");
    exit();
} else {
    $user_id = $_SESSION["uid"];
    $username = $_SESSION["uname"];

    $con = new mysqli("localhost", "username", "password", "username");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
}

$member = "SELECT * FROM Members";
$members = $con->query($member);

if (isset($_POST["add"])) {
    $mname = $_POST["mname"];
    $job = $_POST["job"];
    $mbp = $_POST["mbp"];

    $add = "INSERT INTO Members(uname, job, BP, members_id, date) VALUES ('$mname', '$job','$mbp',NULL, NOW())";
    $added = $con->query($add);
    header("memberChange.php");
}else{
    header("memberChange.php");
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
				class="quicklink"><a href="#">Raid Record</a></span> <span
				class="quicklink"><a href="memberDetail.php">Members Detail</a></span> <span
				class="quicklink"><a href="memberChange.php">Add/Remove Members</a></span> <span
				class="welcome"><?php echo "Welcome ! Dear User "?></span><span
				class="welcome" id="username"><?php echo $username;?></span> <span
				class="logout"><a href="rsmLogout.php">Log out</a></span>
		</div>
	</header>
	<section>
		<form id="rsmADD" action="memberChange.php" method="post"
			enctype="multipart/form-data">
			<div id="Members">
				<p class="titles">Static Members List</p>
				<table id="membersList">

					<tr>
						<td><p>Member Name</p></td>
						<td><p>Job</p></td>
						<td><p>BP</p></td>
					</tr>
				<?php
    if (isset($_POST["remove"])) {
        $id = $_POST["id"];
        $remove = "DELETE FROM Members WHERE members_id = '$id'";
        $rm = $con->query($remove);
    } else {

        header("memberChange.php");
    }
    while ($row = $members->fetch_assoc()) {
        ?>
					<tr>
						<td><P><?=$row["uname"]?></P></td>
						<td><p><?=$row["job"]?></p></td>
						<td><p><?=$row["BP"]?></p></td>
						<td><input type="hidden" name="id" value=<?=$row["members_id"]?>></td>
						<td><input type="submit" name="remove" value="remove" /></td>
					</tr>
				<?php }?>
			<tr>
						<td></td>
						<td><p class="err_msg"><?php echo $error1;?></p></td>
					</tr>
					<tr>
						<td>Member Name:</td>
						<td><input class="right_msg" type="text" name="mname" size="20" /></td>
						<td>Job:</td>
						<td><input class="right_msg" type="text" name="job" size="5" /></td>
						<td>BP:</td>
						<td><input class="right_msg" type="text" name="mbp" size="1" /></td>
						<td></td>
						<td><input class="add" type="submit" name="add"
							value="Add New Member" /></td>
					</tr>
				</table>
		
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