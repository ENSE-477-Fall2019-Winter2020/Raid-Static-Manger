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

$detail = "SELECT Members.uname,Members.job,Members.BP,Obtained.item FROM Members LEFT JOIN Obtained ON Members.uname = Obtained.uname ";
$details = $con->query($detail);
?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="rsmDetail.css" type="text/css" />
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
				class="quicklink"><a href="memberDetail.php">Members Detail</a></span>
			<span class="quicklink"><a href="memberChange.php">Add/Remove Members</a></span>
			<span class="welcome"><?php echo "Welcome ! Dear User "?></span><span
				class="welcome" id="username"><?php echo $username;?></span> <span
				class="logout"><a href="rsmLogout.php">Log out</a></span>
		</div>
	</header>
	<section>
		<form id="rsmADD" action="memberChange.php" method="post"
			enctype="multipart/form-data">
			<div id="Members">
				<p class="titles">Static Members List</p>
				<?php
    while ($row = $details->fetch_assoc()) {
        ?>
				<table id="membersList">
					<tr>
						<td><p>Name:</p></td>
						<td><P><?=$row["uname"]?></P></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><p>JOB:</p></td>
						<td><p><?=$row["job"]?></p></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><p>BP:</p></td>
						<td><p><?=$row["BP"]?></p></td>
					</tr>
				</table>

				<div id="item">
					<p class="titles">items :</p>
					<p><?=$row["item"]?></p>
				</div>
				<br/>				
		<?php }?>
		
		
		
		
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