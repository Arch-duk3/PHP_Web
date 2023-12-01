<?php
session_start();
include('connection.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
}
$sql = "SELECT id, username, password FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Username</th></tr>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["id"]."</td><td>".$row["username"]."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $sanitized_username = mysqli_real_escape_string($conn, $username);
    $sql = "SELECT * FROM users WHERE username='" . $sanitized_username . "'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $num = mysqli_fetch_array($result);

    if ($username=='admin') {
        header("Location: error6.php");
}   
    elseif ($num > 0) { 
        $sql = "DELETE FROM users WHERE username='" . $sanitized_username . "'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        header("Location: admin.php");
}
    else {
        header("Location: error5.php");
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

</head>
<body>

<h1>Welcome, Administrator</h1>
<form method="post" action="">
           <label for="username">Username:</label><br>
           <input type="text" id="username" name="username"><br><br>
</form>

<a href="logout.php">Logout</a?

</body>
</html>

