
<?php

if (isset($_POST["Login"]))  {
    
    $email = trim($_POST["email"]);
    $password = trim($_POST["pswd"]);
    if (strlen($email) > 0 && strlen($password) > 0) {
        
        $con = new mysqli("localhost", "gaoha202", "project", "gaoha202");
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $ql = "SELECT uid, uname FROM User WHERE email = '$email' AND pwd = '$password'"; 
        $result = $con->query($ql);

        if ($row = $result->fetch_assoc()) {
         
            session_start();
            $_SESSION["uid"] = $row["uid"];
            $_SESSION["uname"] = $row["uname"];
            $error = ("Login successful");
            header("Location: mainpage.php");
        } else {
         
            $error = ("The username/password combination was incorrect.");
            $con->close();
        }
    } else {
        $error = ("You must enter a non-blank username/password combination to login.");
    }
} else {
    $error = "";
}
?>

<!DOCTYPE>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="rsmLogin.css" type="text/css" />
</head>
<body>
	<header>
		<h1>
			Raid Static Manager
		</h1>
		<p>Please Login</p>
</header>
		<section>
		<p class="error"><?=$error?></p>
		<form id="Login_form" action="rsmLogin.php" method="post"
			enctype="multipart/form-data">
			<input type="hidden" name="submitted" value="1" />

			<table class=div>
				<tr>
					<td></td>
					<td><label id="uname_msg" class="err_msg"></label></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="text" name="email" size="30" /></td>
				</tr>

				<tr>
					<td></td>
					<td><label id="pswd_msg" class="err_msg"></label></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="pswd" size="30" /></td>
				</tr>

			</table>
			<br />

			<p class="div">
				<input type="submit" name="Login" value="Login" method="post" />
			</p>
			<p class="div">
				<input type="reset" name="Reset" value="Reset" method="post" />
			</p>
		</form>
		
		</section>
		</body>
<footer>
<a href = "rsmSignup.php">Sign Up</a>
<a href = "mainpage.php">Main Page</a>
</footer>		
		
		</html>

