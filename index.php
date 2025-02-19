<?php
session_start();

include 'db/connection.php';
$stmt = $connect->prepare("SELECT * FROM news ORDER BY posted_date DESC");
$stmt->execute();

$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hossana College of Education</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <img src="images/logo.png" alt="HCE">
        </div>
        <input type="text" maxlength="30" class="search" placeholder="Search...">

        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#news">News & Events</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="auth/register.php">Register</a></li>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <li><a href="dashboard/">Account</a></li>
             <?php }else{ ?>
                <li><a href="auth/login.php">Login</a></li>
             <?php } ?>
            <li class="dropdown-container">
                <a href="#programs" class="menu">Programs</a>
                <ul class="dropdown-menu">
                    <li><a href="#login1">Degree</a></li>
                    <li><a href="#login2">Diploma</a></li>
                    <li><a href="#login3">Certificate</a></li>
                </ul>
            </li>
        </ul>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Slideshow Section -->
    <div id="home" class="slideshow-container">
        <div class="mySlides">
            <img src="images/graduationst.png" alt="Slide 1">
            <div class="caption">Our Graduates</div>
            <div class="captions">Welcome To Hossana College of Education</div>
        </div>
        <div class="mySlides">
            <img src="images/greenlegacy2.png" alt="Slide 2">
            <div class="caption">Attractive Environment</div>
            <div class="captions">Welcome To Hossana College of Education</div>
        </div>
        <div class="mySlides">
            <img src="images/library.png" alt="Slide 3">
            <div class="caption">Experienced Faculty</div>
            <div class="captions">Welcome To Hossana College of Education</div>
        </div>
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
    </div>

    <div id="about" class="about">
    <div class="aboutp">
        <h2>Hossana College of Education (HCE)</h2><br>
        <p>Maiores vitae accusamus in dolorem non amet at quos!
            Lorem ipsum, dolor sit amet consectetur adipisicing elit
            Quisquam assumenda cupiditate voluptatibus id sequi 
            exercitationem commodi, vel voluptates repudiandae autem 
            unde culpa repellendus in, enim temporibus fuga libero. 
            Reprehenderit distinctio illo natus similique facilis odit 
            optio deleniti enim molestias dolorum nihil voluptas, 
            vero provident ipsam voluptates quasi numquam. Nostrum doloremque quasi 
            quod impedit quam dignissimos autem minus aperiam totam nemo.
        </p>
       </div>
    </div>
    
    <!-- college ection -->
        <section class="campus">
        <h1> Our College</h1>

            <div class="row">
                <div class="campus-col">
                    <img src="images/greenlegacy.jpg" alt="">
                    <div class="layer">
                        <h3>Environment</h3>
                    </div>
                </div>

                <div class="campus-col">
                    <img src="images/greenlegacy1.jpg" alt="">
                    <div class="layer">
                        <h3>Community</h3>
                    </div>
                </div>

                <div class="campus-col">
                    <img src="images/computerlab.jpg" alt="">
                    <div class="layer">
                        <h3>Education</h3>
                    </div>
                </div>
            </div>
    </section>

     <!-- Programs-->
    <div id="programs" class="w3p">
        <h1 class="program">Programs</h1>
        <div class="w3-container">
            <div class="w3-q">
                <span class="w3-x">12+</span>
                <br>Degree Programs
            </div>
            <div class="w3-q">
                <span class="w3-x">7+</span>
                <br>Diploma Programs
            </div>
            <div class="w3-q">
                <span class="w3-x">14+</span>
                <br>Certificate Programs
            </div>
            <div class="w3-q">
                <span class="w3-x">1500+</span>
                <br>Students
            </div>
        </div>
    </div>

        <!--Course of Collage-->

    <section class="course" id="course_call">
        <h1>Our Popular Courses</h1>
        <p>We are offer to three best course for student</p>

        <div class="row">
            <div class="course-col">
                <h2>BA-English</h2>
                <p>The BA course is a full time four years (Eight semesters) Bachelor’s Degree in Engilish.The degree helps interested students in setting up a sound academic base for an advanced career in English.</p>
            </div>

            <div class="course-col">
                <h2>BSC-ICT </h2>
                <p>BSc (Bachelor of Science) in ICT is basically about storing, processing, securing, and managing information. This degree is primarily focused on subjects such as software, databases, and networking. </p>
            </div>

            <div class="course-col">
                <h2>BSC-Mathemathics</h2>
                <p>The Bachelor of Science is an undergraduate degree course in Mathemathics for a duration of 4 years. The field relates to design, development and use of computer applications. </p>
            </div>
        </div>

    </section>

 <!--News-->
    <div id="news" class="news">
        <h1 class="news-event">News and Events</h1>
        <div class="news-container">
        <?php
        while($row = $result->fetch_assoc()) {
            echo '<div class="mynews">
                    <img src="upload/'.$row['news_cover'].'" alt="'.$row['news_title'].'">
                    <div class="n">
                        '.$row['news_title'].'
                        <p>'.$row['posted_date'].'</p>
                        <a href="read.php?news_id='.$row['id'].'" class="cta-button">Read More</a>
                    </div>
                </div>';
        }
            ?>
        </div>
    </div>

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
                <li><a href="#">Home</a></li>
                <li><a href="#news">News</a></li>
                <li><a href="#contact">contact</a></li>
                <li><a href="#about">About</a></li>
            </ul>

            <ul class="nav-link">
                <h5>Acadamics</h5>
                <li><a href="#home">Calender</a></li>
                <li><a href="#contact">Programs</a></li>
                <li><a href="#news">Announcements</a></li>
                <li><a href="#home">Information Desk</a></li>
            </ul>

            <ul class="nav-link">
                <h5 id="contact">Contact US</h5>
                <li><a href="#home">Email</a></li>
                <li><a href="#contact">P.O.Box</a></li>
                <li><a href="#about">Fax:</a></li>
                <li><a href="#news">Tel: +2519XXXXXXXXX</a></li>
            </ul>
            <ul class="nav-link">
                <h5>Follow Us</h5>
            <a href="">
            <img class="social" src="images/x.png" alt=""></a>
            <a href="t.me/HossanaEducationCollege" alt="Telegram">
            <img class="social" src="images/telegram.png" alt="Telegram"></a>
            <a href="https://www.facebook.com/hosscte.hosscte">
            <img class="social" src="images/fbs.png" alt=""></a>
            </ul>
        </div>
        <address>Location: Hossana Near Adilla Hotel </address>
        <p>&copy; <strong id="presentDay"></strong> Teachers Training College. All Rights Reserved.</p>
    </footer>

    <script>
        var date = new Date();
        document.getElementById("presentDay").innerText = date.getFullYear();
        let slideIndex = 0;

        function showSlides() {
            let slides = document.querySelectorAll(".mySlides");
            slides.forEach((slide, index) => {
                slide.style.display = index === slideIndex ? "block" : "none";
            });
            slideIndex = (slideIndex + 1) % slides.length;
        }

        setInterval(showSlides, 3000); // Auto slide every 3 seconds
        showSlides();

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