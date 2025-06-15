<?php
	session_start();
	include("config/db.php");
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
                                <li><a href="create_discussion.php">Create a Discussion</a></li>
								<li><a href="your_discussions.php">Your Discussions</a></li>
								<li><a href="#">Profile</a></li>
                                <?php if ($isloggedin): ?>
                                    <li><a href="logout.php">Log Out</a></li>
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
										<input type="text" name="query" placeholder="Search"/>
										<?php
											if (isset($_GET['query'])) {
												$query = htmlspecialchars($_GET['query']);
											}
											else {
												$query = null;
											}
										?>
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
										<a href="create_discussion.php">
											<h3>Create Discussion</h3>
											<p>Ask a question, share your opinion, etc.</p>
										</a>
									</li>
									<li>
										<a href="your_discussions.php">
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
                                        <li><a href="logout.php" class="button fit">Log Out</a></li>
                                    <?php else: ?>
                                        <li><a href="register.php" class="button fit">Sign Up</a></li>
									    <li><a href="login.php" class="button large fit">Log In</a></li>
                                    <?php endif; ?>
								</ul>
							</section>

					</section>

				<!-- Main -->
					<div id="main">
						<?php
							if (isset($_GET['query']) && !empty($_GET['query'])) {
								$sql = "SELECT * FROM discussions WHERE title LIKE '%{$query}%' ORDER BY created_at DESC LIMIT 3";
							} else {
								$sql = "SELECT * FROM discussions ORDER BY created_at DESC LIMIT 3";
							}
							
							$result = mysqli_query($conn, $sql);
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) {
									echo '<article class="post">';
									echo '<header>';
									echo '<div class="title">';
									echo '<h2><a href="single.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a></h2>';
									echo '</div>';
									echo '<div class="meta">';
									echo '<time class="published" datetime="' . $row['created_at'] . '">' . date('F j, Y', strtotime($row['created_at'])) . '</time>';
									$name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM users WHERE id = " . $row['user_id']));
									echo '<span class="name">Author: ' . $name['username'] . '</span>';
									echo '</div>';
									echo '</header>';
									echo '<a href="single.php?id=' . $row['id'] . '" class="image featured"><img src="' . $row['image_path'] . '" alt=""/></a>';
									echo '<p>' . htmlspecialchars($row['content']) . '</p>';
									echo '<footer>';
									echo '<ul class="actions">';
									echo '<li><a href="single.php?id=' . $row['id'] . '" class="button large">Continue Reading</a></li>';
									echo '</ul>';
									echo '<ul class="stats">';
									echo '<li> Number of Comments: ' . $row['post_count'] . '</li>';
									echo '</ul>';
									echo '</footer>';
									echo '</article>';
								}
							} else {
								echo '<p>No discussions found.</p>';
							}
						?>

						<!-- Pagination -->
							<ul class="actions pagination">
								<li><a href="" class="disabled button large previous">Previous Page</a></li>
								<li><a href="#" class="button large next">Next Page</a></li>
							</ul>

					</div>

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

						<!-- Mini Posts -->
							<section>
								<div class="mini-posts">
									<?php
										$sql = "SELECT * FROM discussions ORDER BY post_count DESC LIMIT 4";
										$result = mysqli_query($conn, $sql);
										if (mysqli_num_rows($result) > 0) {
											while ($row = mysqli_fetch_assoc($result)) {
												echo '<article class="mini-post">';
												echo '<header>';
												echo '<h3><a href="single.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a></h3>';
												echo '<time class="published" datetime="' . $row['created_at'] . '">' . date('F j, Y', strtotime($row['created_at'])) . '</time>';
												$name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM users WHERE id = " . $row['user_id']));
												echo 'Author: ' . $name['username'];
												echo '</header>';
												echo '<a href="single.php?id=' . $row['id'] . '" class="image"><img src="' . $row['image_path'] . '" alt="" /></a>';
												echo '</article>';
											}
										} else {
											echo '<p>No popular discussions found.</p>';
										}
									?>
								</div>
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