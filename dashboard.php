<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$con = new mysqli("localhost", "root", "", "medsave");

// Check if the database connection was successful
if ($con->connect_error) {
    die("Failed to connect: " . $con->connect_error);
}

// Get the logged-in user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch product details from the database for the logged-in user
$stmt = $con->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if products are found
if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}

// Handle the delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare SQL to delete the product
    $delete_stmt = $con->prepare("DELETE FROM products WHERE id = ? AND user_id = ?");
    $delete_stmt->bind_param("ii", $delete_id, $user_id);
    if ($delete_stmt->execute()) {
        echo "<p class='success-message'>Product deleted successfully.</p>";
    } else {
        echo "<p class='error-message'>Error deleting product. Please try again.</p>";
    }
    $delete_stmt->close();
}

// Close the prepared statement and the database connection
$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MedSave</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo $_SESSION['first_name']; ?>!</h1>

        <h2>Your Products</h2>
        <?php if (empty($products)) : ?>
            <p>No products found. Add some products to get started.</p>
        <?php else : ?>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Usage Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="100"></td>
                            <td><?php echo $product['price'] ? '$' . number_format($product['price'], 2) : 'N/A'; ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php
                                // Fetch category name (optional, if you have a categories table)
                                $con = new mysqli("localhost", "root", "", "medsave");
                                $cat_stmt = $con->prepare("SELECT name FROM categories WHERE cat_id = ?");
                                $cat_stmt->bind_param("i", $product['cat_id']);
                                $cat_stmt->execute();
                                $cat_result = $cat_stmt->get_result();
                                $category = $cat_result->fetch_assoc();
                                echo htmlspecialchars($category['name']);
                                $cat_stmt->close();
                                $con->close();
                            ?></td>
                            <td><?php echo htmlspecialchars($product['usage_duration']); ?></td>
                            <td>
                                <a href="?delete_id=<?php echo $product['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

/* Container for Dashboard */
.dashboard-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 30px;
    background-color: #ffffff;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

/* Header Section */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f1f1f1;
    padding-bottom: 20px;
    margin-bottom: 30px;
}

.header h1 {
    color: #2c3e50;
}

nav a {
    text-decoration: none;
    color: #3498db;
    margin-left: 20px;
    font-weight: bold;
}

nav a:hover {
    color: #2980b9;
}

/* Product Section */
.product-section h2 {
    margin-bottom: 20px;
    color: #2c3e50;
    font-size: 1.5em;
}

/* Table Styling */
.product-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

.product-table th, .product-table td {
    padding: 15px;
    text-align: left;
    border: 1px solid #ddd;
}

.product-table th {
    background-color: #f2f2f2;
    color: #2c3e50;
}

.product-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.product-table tr:hover {
    background-color: #f1f1f1;
}

/* Delete Button Styling */
.delete-btn {
    background-color: #e74c3c;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.delete-btn:hover {
    background-color: #c0392b;
}

.delete-btn:active {
    background-color: #e74c3c;
}

/* Success and Error Messages */
.success-message {
    background-color: #2ecc71;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    text-align: center;
}

.error-message {
    background-color: #e74c3c;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    text-align: center;
}


    </style>
</body>

</html>
