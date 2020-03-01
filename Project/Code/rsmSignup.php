
<?php
$validate = true;
$uname_v = "/^[a-zA-Z0-9_-]+$/";
$pswd_v = "/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/";

$email = $_POST["email"];
$name = $_POST["uname"];
$password = $_POST["pswd"];
$cPassword = $_POST["pswdr"];

$con = new mysqli("localhost", "gaoha202", "project", "gaoha202");
if (! $con) {
    echo "error connection";
}

$error0 = "Error Check will be display at here..";

if (isset($_POST["reset"])) {
    $error1 = "";
    $error2 = "";
    $error3 = "";
    $error4 = "";
}

if (isset($_POST["submit"])) {

    $query = "select * from User where email = $email";
    $check = $con->query($query);

    if ($email == "" || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validate = false;
        $error0 = "";
        $error1 = "Email is empty or invalid";
    } else {
        $error1 = "";
    }

    if (count($check)) {
        $validate = false;
        $error0 = "";
        $error1 = "Email has alredy exist";
    } else {
        $error1 = "";
    }

    if ($name == "" || $name == null || ! preg_match($uname_v, $name)) {

        $validate = false;
        $error0 = "";
        $error2 = "Username is empty or invalid";
    } else {
        $error2 = "";
    }

    if ($password == "" || $password == null || ! preg_match($pswd_v, $password)) {

        $validate = false;
        $error0 = "";
        $error3 = "Please enter the password correctly. (at least one number and one uppercase and lowercase letter, and at least 8 or more characters)";
    } else {
        $error3 = "";
    }

    if ($cPassword == null || $cPassword != $password) {
        $validate = false;
        $error0 = "";
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
<html dir="ltr" lang="en" xml:lang="en">
<head>
<title>Sign up to the site</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script id="firstthemesheet" type="text/css">/** Required in order to fix style inclusion problems in IE with YUI **/</script>
<link rel="stylesheet" type="text/css" href="bootstrap.css" />
<link rel="stylesheet" type="text/css" href="error.css" />

<!-- End Matomo Code -->
<meta name="robots" content="noindex" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body id="page-login-index"
	class="format-site  path-login chrome dir-ltr lang-en yui-skin-sam yui3-skin-sam urcourses-uregina-ca pagelayout-login course-1 context-1 notloggedin loginbackgroundimage"
	style="background-image: url(artResources/ffxiv.png);">

	<div id="page-wrapper" class="loginbackgroundimage">
		<div id="page" class="container-fluid mt-0">
			<div id="page-content" class="row">
				<div id="region-main-box" class="col-12">

					<section id="region-main" class="col-12">
						<span class="notifications" id="user-notifications"></span>
						<div role="main">
							<span id="maincontent"></span>
							<div class="my-1 my-sm-5"></div>
							<div class="row">
								<div class="col-sm-12 col-md-6 col-lg-4">
									<div class="card">
										<div class="card-block">
											<h2 class="card-header text-center">Raid Static Manager</h2>
											<div class="card-body">

												<h2>Sign-up</h2>

												<div class="mt-3">
													Before Login to the Manager, Please Sign up to get your account<br />
													<div class="modal moodle-has-zindex"
														id="moodle-cookiesenabled-modal-dialogue"
														data-region="modal-container" aria-hidden="true"
														role="dialog">
														<div class="modal-dialog " role="document"
															data-region="modal"
															aria-labelledby="5e44f51f9ec665e44f51f9d19a2-modal-title"
															tabindex="0">
															<div class="modal-content">
																<div class="modal-header " data-region="header">

																	<button type="button" class="close" data-action="hide"
																		data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body" data-region="body">
																	<div class="no-overflow"></div>
																</div>
																<div class="modal-footer" data-region="footer">
																	<button type="button" class="btn btn-secondary"
																		data-dismiss="modal">Close</button>

																</div>
															</div>
														</div>
													</div>
												</div>


												<div class="row justify-content-md-center">
													<div class="col-12">
														<form class="mt-3"
															action="http://www2.cs.uregina.ca/~gaoha202/project/rsmSignup.php"
															method="post" id="signup" enctype="multipart/form-data">
															<input id="anchor" type="hidden" name="anchor" value="">
															<input type="hidden" name="signuptoken"
																value="kCvd3KX2E9VfZSnqbdebr5dpfiUFV46G">
															<div class="form-group">
																<label for="Email" class="sr-only"> Email </label> <input
																	type="text" name="email" class="form-control" value=""
																	placeholder="Email">
															</div>
															<div class="form-group">
																<label for="username" class="sr-only"> Username </label>
																<input type="text" name="unmae" class="form-control"
																	value="" placeholder="Username">
															</div>
															<div class="form-group">
																<label for="password" class="sr-only">Password</label> <input
																	type="password" name="pswd" value=""
																	class="form-control" placeholder="Password">
															</div>
															<div class="form-group">
																<label for="ConfirmPassword" class="sr-only">ConfirmPassword</label>
																<input type="password" name="pswdr" value=""
																	class="form-control" placeholder="ConfirmPassword">
															</div>

															<button class="btn btn-primary btn-block mt-3"
																type="submit" name="submit">Sign up</button>
															<button type="submit" name="reset"
																class="btn btn-block mt-3" id="resetbtn">Reset</button>
														</form>
													</div>
													<a href="rsmLogin.php">Already have an account?</a>
													<div class="col-12">
														<div class="forgetpass mt-3">
															<div class="form-label">NOTE:</div>

															<table>
																<tr>
																	<td><?php echo "$error0"?></td>
																</tr>
																<tr>
																	<td class="err_msg"><?php echo "$error1";?></td>
																</tr>
																<tr>
																	<td class="err_msg"><?php echo "$error2";?></td>
																</tr>
																<tr>
																	<td class="err_msg"><?php echo "$error3";?></td>


																</tr>
																<tr>
																	<td class="err_msg"><?php echo "$error4";?></td>
																</tr>
															</table>
															<p>For further assistance, please contact
																gaoha202@uregina.ca</p>
														</div>

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div
									class="col-sm-12 col-md-4 offset-md-2 col-lg-3 offset-lg-5 align-self-end">

								</div>
							</div>

						</div>

					</section>
				</div>
			</div>
		</div>
		<footer id="page-footer" class="py-3 bg-dark text-light">
			<div class="container">
				<div id="course-footer"></div>
				<div class="row">
					<div>
						<p style="margin-left: 30rem;">&copy;gaoha202@uregina.ca</p>
					</div>
				</div>
			</div>
		</footer>
	</div>
</body>
</html>