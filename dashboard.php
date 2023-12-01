<?php
session_start();
include('connection.php');
$re_username = $_SESSION['username'];
$sql1 = "SELECT email FROM users WHERE username= '$re_username'";
    $result1 = $conn->query($sql1);

        if ($result1->num_rows > 0) {
            while($row = $result1->fetch_assoc()) {
                $mail= $row["email"];
            }
            
        } 

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newemail = $_POST['newemail'];
    $sanitized_newemail = mysqli_real_escape_string($conn, $newemail);
    
    $sql = "SELECT * FROM users WHERE username='$re_username'";
    $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
    $num = mysqli_fetch_array($result);

    if ($num > 0){
        $sql = "UPDATE users SET email='" . $sanitized_newemail . "' WHERE username= '$re_username'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        header("Location: dashboard.php");
    }
    else {
        header("Location: erroe4.php");
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>

<h1>Welcome, <?php echo $re_username; ?>!</h1>
<h2> Email: <?php echo $mail; ?></h2><br>

<form  method="post" action=" ">
    <label for="newemail">New Email:</label>
    <input type="email" id="newemail" name="newemail" required><br><br>
    <input type="submit" value="Change Email"><br><br>
</form>


<a href="logout.php">Logout</a>

</body>
</html>
