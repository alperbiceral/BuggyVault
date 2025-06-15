<?php
	session_start();
	include("config/db.php");
    $isloggedin = isset($_SESSION['user_id']);
	$disc_id = $_GET['id'];
?>
<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>BuggyVault</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="icon" type="image/x-icon" href="/BuggyVault/static/favicon.ico">
	</head>
	<body class="single is-preload">

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
							$sql = "SELECT * FROM discussions WHERE id = $disc_id";
							$sql2 = "SELECT * FROM posts WHERE discussion_id = $disc_id ORDER BY created_at ASC";
							
							$disc_result = mysqli_query($conn, $sql);
							$post_result = mysqli_query($conn, $sql2);
							if (mysqli_num_rows($disc_result) > 0) {
								while ($row = mysqli_fetch_assoc($disc_result)) {
									echo '<article>';
									echo '<header>';
									echo '<div class="title">';
									echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
									echo '</div>';
									echo '<div class="meta">';
									echo '<time class="published" datetime="' . $row['created_at'] . '">' . date('F j, Y', strtotime($row['created_at'])) . '</time>';
									$name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM users WHERE id = " . $row['user_id']));
									echo '<br><span class="name">Author: ' . $name['username'] . '</span>';
									echo '</div>';
									echo '</header>';
									echo '<img src="' . $row['image_path'] . '" alt=""/>';
									echo '<p>' . htmlspecialchars($row['content']) . '</p>';
									echo 'Number of Comments: ' . $row['post_count'];
									echo '<footer>';
									if (mysqli_num_rows($post_result) > 0) {
										while ($row2 = mysqli_fetch_assoc($post_result)) {
											echo '<hr>';
											echo '<article>';
											echo '<header>';
											echo '<div class="meta">';
											echo '<time class="published" datetime="' . $row2['created_at'] . '">' . date('F j, Y', strtotime($row2['created_at'])) . '</time>';
											$name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM users WHERE id = " . $row2['user_id']));
											echo '<br><span class="name">Author: ' . $name['username'] . '</span>';
											echo '</div>';
											echo '</header>';
											echo '<img src="' . $row2['image_path'] . '" alt=""/>';
											echo '<p>' . htmlspecialchars($row2['content']) . '</p>';
											echo '<footer>';
											if ($isloggedin && $_SESSION['user_id'] == $row2['user_id']) {
												echo '<form method="post" action="delete_post.php?id=' . $row2['id'] . '">';
												echo '<button class="button large" type="submit">Delete</button>';
												echo '</form>';
											}
											}
										}
									}
									echo '<form method="post" action="single.php?id=' . $disc_id . '" enctype="multipart/form-data">';
										echo '<div class="field half first">';
										echo '<label for="comment">Post a Comment</label>';
										echo '<input type="text" name="comment" id="comment" placeholder="Write your comment here..." required>';
										echo '<label for="comment">Upload an Image</label>';
										echo '<input type="file" name="image" id="image">';
										echo '</div>';
										echo '<button class="button large">Post Comment</button>';
									echo '</form>';
									if ($_SERVER["REQUEST_METHOD"] == "POST") {
										$content = htmlspecialchars($_POST['comment']);
										$user_id = $_SESSION['user_id'];

										if (empty($_FILES['image']['name'])) {
											$image_path = null; // No image uploaded
										} else {
											// Handle file upload
											$target_dir = "images/";
											$target_file = $target_dir . basename($_FILES["image"]["name"]);
											if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
												$image_path = $target_file; // File uploaded successfully
											} else {
												$image_path = null; // Failed to upload file
												echo "<script>alert('Error uploading image');window.location.href='single.php?id=$disc_id';</script>";
												exit();
											}
										}

										$sql3 = "INSERT INTO posts (discussion_id, user_id, content, image_path) VALUES ('$disc_id', '$user_id', '$content', '$image_path')";
										if (mysqli_query($conn, $sql3)) {
											echo "<script>window.location.href='single.php?id=$disc_id';</script>";
											$sql4 = "UPDATE discussions SET post_count = post_count + 1 WHERE id = $disc_id";
		   									mysqli_query($conn, $sql4);
										} else {
											echo "<script>alert('Error posting comment: " . mysqli_error($conn) . "');window.location.href='single.php?id=$disc_id';</script>";
										}
									}
									echo '</footer>';
		 							echo '</article>';
							} else {
								echo '<p>No discussions found.</p>';
							}
						?>

				<!-- Footer -->
					<section id="footer">
						<p class="copyright">&copy; Untitled. Design: <a href="http://html5up.net">HTML5 UP</a>. Images: <a href="http://unsplash.com">Unsplash</a>.</p>
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