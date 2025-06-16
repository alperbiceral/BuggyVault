# BuggyVault
BuggyVault is a penetration testing web application. It seems like a forum website and you can interact with the application as a forum application. There are some simple vulnerabilities like SQL Injection, XSS, and IDOR.
## Build Instructions
* install XAMPP Web Server
* clone the repository inside the xampp/htdocs folder
* reach out the application from localhost/buggyvault
## File Hierarchy
BuggyVault/
├── config/
│   └── db.php             # Database connection
├── images/                # User-uploaded images
├── assets/                # CSS/JS files
├── static/                # application's images
├── index.php              # Home page
├── login.php              # Login page
├── logout.php             # Logout feature
├── register.php           # Register page
├── create_discussion.php  # Form to create a new discussion
├── delete_discussion.php  # Delete a Discussion
├── delete_post.php        # Delete a Post
├── edit_discussion.php    # Edit an existing discussion
├── your_discussions.php   # View user’s own discussions
├── single.php             # Single discussion view
├── init.sql               # Database tables
├── .gitignore
└── README.md
## Frontend
html5up.net | @ajlkn