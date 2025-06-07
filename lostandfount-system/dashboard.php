<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
$name = $_SESSION["name"];
$user_type = $_SESSION["user_type"];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">

    <title>Dashboard</title>
    <style>
        body { background: #e6f2ff; font-family: Arial; }
        .container { width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 15px #3399ff; margin-top: 50px; }
        a { display: inline-block; margin: 10px; padding: 10px 20px; background: #3399ff; color: white; text-decoration: none; border-radius: 5px; }
        a:hover { background: #2673cc; }
    </style>
</head>
<body>
    <nav>
  <a href="dashboard.php">Dashboard</a>
  <a href="report_item.php">Report Item</a>
  <a href="view_items.php">View Items</a>
  <?php
  if (isset($_SESSION['email']) && $_SESSION['email'] === 'sanjunaya4087@gmail.com') {
    echo '<a href="admin_dashboard.php">Admin Dashboard</a>';
}

  ?>
  <a href="logout.php" style="float: right;">Logout</a>
</nav>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        <p>User Type: <?php echo htmlspecialchars($user_type); ?></p>

        <a href="report_item.php">Report Lost/Found Item</a>
        <a href="view_items.php">View Items</a>

        <?php if ($user_type === 'Admin') : ?>
            <a href="admin_dashboard.php">Admin Dashboard</a>
        <?php endif; ?>

        <a href="logout.php" style="background: #cc3333;">Logout</a>
    </div>
</body>
</html>
