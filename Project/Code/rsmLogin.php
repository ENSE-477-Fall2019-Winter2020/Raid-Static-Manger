
<?php
if (isset($_POST["Login"])) {

    // security 
    $email = trim($_POST["email"]);
    $password = trim($_POST["pswd"]);
    if (strlen($email) > 0 && strlen($password) > 0) {

        //connection check
        $con = new mysqli("localhost", "gaoha202", "project", "gaoha202");
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $ql = "SELECT uid, uname FROM User WHERE email = '$email' AND pwd = '$password'";
        $result = $con->query($ql);

        //combation check
        if ($row = $result->fetch_assoc()) {

            session_start();
            $_SESSION["uid"] = $row["uid"];
            $_SESSION["uname"] = $row["uname"];
            $error = ("Login successful");
            header("Location: mainpage.php?uid={$_SESSION["uid"]}");
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
<title>Log in to the site</title>
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
	style="background-image: url(http://www2.cs.uregina.ca/~gaoha202/project/artResources/ffxiv.png)">

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
												<div class="mt-3">

												<h2>Login</h2>
												
													<table class="form-label">
														<tr>
															<td>Hey, welcome to FFXIV Raid Static Manager website,
																before entering the manage site please login your
																account</td>
														</tr>
													</table>
													<br />
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
														<form id="Login_form" action="rsmLogin.php" method="post"
															enctype="multipart/form-data">
															<input type="hidden" name="submitted" value="1" /> <input
																id="anchor" type="hidden" name="anchor" value=""> <input
																type="hidden" name="logintoken"
																value="kCvd3KX2E9VfZSnqbdebr5dpfiUFV46G">
															<div class="form-group">
																<p class ="err_msg" ><?php echo "$error";?></p>
																<label for="username" class="sr-only"> Email </label> <input
																	type="text" name="email" id="email"
																	class="form-control" value="" placeholder="Email">
															</div>
															<div class="form-group">
																<label for="password" class="sr-only">Password</label> <input
																	type="password" name="pswd" id="password" value=""
																	class="form-control" placeholder="Password">
															</div>

															<p class="div">
																<input type="submit"
																	class="btn btn-primary btn-block mt-3" id="loginbtn"
																	name="Login" value="Login" method="post" />
															</p>
														</form>


													</div>
													<a href="rsmSignup.php">Don`t have an account?</a>
													<div class="col-12">
														<div class="forgetpass mt-3">
															<div class="form-label">Forget your password?</div>
															<ul>
																<li>Use your account email address, send email to :
																	gaoha202@uregina.ca to get your password.</li>
															</ul>
															<p>For further assistance: please contact
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