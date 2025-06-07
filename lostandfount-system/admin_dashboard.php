<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch current user info
$current_email = $conn->real_escape_string($_SESSION["email"]);
$user_result = $conn->query("SELECT * FROM users WHERE email = '$current_email'");
$current_user = $user_result->fetch_assoc();

// Check if current user is admin
// Check if current user is admin by email
if ($current_user["email"] !== "sanjunaya4087@gmail.com") {
    echo "Access Denied. Only admin can access this page.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">

    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; background: #f2f9ff; padding: 20px; }
        h1 { color: #004080; }
        table {
            width: 100%; border-collapse: collapse; margin-bottom: 40px;
        }
        th, td {
            border: 1px solid #ccc; padding: 8px; text-align: left;
        }
        th {
            background-color: #b3d9ff;
        }
        h2 { color: #0066cc; margin-top: 40px; }
        .logout {
            float: right; text-decoration: none; color: #004080;
            font-weight: bold; margin-bottom: 20px;
        }
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


<a href="logout.php" class="logout">Logout</a>
<h1>Admin Dashboard</h1>

<h2>All Users</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Branch</th>
        <th>User Type</th>
        <th>Signup Date</th>
    </tr>
    <?php
    $users = $conn->query("SELECT * FROM users ORDER BY id DESC");
    while($user = $users->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['name']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td>" . htmlspecialchars($user['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($user['branch']) . "</td>";
        echo "<td>" . htmlspecialchars($user['user_type']) . "</td>";
        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<h2>All Reported Items</h2>
<table>
    <tr>
        <th>Item Name</th>
        <th>Description</th>
        <th>Status</th>
        <th>Image</th>
        <th>Reported By</th>
        <th>Date</th>
    </tr>
    <?php
    $items = $conn->query("SELECT items.*, users.name FROM items JOIN users ON items.user_id = users.id ORDER BY report_date DESC");
    while($item = $items->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($item['title']) . "</td>";
        echo "<td>" . htmlspecialchars($item['description']) . "</td>";
        echo "<td>" . htmlspecialchars($item['item_type']) . "</td>";
        echo "<td><img src='" . htmlspecialchars($item['image_path']) . "' width='80'></td>";
        echo "<td>" . htmlspecialchars($item['name']) . "</td>";
        echo "<td>" . htmlspecialchars($item['report_date']) . "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
