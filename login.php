<?php
    include("config/db.php");
    session_start();
    $isloggedin = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="en">
	<head>
		<title>BuggyVault</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="icon" type="image/x-icon" href="/BuggyVault/static/favicon.ico">
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<h1><a href="index.php">BuggyVault</a></h1>
						<nav class="links">
							<ul>
								<li><a href="index.php">Home</a></li>
                                <li><a href="#">Create a Discussion</a></li>
								<li><a href="#">Discussions</a></li>
								<li><a href="#">Profile</a></li>
                                <?php if ($isloggedin): ?>
                                    <li><a href="index.php">Log Out</a></li>
                                    <?php
										session_unset();
										session_destroy();
									?>
                                <?php else: ?>
                                    <li><a href="register.php">Sign Up</a></li>
                                    <li><a href="login.php">Log in</a></li>
                                <?php endif ?>
							</ul>
						</nav>
						<nav class="main">
							<ul>
								<li class="search">
									<a class="fa-search" href="#search">Search</a>
									<form id="search" method="get" action="#">
										<input type="text" name="query" placeholder="Search" />
									</form>
								</li>
								<li class="menu">
									<a class="fa-bars" href="#menu">Menu</a>
								</li>
							</ul>
						</nav>
					</header>

				<!-- Menu -->
					<section id="menu">

						<!-- Search -->
							<section>
								<form class="search" method="get" action="#">
									<input type="text" name="query" placeholder="Search" />
								</form>
							</section>

						<!-- Links -->
							<section>
								<ul class="links">
									<li>
										<a href="#">
											<h3>Create Discussion</h3>
											<p>Ask a question, share your opinion, etc.</p>
										</a>
									</li>
									<li>
										<a href="#">
											<h3>Display Discussions</h3>
											<p>See the discussions you created or commented</p>
										</a>
									</li>
									<li>
										<a href="#">
											<h3>Profile</h3>
											<p>See your profile page</p>
										</a>
									</li>
								</ul>
							</section>

						<!-- Actions -->
							<section>
								<ul class="actions stacked">
									<?php if ($isloggedin): ?>
                                        <li><a href="index.php" class="button fit">Log Out</a></li>
                                        <?php
                                            session_unset();
                                            session_destroy();
                                        ?>
                                    <?php else: ?>
                                        <li><a href="register.php" class="button fit">Sign Up</a></li>
									    <li><a href="login.php" class="button large fit">Log In</a></li>
                                    <?php endif; ?>
								</ul>
							</section>

					</section>

				<!-- Main -->
					<div id="main">

						<!-- Post -->
							<article class="post">
								<header>
									<div class="title">
										<h2>Log in</h2>
									</div>
								</header>
                                <!-- Registration Form -->
                    <div class="login-form">
                        <form method="post" action="login.php">
                            <div class="field half first">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" required>
                            </div>
                            <div class="field half first">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" required>
                            </div>
                            <br>
                            <button type="submit">Log in</button>
							</article>
					</div>
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $username = $_POST['username'];
                            $password = $_POST['password'];

                            try {
                                $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
                                if ($user = mysqli_fetch_assoc($result)) {
                                    if (password_verify($password, $user['password'])) {
                                        $_SESSION['username'] = $user['username'];
                                        $_SESSION['user_id'] = $user['id'];
                                        $_SESSION['role'] = $user['role'];
                                        echo "<script>window.location.href='index.php';</script>";
                                    }
                                    else {
                                        echo "<script>alert(" . json_encode("Invalid password") . ");</script>";
                                    }
                                }
                                else {
                                    echo "<script>alert(" . json_encode("Invalid username") . ");</script>";
                                } 
                            }
                            catch(Exception $e) {
								echo "<script>alert(" . json_encode("Error: " . $e->getMessage()) . ");</script>";
                            }
                        }
                    ?>
				<!-- Sidebar -->
					<section id="sidebar">

						<!-- Intro -->
							<section id="intro">
								<a href="#" class="logo"><img src="images/logo.jpg" alt="" /></a>
								<header>
									<h2>Buggy Vault</h2>
									<p>Post your questions and share your opinions</p>
								</header>
							</section>

						<!-- About -->
							<section class="blurb">
								<h2>About</h2>
								<p>BuggyVault Forum is a deliberately vulnerable PHP-based discussion platform built for educational and ethical hacking purposes. Designed to mimic a real-world forum, it allows users to register, start discussions, and post replies in various threads. The platform includes common web vulnerabilities such as SQL injection, XSS, and broken access control — enabling security researchers, students, and penetration testers to practice identifying and exploiting security flaws in a safe, local environment. Built with PHP and MySQL, BuggyVault Forum also serves as a hands-on resource for understanding secure coding practices by exploring their insecure counterparts.</p>
							</section>

						<!-- Footer -->
							<section id="footer">
								<p class="copyright">&copy; Untitled. Design: <a href="http://html5up.net">HTML5 UP</a>. Images: <a href="http://unsplash.com">Unsplash</a>.</p>
							</section>

					</section>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>