<?php
include 'db.php';


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $branch = $_POST["branch"];
    $user_type = $_POST["user_type"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, phone, branch, user_type, password)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $phone, $branch, $user_type, $password);

    if ($stmt->execute()) {
        $message = "Signup successful! You can now <a href='login.php'>login</a>.";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">

    <title>Signup</title>
    <style>
        body { background-color: #f0f8ff; font-family: Arial; }
        form { width: 400px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #99ccff; }
        input, select { width: 100%; padding: 8px; margin: 10px 0; }
        input[type="submit"] { background-color: #3399ff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
<p>Already have an account? <a href="login.php">Login</a></p>

    <h2 style="text-align:center;">User Signup</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="text" name="phone" placeholder="Phone Number" required />
        <input type="text" name="branch" placeholder="Branch" required />
        <select name="user_type" required>
            <option value="">Select User Type</option>
            <option>Student</option>
            <option>Teaching Staff</option>
            <option>Non-Teaching Staff</option>
        </select>
        <input type="password" name="password" placeholder="Password" required />
        <input type="submit" value="Sign Up" />
    </form>
    <p style="text-align:center;"><?php echo $message; ?></p>
</body>
</html>
