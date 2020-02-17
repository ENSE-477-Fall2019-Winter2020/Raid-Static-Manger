
<?php
$validate = true;
$uname_v = "/^[a-zA-Z0-9_-]+$/";
$pswd_v = "/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/";

$email = $_POST["email"];
$name = $_POST["uname"];
$password = $_POST["pswd"];
$cPassword = $_POST["pswdr"];

$con = new mysqli("localhost", "username", "password", "username");
if (! $con) {
    echo "error connection";
}

if (isset($_POST["reset"])) {
    header("Location:rsmSignup.php");
}

if (isset($_POST["submit"])) {

    $query = "select * from User where email = $email";
    $check = $con->query($query);

    if (count($check)) {
        $validate = false;
        $error1 = "Email has alredy exist";
    } else {
        $error1 = "";
    }

    if ($email == "" || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validate = false;
        $error1 = "Email is empty or invalid";
    } else {
        $error1 = "";
    }

    if ($name == "" || $name == null || ! preg_match($uname_v, $name)) {

        $validate = false;
        $error2 = "Username is empty or invalid";
    } else {
        $error2 = "";
    }

    if ($password == "" || $password == null || ! preg_match($pswd_v, $password)) {

        $validate = false;
        $error3 = "Please enter the password correctly. (at least one number and one uppercase and lowercase letter, and at least 8 or more characters)";
    } else {
        $error3 = "";
    }

    if ($cPassword == null || $cPassword != $password) {
        $validate = false;
        $error4 = "Comfirm password is wrong or empty";
    } else {
        $error4 = "";
    }

    if ($validate == true) {
        $qu = "INSERT INTO User(uid, email, uname, pwd, date) VALUES (null,'$email','$name','$password', NOW())";
        $result = $con->query($qu);
        header("Location:rsmLogin.php");
    } else {
        $con->close();
    }
}

?>

<!DOCTYPE>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="rsmSignup.css" type="text/css" />
</head>
<header>
	<h1>Raid Static Manager</h1>

</header>

<section>
	<P>Please Sign up to get your account</P>
	<form id="rsmSignup" action="rsmSignup.php" method="post"
		enctype="multipart/form-data">
		<table>

			<tr>
				<td></td>
				<td><p class="err_msg"><?php echo $error1;?></p></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input class="right_msg" type="text" name="email" size="30" /></td>
			</tr>

			<tr>
				<td></td>
				<td><p class="err_msg"><?php echo $error2;?></p></td>
			</tr>
			<tr>
				<td>Username:</td>
				<td><input class="right_msg" type="text" name="uname" size="30" /></td>
			</tr>

			<tr>
				<td></td>
				<td><p class="err_msg"><?php echo $error3;?></p></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input class="right_msg" type="password" name="pswd" size="30" /></td>
			</tr>

			<tr>
				<td></td>
				<td><p class="err_msg"><?php echo $error4;?></p></td>
			</tr>
			<tr>
				<td>Confirm Password:</td>
				<td><input class="right_msg" type="password" name="pswdr" size="30" /></td>
			</tr>

		</table>
		<br />
		<p class="div">
			<input type="submit" name="submit" value="Sign Up" /> 
			<input type="submit" name="reset" value="Reset" />
		
		
		<p>
	
	</form>
	<p>NOTE:
	
	
	<P>
	
	
	<ul>
		<li>Email can not be empty</li>
		<li>User name can not be empty</li>
		<li>Password can not be empty, and must contained at least one number
			and one uppercase and lowercase letter, and at least 8 or more
			characters</li>
		<li>Confirmed password must be the same with password</li>
	</ul>
</section>

<footer>
	<p>
		<a href="rsmLogin.php">Already have an account?</a>
	</p>
</footer>
</body>
</html>


