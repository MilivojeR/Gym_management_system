<?php
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT admin_id, password FROM admins WHERE  username =  ?";

    $run = $conn->prepare($sql);
    $run->bind_param("s", $username);

    $results = $run->get_result();
    $conn->close();

    if($results->num_rows == 1) {
        $admin = $results->fetch_assoc();

         if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $conn->close();
             header("Location: admin_dashboard.php");
    } else {
        $_SESSION['error'] = "Low power levels detected. Access denied.";
        $conn->close();
        header("Location: index.php");
        exit();
    }
     
    }else {
        $_SESSION['error'] = "Invalid username or password.";
            $conn->close();
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
 <body>
    <?php
    if(isset($_SESSION['error'])) {
        echo $_SESSION['error'] . "<br>";
        unset($_SESSION['error']);
    }
    ?>
<form action="" method="POST">
     Username: <input type="text" name="username"><br>
     Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>

</body>
</html>