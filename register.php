<?php
    // get the information from the register form 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        
    }
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
						<h1><a href="index.html">BuggyVault</a></h1>
						<nav class="links">
							<ul>
								<li><a href="#">Home</a></li>
                                <li><a href="#">Create a Discussion</a></li>
								<li><a href="#">Discussions</a></li>
								<li><a href="#">Profile</a></li>
                                <?php if ($isloggedin): ?>
                                    <li><a href="#">Log Out</a></li>
                                <?php else: ?>
                                    <li><a href="#">Sign Up</a></li>
                                    <li><a href="#">Log in</a></li>
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
                                        <li><a href="#" class="button fit">Log Out</a></li>
                                    <?php else: ?>
                                        <li><a href="#" class="button fit">Sign Up</a></li>
									    <li><a href="#" class="button large fit">Log In</a></li>
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
										<h2>Register</h2>
									</div>
								</header>
                                <!-- Registration Form -->
                    <div class="registration-form">
                        <form method="post" action="register.php">
                            <div class="field half first">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" required>
                            </div>
                            <div class="field half">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" required>
                            </div>
                            <div class="field half first">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" required>
                            </div>
                            <br>
                            <button>Sign Up</button>
							</article>
					</div>

				<!-- Sidebar -->
					<section id="sidebar">

						<!-- Intro -->
							<section id="intro">
								<a href="#" class="logo"><img src="images/logo.jpg" alt="" /></a>
								<header>
									<h2>Future Imperfect</h2>
									<p>Another fine responsive site template by <a href="http://html5up.net">HTML5 UP</a></p>
								</header>
							</section>

						<!-- About -->
							<section class="blurb">
								<h2>About</h2>
								<p>Mauris neque quam, fermentum ut nisl vitae, convallis maximus nisl. Sed mattis nunc id lorem euismod amet placerat. Vivamus porttitor magna enim, ac accumsan tortor cursus at phasellus sed ultricies.</p>
								<ul class="actions">
									<li><a href="#" class="button">Learn More</a></li>
								</ul>
							</section>

						<!-- Footer -->
							<section id="footer">
								<ul class="icons">
									<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="icon solid fa-rss"><span class="label">RSS</span></a></li>
									<li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
								</ul>
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