<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sanitized_username = mysqli_real_escape_string($conn, $username);
    $sanitized_password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users WHERE username = '" . $sanitized_username . "' AND password = '" . $sanitized_password . "'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $num = mysqli_fetch_array($result);

    if ($sanitized_username==False  or $sanitized_password==False){
        header("Location: error2.php");
    }

    if ($sanitized_username== 'admin' && $sanitized_password== '21232f297a57a5a743894a0e4a801fc3'){
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $sanitized_username;
        header("Location: admin.php");
        exit;
    }
    if ($num > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $sanitized_username;
        global $re_username;
        $re_username= $sanitized_username;
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<form method="post" action="">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Login">
</form>

<a href="register.php">Register/Sign-Up</a>

</body>
</html>
