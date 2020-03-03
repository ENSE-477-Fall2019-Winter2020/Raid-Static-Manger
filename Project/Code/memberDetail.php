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

$members = "SELECT * FROM Members WHERE uid = '$user_id' ";
$mname = $con->query($members);

?>

<!DOCTYPE html>
<html dir="ltr" lang="en" xml:lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="style.css">
<title>Members Detail</title>
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
	<main>
	<table style="margin-bottom: 10px">
		<tbody>
			<tr>
				<td width="25%"><img style="height: 600px"
					src="artResources/character1.jpg" alt="" class="img" /></td>
				<td width="50%">
					<div class="history-box">
						<div class="title cl">
							<h3>Member Items List</h3>
						</div>
						<div class="history-table">
							<div class="table-body2 progress_scroll" style="height: 520px">
								<div style="border-collapse: collapse;" width="100%" border="0"
									cellpadding="0" cellspacing="0">

									<?php
        while ($row = $mname->fetch_assoc()) {
            ?>
									<div class="history-box padl">
										<span class="padr">
											<?=$row["uname"]?>
										</span> <span class="padr">Job : <?=$row["job"]?></span> <span>BP:<?=$row["BP"]?></span>
									</div>
									<div class="history-box padl">Item Obtained:</div>
									<div class="table-body3 progress_scroll">
										<table style="border-collapse: collapse;" width="100%"
											border="0" cellpadding="0" cellspacing="0">
											<tbody>
											
												
											<?php
            $item = "SELECT * FROM Obtained WHERE uname = '{$row["uname"]}' AND uid = '$user_id'";
            $items = $con->query($item);
            while ($item_list = $items->fetch_assoc()) {
                ?>
												<tr>
													<td width="35%">
														<?=$item_list["item"]?>
													</td>
												
													<?php

                $count = "SELECT item,count(*) as count from Obtained WHERE item = '{$item_list["item"]}' AND uname = '{$row["uname"]}' AND uid = '$user_id' group by item";
                $counts = $con->query($count);
                while ($number = $counts->fetch_assoc()) {
                    ?>		
                   
													<td>
														*<?=$number["count"]?>
													</td>
													
												</tr>

												
												<?php }?>
												
												
			<?php }?>
											</tbody>
										</table>
									</div>
								<?php }?>
		
								</div>



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