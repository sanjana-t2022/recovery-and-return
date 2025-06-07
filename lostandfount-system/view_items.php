<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">

    <title>View Items</title>
    <style>
        body { background: #e6f2ff; font-family: Arial; }
        .container { width: 90%; margin: auto; margin-top: 40px; }
        .item {
            background: white; padding: 15px; margin-bottom: 20px; border-radius: 10px;
            box-shadow: 0 0 10px #3399ff; display: flex; align-items: center;
        }
        .item img {
            max-width: 150px; max-height: 150px; margin-right: 20px; border-radius: 8px;
            object-fit: cover;
        }
        .details {
            flex-grow: 1;
        }
        h2, p {
            margin: 5px 0;
        }
        a {
            display: inline-block; margin-top: 15px; color: #3399ff; text-decoration: none;
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

    <div class="container">
        <h1>Lost and Found Items</h1>

        <?php
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

if ($filter === 'Lost' || $filter === 'Found') {
    // Prepare a statement to filter by item_type
    $stmt = $conn->prepare("SELECT items.*, users.name, users.branch, users.user_type, users.phone, users.email 
        FROM items 
        JOIN users ON items.user_id = users.id
        WHERE items.item_type = ?
        ORDER BY items.report_date DESC");
    $stmt->bind_param("s", $filter);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // No filter or invalid filter, show all items
    $sql = "SELECT items.*, users.name, users.branch, users.user_type, users.phone, users.email 
        FROM items 
        JOIN users ON items.user_id = users.id
        ORDER BY items.report_date DESC";
    $result = $conn->query($sql);
}
echo '<div style="margin-bottom: 15px;">
    <a href="view_items.php"' . ($filter == '' ? ' style="font-weight:bold;"' : '') . '>All Items</a> |
    <a href="view_items.php?filter=Lost"' . ($filter == 'Lost' ? ' style="font-weight:bold;"' : '') . '>Lost Items</a> |
    <a href="view_items.php?filter=Found"' . ($filter == 'Found' ? ' style="font-weight:bold;"' : '') . '>Found Items</a>
</div>';


        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="item">';
                echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="Item Image">';
                echo '<div class="details">';
                echo '<h2>' . htmlspecialchars($row['title']) . ' (' . htmlspecialchars($row['item_type']) . ')</h2>';
                echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
                echo '<p><strong>Reported By:</strong> ' . htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['user_type']) . ')</p>';
                echo '<p><strong>Branch:</strong> ' . htmlspecialchars($row['branch']) . '</p>';
                echo '<p><strong>Date Reported:</strong> ' . htmlspecialchars($row['report_date']) . '</p>';
                echo '<p><strong>Phone:</strong> ' . htmlspecialchars($row['phone']) . '</p>';
                echo '<p><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>';
                echo '</div></div>';
            }
        } else {
            echo "<p>No items reported yet.</p>";
        }

        $conn->close();
        ?>

        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
