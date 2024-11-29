


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Coordinators Page</title>
    <link rel="stylesheet" href="dashbstyle.css"> 
</head>
<style>
    /* Basic styles for the page layout */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    height: 100vh;
}
#sidebar {
    padding: 20px; /* Add inner spacing within the sidebar */}

#sidebar .brand {
    display: flex;
    align-items: center;
    gap: 10px; /* Space between the icon and text */
    margin-bottom: 20px; /* Space below the brand section */
    font-size: 1.2em; /* Slightly larger text for emphasis */
}

#sidebar .brand i {
    font-size: 1.5em; /* Increase icon size */
}
/* Main content area */
#main-content {
    flex-grow: 1;
    padding: 20px;
    background-color: #f4f4f4;
}

.email-container {
    max-width: 600px;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

input, textarea {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color:#3a506b;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #728197;
}

textarea {
    resize: vertical;
}
nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #f0f4f8; /* Adjust based on your design */
}

nav .profile {
    margin-left: auto; /* Push the logo/image to the right */
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

</style>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="coordinators.php" class="brand">
        <i class='bx bx-group'></i>
            <span class="text">Coordinators Page</span>
        </a>
        <ul class="side-menu top">
            
            <li><a href="coordinators.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="cgamesched.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li class="active"><a href="cmessage.php"><i class='bx bxs-message-dots'></i><span class="text">Message</span></a></li>
            <li><a href="cnewsfeed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="corganizers.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="cvenues.php"><i class='bx bxs-map-pin'></i><span class="text">Schools/Venue</span></a></li>
            <li><a href="csports_add.php"><i class='bx bxs-tennis-ball'></i><span class="text">Sports</span></a></li>
        </ul>

        <ul class="side-menu">
    <li>
        <a href="#" class="logout" onclick="return confirmLogout();">
            <i class='bx bxs-log-out-circle'></i>
            <span class="text">Logout</span>
        </a>
    </li>
</ul>

<script>
    function confirmLogout() {
        var result = confirm("Are you sure you want to log out?");
        if (result) {
            window.location.href = "login_form.php"; // Redirect to login form if confirmed
        }
        return false; // Prevent default action if canceled
    }
</script>
    </section>
    <!-- SIDEBAR -->
   <!-- CONTENT -->
   <section id="content">
    <nav>
            <i class='bx bx-menu' id="menu-icon"></i>
    <div>

    </div>
    <a href="#" class="profile">
            <img src="sanluis.jpg" alt="Profile Image">
            </a>
        </nav>
        <!-- NAVBAR -->


        <main>

        <section id="main-content">
        <div class="email-container">
            <h2>Compose Email</h2>
            <form action="send_email.php" method="POST">
                <div class="form-group">
                    <label for="to">To:</label>
                    <input type="email" id="to" name="to" required placeholder="Recipient's email address">
                </div>
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required placeholder="Subject of the email">
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="6" required placeholder="Write your message here"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" name="sendemail">Send Email</button>
                </div>
            </form>
        </div>
    </section>
    </main>
        <!-- MAIN CONTENT -->

    </section>
    <!-- CONTENT -->

    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>