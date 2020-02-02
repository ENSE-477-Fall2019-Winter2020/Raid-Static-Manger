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
				class="quicklink"><a href="#">Raid Record</a></span> <span
				class="quicklink"><a href="#">Members Detail</a></span> <span
				class="quicklink"><a href="#">Add/Remove Members</a></span> <span
				class="welcome"><?php echo "Welcome ! Dear User "?></span><span class = "welcome" id = "username"><?php echo $username;?></span>
			<span class="logout"><a href="rsmLogout.php">Log out</a></span>
		</div>
	</header>
	<section>
<div class = "content">
		<div id="History">
			<p class = "titles">Battle History</p>
			<table id="battleHistory">

				<tr>
					<td><p>Location</p></td>
					<td><p>Date/Time</p></td>
					<td><p>Total DPS(Damage/Second)</p></td>
					<td><p>Deaths(Times)</p></td>
				</tr>
				<?php
    $history = "SELECT * FROM History ORDER BY date DESC LIMIT 5";
    $his = $con->query($history);
    while ($row = $his->fetch_assoc()) {
        ?>
				<tr>
					<td><P><?=$row["location"]?></P></td>
					<td><p><?=$row["date"]?></p></td>
					<td><p><?=$row["dps"]?></p></td>
					<td><p><?=$row["deaths"]?></p></td>
				</tr>
				
				<?php }?>

			</table>
			<p class="load">
				<a href="#">Load More..</a>
			</p>

		</div>

		<br />

		<div id="BP">
			<p class = "titles">BP</p>
			<table id="membersBP">

				<tr>
					<td><p>Member Name</p></td>
					<td><p>BP Remaining</p>
					
					<td>
				
				</tr>
					<?php
    $bp = "SELECT * FROM BP LIMIT 8";
    $p = $con->query($bp);
    while ($row = $p->fetch_assoc()) {
        ?>
				<tr>
					<td><P><?=$row["uname"]?></P></td>
					<td><p><?=$row["BP"]?></p></td>
				</tr>
				
				<?php }?>

			</table>
			<p class="load">
				<a href="#">Load More..</a>
			</p>
		</div>

		<br />

		<div id="item">
			<P class = "titles">Items Distribution</P>
			<table id="itemObtained">
				<tr>
					<td><p>Member Name</p></td>
					<td><p>Obtained Item</p></td>
				</tr>
				<?php
    $obtained = "SELECT * FROM Obtained LIMIT 8";
    $obt = $con->query($obtained);
    while ($row = $obt->fetch_assoc()) {
        ?>
				<tr>
					<td><P><?=$row["uname"]?></P></td>
					<td><p><?=$row["item"]?></p></td>
				</tr>
				
				<?php }?>

			</table>
			<p class="load">
				<a href="#">Load More..</a>
			</p>
		</div>

		<br />

<?php
$validate = 1;

if (isset($_POST["submit"])) {
    $comments = $_POST["comments"];
    $qc = "INSERT INTO Comments(comments_id, comments, uname, date) values (null, '$comments','$username',NOW() )";
    if (strlen($comments) == 0 || strlen($comments) > 1000) {
        $validate = 0;
    } else {
        $result = $con->query($qc);
        $validate = 1;
    }
    if ($validate == 1) {
        header("Location:mainpage.php");
    } else {
        $error = "Wrong Creation(blank or longer than 1000 characters)";
        $con->close();
    }
}
?>
		<div id="comments">
			<p>Comments</p>
			<form id="leaveComments" action="mainpage.php" method="post">
				<table>
					<tr>
						<td><label id="comments_msg" class="err_msg"><?php echo $error;?></label></td>
					</tr>
					<tr>
						<td><textarea class="comments" name="comments"></textarea></td>
					</tr>

				</table>

				<p class="div">
					<input type="submit" name="submit" value="Add Comments" />
				</p>
		
		</div>
		<?php

$comm = "SELECT * FROM Comments ORDER BY date DESC LIMIT 6";
$com = $con->query($comm);

while ($row = $com->fetch_assoc()) {
    if (isset($_POST["remove"])) {
        $remove = "DELETE FROM Comments WHERE comments_id = '$id'";
        $rmv = $con->query($remove);
        echo "$id";
    }
    ?>
		<table class="userComments">

			<tr>
				<td><p>User:<?=$row["uname"]?></p></td>
				<td><p>Date:<?=$row["date"]?></p></td>
			</tr>
			<tr>
				<td><p><?=$row["comments"]?></p></td>
				<td><input type="hidden" name=<?=$row["comments_id"]?>></td>
				<td><input type="submit" class="remove" name="remove" value="Remove" /></td>
			</tr>

		</table>
		<br />
	<?php

}
$con->close();
?>
</div>
	</section>
	<hr />
	</form>
	<footer> @copy right by gaoha202@uregina.ca </footer>

</body>
</html>