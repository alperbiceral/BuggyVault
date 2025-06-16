<?php
    session_start();
    include("config/db.php");
    $isloggedin = isset($_SESSION['user_id']);
    if (!$isloggedin) {
        echo "<script>alert('You have to log in first to create a discussion" . $isloggedin . "');window.location.href='login.php';</script>";
        exit();
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
						<h1><a href="index.php">BuggyVault</a></h1>
						<nav class="links">
							<ul>
								<li><a href="index.php">Home</a></li>
                                <li><a href="create_discussion.php">Create a Discussion</a></li>
								<li><a href="your_discussions.php">Your Discussions</a></li>
                                <?php if ($isloggedin): ?>
                                    <li><a href="logout.php">Log Out</a></li>
                                <?php else: ?>
                                    <li><a href="register.php">Sign Up</a></li>
                                    <li><a href="login.php">Log in</a></li>
                                <?php endif ?>
							</ul>
						</nav>
					</header>

				<!-- Menu -->
					<section id="menu">

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

						<!-- Post -->
							<article class="post">
								<header>
									<div class="title">
										<h2>Create a Discussion</h2>
									</div>
								</header>
                                <!-- Create Discussion Form -->
                    <div class="create-discussion-form">
                        <form method="post" action="create_discussion.php" enctype="multipart/form-data">
                            <div class="field half first">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" required>
                            </div>
                            <br>
                            <div class="field half first">
                                <label for="image">Image (optional)</label>
                                <input type="file" name="image" id="image">
                            </div>
                            <br>
                            <div class="field half first">
                                <label for="content">Content</label>
                                <input type="text" name="content" id="content" required>
                            </div>
                            <br>
                            <button type="submit">Create</button>
									</form>
							</article>
					</div>
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            
                            $title = $_POST['title'];
                            
                            if  (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                                $image = $_FILES['image']['name'];
                                $target_dir = "images/";
                                $target_file = $target_dir . basename($image);

                                if (!is_dir($target_dir)) {
                                    mkdir($target_dir, 0777, true);
                                }

                                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                                    $target_file = ""; // Handle the case where file upload fails
									die("Failed to move uploaded file.");
                                }

                            } else {
                                $target_file = ""; // Handle the case where no image is uploaded
                            }
                            
                            $content = $_POST['content'];
                            $user_id = $_SESSION['user_id'];

                            try {
                                mysqli_query($conn, "INSERT INTO discussions (title, content, image_path, user_id) VALUES ('$title', '$content', '$target_file', '$user_id')");
                                echo "<script>window.location.href='index.php';</script>";
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
								<a href="#" class="logo"><img src="static/favicon.ico" alt="" /></a>
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