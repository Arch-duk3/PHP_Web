<?php

session_start();
include('connection.php');


if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $email = $_POST['email'];
    $sanitized_username = mysqli_real_escape_string($conn, $username);
    $sanitized_password = mysqli_real_escape_string($conn, $password);
    $sanitized_email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM users WHERE username='" . $sanitized_username . "' OR  email='" . $sanitized_email . "'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $num = mysqli_fetch_array($result);

    if ($num > 0) {
        header("Location: error.php");
}
    elseif ($sanitized_username==False or $sanitized_password==False or $sanitized_email==False){
        header("Location: erroe3.php");
}

    else {
      $sql= "INSERT INTO users (username, password, email) VALUES('" . $sanitized_username . "','" . $sanitized_password . "','" . $sanitized_email . "')";
      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      header("Location: index.php");
      exit;
}

}
?>


<!DOCTYPE htm>
<html>
<body>

<form method="post" action="">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label><br>
    <input type="text" id="password" name="password"><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br><br>
    <input type="submit" value="Register">
</form>

<a href="index.php">Login</a>

</body>
</html>

