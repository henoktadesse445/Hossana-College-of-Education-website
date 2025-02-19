<?php
session_start();

if(isset($_GET['logout']) || !isset($_SESSION['user_id'])){
    session_reset();
    session_unset();
    header("location: ../index.php");
    exit;
}

include ("../db/connection.php");

$stmt = $connect->prepare("SELECT * FROM news ORDER BY posted_date DESC");
$stmt->execute();
$result = $stmt->get_result();

// CSRF token for form protection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_csrf']) && $_SESSION['_csrf'] == $_POST['_csrf']) {
    $type = test_input($_POST['type']);
    $title = test_input($_POST['title']);
    $desc = test_input($_POST['desc']);
    $timestamp = date("Y-m-d h:i:s");

    // Handle File Upload
    if (!empty($_FILES['poster']['name'])) {
        $tmp_file_name = $_FILES['poster']['tmp_name'];
        $file_name = $_FILES['poster']['name'];
        move_uploaded_file($tmp_file_name, "../upload/" . $file_name);
    } else {
        $file_name = isset($_POST['existing_image']) ? $_POST['existing_image'] : null;
    }

    // CREATE new news post
    if (isset($_POST['create'])) {
        $sql = "INSERT INTO news (news_title, news_desc, news_cover, type, posted_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sssss", $title, $desc, $file_name, $type, $timestamp);
        $stmt->execute();
        echo "<script>alert('News posted successfully');</script>";
        header("location: ?reload=true");
        exit;
    }

  // EDIT existing news post
if (isset($_POST['edit']) && isset($_POST['news_id'])) {
    $news_id = $_POST['news_id'];
    $file_name = $_POST['existing_image'];  // Use existing image if no new one is uploaded
    
    // Check if a new image is uploaded
    if (!empty($_FILES['poster']['name'])) {
        $tmp_file_name = $_FILES['poster']['tmp_name'];
        $file_name = $_FILES['poster']['name'];
        move_uploaded_file($tmp_file_name, "../upload/" . $file_name); // Save the new image
    }

    $sql = "UPDATE news SET news_title=?, news_desc=?, news_cover=?, type=? WHERE id=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssssi", $title, $desc, $file_name, $type, $news_id);
    $stmt->execute();

    echo "<script>alert('News updated successfully');</script>";
    header("location: ?reload=true");
    exit;
}

// DELETE news post
if (isset($_POST['delete']) && isset($_POST['news_id'])) {
    $news_id = $_POST['news_id'];  // Get the news ID to delete

    // Validate CSRF token for security
    if ($_POST['_csrf'] !== $_SESSION['_csrf']) {
        echo "<script>alert('Invalid CSRF token');</script>";
        exit;
    }

    // Prepare the SQL query to delete the news
    $sql = "DELETE FROM news WHERE id=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $news_id);  // Bind the news ID to the query

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['message'] = "News deleted successfully!";
        $_SESSION['msg_type'] = "success";
        header("location: ?reload=true");  // Redirect to refresh the page
        exit();
    } else {
        $_SESSION['message'] = "Error deleting news!";
        $_SESSION['msg_type'] = "error";
        header("location: ?reload=true");  // Redirect to refresh the page
        exit();
    }
}

}

// Initiate CSRF token for the session if not set
if (!isset($_SESSION['_csrf'])) {
    $_SESSION['_csrf'] = md5(uniqid("_csrf"));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../styles.css">
</head>

<body style="background: #ccc;">
    
    <nav>
        <div class="logo">
            <img src="../images/logo.png" alt="HCE">
        </div>
        <ul class="nav-links">
            <li><a href="../index.php#home">Home</a></li>
            <li><a href="#news">Create News and Event</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="?logout=true">Logout</a></li>
        </ul>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
    <?php if(isset($_SESSION['message'])): ?>
    <div class="alert <?php echo $_SESSION['msg_type']; ?>">
        <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']); // Clear after displaying
        ?>
    </div>
<?php endif; ?>
    <div class="news">
        <h1>News and Events</h1>
        <div class="news-container">
        <?php
while ($row = $result->fetch_assoc()) { ?>
    <div class="mynews">
        <img src="../upload/<?php echo $row['news_cover']; ?>" alt="<?php echo $row['news_title']; ?>">
        <div class="n">
            <?php echo $row['news_title']; ?>
            <p><?php echo $row['posted_date']; ?></p>
            <a href="../read.php?news_id=<?php echo $row['id']; ?>" class="cta-button">Read More</a>
            <form action="" method="POST" style="display:inline;">
            <input type="hidden" name="_csrf" value="<?php echo $_SESSION['_csrf']; ?>">
            <input type="hidden" name="news_id" value="<?php echo $row['id']; ?>">
            <button class="delete" type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this news?');">Delete</button>
            </form>
            <button class="edit" onclick="populateEditForm('<?php echo $row['id']; ?>', '<?php echo addslashes($row['news_title']); ?>', '<?php echo addslashes($row['news_desc']); ?>', '<?php echo $row['news_cover']; ?>', '<?php echo $row['type']; ?>')">Edit</button>
            </div>
            </div>
        <?php } ?>

            </div>
            </div>
            <div id="news" class="create-news">
                <h1>Create news and Event</h1>
            <div class="create-container">
                <div class="create-news-container">
                    <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_csrf" value="<?php echo $_SESSION['_csrf']; ?>">
            <input type="hidden" name="news_id" id="news_id">
            
            <select name="type" id="type">
                <option value="">Select Type</option>
                <option value="news">News</option>
                <option value="event">Event</option>
            </select>
            
            <input type="file" name="poster" id="poster" accept="image/*">
            <input type="hidden" name="existing_image" id="existing_image">
            
            <input type="text" name="title" id="title" placeholder="Title...">
            <textarea name="desc" id="desc" cols="70" rows="10" placeholder="Description..."></textarea>
            
            <input type="submit" name="create" value="Post">
            <input type="submit" name="edit" value="Update">
        </form>
    </div>
    </div>
    </div>
    <script>
    function populateEditForm(id, title, desc, image, type) {
    document.getElementById("news_id").value = id;
    document.getElementById("title").value = title;
    document.getElementById("desc").value = desc;
    document.getElementById("existing_image").value = image;
    document.getElementById("type").value = type;

    // Ensure the form reflects the existing image
    document.getElementById("poster").value = ""; // Clear the file input to prevent override

    // Scroll to the edit form automatically
    document.getElementById("news").scrollIntoView({ behavior: "smooth" });
}

                // Mobile menu toggle
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('open');
            hamburger.classList.toggle('toggle');
        });
    </script>
</body>
</html>