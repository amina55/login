<?php
echo 1; exit;
session_start();
try{
    if ($_POST["captcha"] == $_SESSION["captcha_code"]) {
        $name = trim($_REQUEST['name']);
        $username = trim($_REQUEST['username']);
        $email = trim($_REQUEST['email']);
        $password = trim($_REQUEST['password']);
        $confirmPassword = trim($_REQUEST['confirm_password']);

        if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            print "<p class='error'>Required Parameter is missing</p>";
        } else {
            if($password != $confirmPassword) {
                print "<p class='error'>Please verify Password and Confirm Password.</p>";
            } else {
                include "database_access.php";
                if (!$connection) {
                    print "<p class='error'>Connection Failed.</p>";
                } else {
                    $password = hash('sha512', $password);
                    $insertQuery = "INSERT INTO users (name, username, email, password) VALUES  ('$name', '$username', '$email', '$password')";
                    $result = $connection->exec($insertQuery);
                    if (!$result) {
                        print "<p class='error'>Error in User Sign up</p>";
                    } else {
                        echo $result;
                    }
                }
            }
        }
    } else {
        print "<p class='error'>Enter Correct Captcha Code.</p>";
    }
}catch (Exception $e) {
    echo "<p class='error'>Error : " . $e->getMessage() . "</p>";
}
?>