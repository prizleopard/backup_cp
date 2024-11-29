<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Bracketing System</title>
    <link rel="stylesheet" href="Dashb_styles.css">
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
    background-color: #007BFF;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

textarea {
    resize: vertical;
}

</style>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-face-mask'></i>
            <span class="text">Organizer Page</span>
        </a>
        <ul class="side-menu top">
            <?php 
                $sidebarItems = [
                    ["link" => "Dashb.php", "icon" => "bxs-dashboard", "text" => "Dashboard"],
                    ["link" => "trylastna.php", "icon" => "bxs-folder-open", "text" => "Organizers"],
                    ["link" => "insert_result.php", "icon" => "bxs-doughnut-chart", "text" => "Results"],
                    ["link" => "schools.php", "icon" => "bxs-school", "text" => "Schools"],
                    ["link" => "scheduling.php", "icon" => "bxs-time", "text" => "Game Schedules"],
                    ["link" => "sports.php", "icon" => "bx-abacus", "text" => "Bracketing", "active" => true],
                    ["link" => "venues.php", "icon" => "bxs-map", "text" => "Venues"],
                    ["link" => "Dashb_news_feed.php", "icon" => "bx-spreadsheet", "text" => "News Feed"],
                    ["link" => "#", "icon" => "bxs-message-dots", "text" => "Message"],
                ];

                // Sort the sidebar items alphabetically by text
                usort($sidebarItems, function($a, $b) {
                    return strcmp($a['text'], $b['text']);
                });

                // Display the sorted sidebar items
                foreach ($sidebarItems as $item) {
                    echo '<li' . (isset($item['active']) ? ' class="active"' : '') . '>
                            <a href="' . $item['link'] . '">
                                <i class="bx ' . $item['icon'] . '"></i>
                                <span class="text">' . $item['text'] . '</span>
                            </a>
                          </li>';
                }
            ?>
        </ul>
    </section>

    <!-- MAIN CONTENT -->
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
                    <button type="submit">Send Email</button>
                </div>
            </form>
        </div>
    </section>

</body>
</html>
