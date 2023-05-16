<?php
include '../db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['login_time'] = time();
            $_SESSION['session_timeout'] = 10 * 60;
            header('Location: ../index.php');
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
}


session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['login_time'])) {
    if ($_SESSION['login_time'] + $_SESSION['session_timeout'] < time()) {
        
        session_unset();
        session_destroy();
        header('Location: ../login.php');
        exit();
    } else {
        
        $_SESSION['login_time'] = time();
    }
}
?>