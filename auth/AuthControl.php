<?php

include('../db/connection.php');

session_start();

if (isset($_SESSION['_csrf_login']) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    if($_SESSION['_csrf_login'] != $_POST['_csrf']){
        header("location: login.php?error=1&errorCode=101");
    }
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    
    if(empty($email) || empty($password)){
        header("location: login.php?error=1&errorCode=102");
    }
    $hash_password = md5($password);
    $sql = "SELECT * FROM users WHERE user_email = ? AND user_password = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ss", $email, $hash_password);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $row = $result->fetch_assoc();
    if ($row > 0) {
        if ($row['status'] == 1) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_email'] = $row['user_email'];
            header("location: ../dashboard/index.php");
        }
        header("location: login.php?error=1&errorCode=103");
        die();
    }
    else{
        header("location: login.php");
    }
}

if (isset($_SESSION['_csrf_account']) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_account'])) {
    if($_SESSION['_csrf_account'] != $_POST['_csrf']){
        header("location: login.php?error=1&errorCode=101");
    }
    print_r($_POST);
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $email = test_input($_POST['email']);
    $c_password = test_input($_POST['c_password']);

    if(empty($email) || empty($password) || empty($c_password) || empty($username) ){
        header("location: login.php?error=1&errorCode=102");
    }
    
    if($c_password != $password){
        header("location: login.php?error=1&errorCode=104");
    }
    $hash_password = md5($password);
    $sql = "INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hash_password);
    $stmt->execute();
    header("location: index.php?success=1");

}


if (isset($_SESSION['_csrf_register']) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = test_input($_POST['name']);
    $sex = test_input($_POST['sex']);
    $id_no = test_input($_POST['id_no']);
    $program = test_input($_POST['program']);
    $accadamic = test_input($_POST['accadamic_year']);
    $year = test_input($_POST['year']);
    $email = test_input($_POST['email']);
    $phone = test_input($_POST['phone']);
    $dept = test_input($_POST['dept']);
    $timespamp = date("Y-m-d h:i:s");

    if (empty($name) || empty($sex) || empty($id_no) || empty($program) || empty($accadamic) || empty($year) || empty($email) || empty($phone) || empty($dept)) {
        header("location: register.php?error=1&errorCode=102");
        die();
    }
    $sql = "INSERT INTO students
        (student_name, student_sex, student_id_no, student_program, student_accadamic_year, student_year, student_email, student_phone, student_dept, created_on)
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssssiisiss", $name, $sex, $id_no, $program, $accadamic, $year, $email, $phone, $dept, $timespamp);
    $stmt->execute();

    echo '<table>
            <tr>
                <th colspan="2">Student Information</th>
            </tr>
            
            <tr>
                <td>Name:</td>
                <td>'.$name.'</td>
            </tr>
            <tr>
                <td>Sex:</td>
                <td>'.$sex.'</td>
            </tr>
            <tr>
                <td>ID No:</td>
                <td>'.$id_no.'</td>
            </tr>
            <tr>
                <td>Program:</td>
                <td>'.$program.'</td>
            </tr>
            <tr>
                <td>Accadamic Year:</td>
                <td>'.$accadamic.'</td>
            </tr>
            <tr>
                <td>Year:</td>
                <td>'.$year.'</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>'.$email.'</td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td>'.$phone.'</td>
            </tr>
            <tr>
                <td>Departiment:</td>
                <td>'.$dept.'</td>
            </tr>
            <tr>
                <td>Registration Date:</td>
                <td>'.$timespamp.'</td>
            </tr>
            <h1>Registration is Completed</h1>
        </table>';
}

?>