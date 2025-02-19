<?php
// start session here to control hijackers action
session_start();
// Initiate globall csrf token for evry inputs
$_csrf = "_csrf".md5(uniqid("_csrf"));

$_SESSION['_csrf_register'] = $_csrf;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <img src="../images/logo.png" alt="HCE">
        </div>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../index.php#news">News and Events</a></li>
            <li><a href="../index.php#contact">Contact</a></li>
            <li><a href="../index.php#about">About</a></li>
        </ul>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <div class="register-container"> 
    <div class="container">
        <h1>Register Here</h1>
        <form id="registrationForm" action="AuthControl.php" method="post">
            <input type="hidden" name="_csrf" value="<?php echo $_csrf; ?>">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required autocomplete="off">

            <label for="name">Sex:</label>
            <select name="sex" >
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            
            <label for="name">Program:</label>
            <select name="program" >
                <option value="degree">Degree</option>
                <option value="diploma">Diploma</option>
                <option value="certificate">Certificate</option>
            </select>
            
            <label for="name">Departiment:</label>
            <select name="dept" >
                <option value="Information Technology">Information Technology</option>
                <option value="Software Engineering">Software Engineering</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Information System">Information System</option>
            </select>

            <label for="name">ID No:</label>
            <input type="text" name="id_no">

            <label for="name">Academic Year:</label>
            <input type="number" name="accadamic_year" min="2007" max="2100" step="1" required>
            
            <label for="name">Year:</label>
            <input type="text" name="year">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required autocomplete="off">

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" required autocomplete="off">
            
            <input type="submit" name="register" value="Register" />
        </form>
    </div>
    </div>
    
    <script>
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
