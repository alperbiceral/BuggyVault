# BuggyVault
BuggyVault is a penetration testing web application. It seems like a forum website and you can interact with the application as a forum application. There are some simple vulnerabilities like SQL Injection, XSS, and IDOR.

You can find the explanation of the vulnerabilities inside the [vulnerability_notes.md](/vulnerability.md)
## Build Instructions
* install XAMPP Web Server
* clone the repository inside the xampp/htdocs folder
* reach out the application from localhost/buggyvault
## File Hierarchy
BuggyVault/<br>
├── config/<br>
│   └── db.php             # Database connection<br>
├── images/                # User-uploaded images<br>
├── assets/                # CSS/JS files<br>
├── static/                # application's images<br>
├── index.php              # Home page<br>
├── login.php              # Login page<br>
├── logout.php             # Logout feature<br>
├── register.php           # Register page<br>
├── create_discussion.php  # Form to create a new discussion<br>
├── delete_discussion.php  # Delete a Discussion<br>
├── delete_post.php        # Delete a Post<br>
├── edit_discussion.php    # Edit an existing discussion<br>
├── your_discussions.php   # View user’s own discussions<br>
├── single.php             # Single discussion view<br>
├── init.sql               # Database tables<br>
├── vulnerability_notes.md # Application's vulnerabilities<br>
├── .gitignore<br>
└── README.md
## Frontend
html5up.net | @ajlkn
