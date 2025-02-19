<?php
include 'db/connection.php';
if(isset($_GET['news_id']) && $_SERVER['REQUEST_METHOD'] == "GET"){
    $id = $_GET['news_id'];
    $stmt = $connect->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();

    $stmt_other = $connect->prepare("SELECT * FROM news ORDER BY posted_date DESC");
    $stmt_other->execute();
    
    $result_other = $stmt_other->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News & Events</title>
    <link rel="stylesheet" href="read.css">
</head>

<body>

    <header class="headers">
        <h1>College News & Events</h1>
    </header>
    
    <main>
        <section class="news-container">
            <!-- Left Side: News Titles with Images -->
            <div class="news-list">
                <ul>
        <?php
        while($row = $result_other->fetch_assoc()) {
            if($row['id'] == $id) continue;
        echo'<a href="read.php?news_id='.$row['id'].'">
                <li >
                    <img src="upload/'.$row['news_cover'].'" alt="'.$row['news_title'].'">
                    <span> '.$row['news_title'].'</span>
                </li>
                </a>';
        }
        echo '</ul></div>';
        while($row = $result->fetch_assoc()) {
            echo '
            <!-- Right Side: News Details with Image -->
            <div class="news-detail">
                <div id="news-detail-0" class="news-content">
                    <img src="upload/'.$row['news_cover'].'" alt="'.$row['news_title'].'">
                    <span>'.$row['news_title'].'</span>
                    <p>'.$row['news_desc'].'</p>
                    <p>'.$row['posted_date'].'</p>
                </div>
            </div>';
        }
            ?>
        </section>
    </main>
      <!-- Footer Section -->
    <footer>
        <div class="quick-links">
            <ul class="nav-link">
                <h5>Web Based Systems</h5>
                <li><a href="auth/register.php">Register</a></li>
                <li><a href="#news">SIMS</a></li>
                <li><a href="auth/login.php">Login</a></li>
                <li><a href="#about">About</a></li>
            </ul>
            <ul class="nav-link">
                <h5>Quick Links</h5>
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#news">News</a></li>
                <li><a href="index.php#contact">contact</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="#home">Information Desk</a></li>
            </ul>

            <ul class="nav-link">
                <h5>Acadamics</h5>
                <li><a href="#home">Calender</a></li>
                <li><a href="#news">Announcements</a></li>
                <li><a href="index.php#programs">Programs</a></li>
                <li><a href="#about">Departements:</a></li>
            </ul>

            <ul class="nav-link">
                <h5 id="contact">Contact US</h5>
                <li><a href="#home">Email</a></li>
                <li><a href="#news">Tel: +2519XXXXXXXXX</a></li>
                <li><a href="#contact">P.O.Box</a></li>
                <li><a href="#about">Fax:</a></li>
            </ul>
            <ul class="nav-link">
                <h5>Follow Us</h5>
            <a href="">
            <img class="social" src="images/linkedin.webp" alt=""></a>
            <a href="">
            <img class="social" src="images/telegram.png" alt=""></a>
            <a href="https://www.facebook.com/hosscte.hosscte">
            <img class="social" src="images/facebook.png" alt=""></a>
            </ul>
        </div>
        <address>Location: Hossana Near Adilla Hotel </address>
        <p>&copy; <strong id="presentDay"></strong> Teachers Training College. All Rights Reserved.</p>
    </footer>
    
    <script>
        function showNewsDetail(index) {
            const allDetails = document.querySelectorAll('.news-content');
            const allTitles = document.querySelectorAll('.news-list li');

            allDetails.forEach((detail, i) => {
                detail.classList.toggle('hidden', i !== index);
            });

            allTitles.forEach((title, i) => {
                title.classList.toggle('active', i === index);
            });
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
<?php
}else{
    header("location: index.php");   
}