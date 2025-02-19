<?php
// start session here to control hijackers action
session_start();
// Initiate globall csrf token for evry inputs
$_csrf = "_csrf".md5(uniqid("_csrf"));

$_SESSION['_csrf_account'] = $_csrf;
if(isset($_SESSION['user_id'])){
    header("location: ../dashboard/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
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
        </ul>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    
    <div class="create-container">
    <div class="container">
        <h1>Create Account</h1>
        <form action="AuthControl.php" method="post">
            <div class="red">
                <?php
                if (isset($_GET['error']) && isset($_GET['errorCode'])) {
                    if ($_GET['errorCode'] == "101") {
                        echo "<p class='error'>Unkown request</p>";
                    }
                    if ($_GET['errorCode'] == "102") {
                        echo "<p class='error'>Empty field found</p>";
                    }
                    if ($_GET['errorCode'] == "103") {
                        echo "<p class='error'>Your are not allowed to login</p>";
                    }
                    if ($_GET['errorCode'] == "103") {
                        echo "<p class='error'>The two password are not the same</p>";
                    }
                }
                if (isset($_GET['success'])) {
                        echo "<p class='success'>Registration complete wait for the approval of the admin</p>";
                    }
                ?>
            </div>
            <input type="hidden" name="_csrf" value="<?php echo $_csrf; ?>">
            
            <label for="username">Username:</label>
            <input type="username" name="username" required autocomplete="off">

            <label for="email">Email:</label>
            <input type="email" name="email" required autocomplete="off">

            <label for="password">Password:</label>
            <input type="password" name="password" required autocomplete="off">

            <label for="c_password">Confirm Password:</label>
            <input type="c_password" name="c_password" required autocomplete="off">

            <input type="submit" name="create_account" value="Create Account">

            <p>Already have account? Login <a href="login.php">here</a></p>
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
