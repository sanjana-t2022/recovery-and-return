<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $item_name = $_POST["title"];
    $description = $_POST["description"];
    $status = $_POST["item_type"]; // Lost or Found
    $date_reported = date("Y-m-d");

    // Image upload handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Create uploads directory if not exists
            $uploadFileDir = 'uploads/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Insert item into database
                $stmt = $conn->prepare("INSERT INTO items (user_id, title, description, item_type, report_date, image_path) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isssss", $user_id, $item_name, $description, $status, $date_reported, $dest_path);
                if ($stmt->execute()) {
                    $message = "Item reported successfully!";
                } else {
                    $message = "Database error: " . $conn->error;
                }
            } else {
                $message = "Error uploading image.";
            }
        } else {
            $message = "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
        }
    } else {
        $message = "Please upload an image.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Item</title>
    <style>
        body { background: #e6f2ff; font-family: Arial; }
        form { width: 500px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #3399ff; margin-top: 40px; }
        input, textarea, select { width: 100%; margin: 10px 0; padding: 8px; }
        input[type="submit"] { background: #3399ff; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background: #2673cc; }
        a { display: inline-block; margin-top: 15px; color: #3399ff; text-decoration: none; }
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
    <h2 style="text-align:center;">Report Lost or Found Item</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Item Name" required />
        <textarea name="description" placeholder="Description" rows="4" required></textarea>
        <select name="item_type" required>
            <option value="">Select Status</option>
            <option value="Lost">Lost</option>
            <option value="Found">Found</option>
        </select>
        <input type="file" name="image" accept="image/*" required />
        <input type="submit" value="Report Item" />
    </form>
    <p style="text-align:center; color:green;"><?php echo $message; ?></p>
    <p style="text-align:center;"><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
