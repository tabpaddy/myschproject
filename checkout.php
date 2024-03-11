<?php
session_start();

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: index.php"); // Redirect to the main page if the cart is empty
    exit();
}

// Dummy shipping cost
$shipping_cost = 5;

// Calculate the total cost of items in the cart
$total_cost = 0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_cost += $item['price'] * $item['quantity'];
    }
}

// Calculate the total cost including shipping
$total_with_shipping = $total_cost + $shipping_cost;

// Handle the checkout logic (e.g., updating the database, processing payment, etc.)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkout"])) {
    // Add your checkout logic here

    // For demonstration purposes, clear the cart after checkout
    unset($_SESSION['cart']);

    header("Location: thankyou.php"); // Redirect to a thank you page after successful checkout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Add your CSS styles or link to an external stylesheet here -->
</head>
<body>
    <h2>Checkout</h2>

    <div>
        <h3>Order Summary</h3>
        <?php foreach ($_SESSION['cart'] as $pid => $item): ?>
            <div>
                <!-- Make sure to provide the correct path or URL for the image source -->
                <img src="admin/property/<?php echo htmlspecialchars($item['image']); ?>" alt="pimage">
                <p><?php echo htmlspecialchars($item['name']); ?></p>
                <p>Price: $<?php echo htmlspecialchars($item['price']); ?></p>
                <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
            </div>
        <?php endforeach; ?>

        <div>
            <p>Subtotal: $<?php echo htmlspecialchars($total_cost); ?></p>
            <p>Shipping Cost: $<?php echo htmlspecialchars($shipping_cost); ?></p>
            <p>Total: $<?php echo htmlspecialchars($total_with_shipping); ?></p>
        </div>
    </div>

    <form method="post">
        <button type="submit" name="checkout">Proceed to Checkout</button>
    </form>
</body>
</html>
