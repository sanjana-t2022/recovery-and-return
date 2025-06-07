<?php
session_start();
include 'db.php';


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_type"] = $row["user_type"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["name"] = $row["name"];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid credentials!";
        }
    } else {
        $message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">

    <title>Login</title>
    <style>
        body { background-color: #e6f2ff; font-family: Arial; }
        form { width: 350px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #66b3ff; }
        input { width: 100%; padding: 8px; margin: 10px 0; }
        input[type="submit"] { background-color: #3399ff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
<p>Already have an account? <a href="login.php">Login</a></p>

    <h2 style="text-align:center;">Recovery and Return Platform</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="submit" value="Login" />
    </form>
    <p style="text-align:center;"><?php echo $message; ?></p>
</body>
</html>
