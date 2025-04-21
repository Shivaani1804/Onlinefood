<?php
session_start();
ob_start();

$servername = "my-mysql";
$username = "root";
$password = "root";
$dbname = "ofd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $cart = json_decode($_POST['cart'] ?? '', true);
        $total = floatval($_POST['total'] ?? 0);
        $delivery_location = $_POST['delivery_location'] ?? '';
        $user_id = intval($_POST['user_id'] ?? $_SESSION['user_id'] ?? 0);
        $payment_method = $_POST['payment_method'] ?? '';

        if (empty($cart) || !is_array($cart)) {
            throw new Exception('Invalid or empty cart');
        }
        if ($total <= 0) {
            throw new Exception('Invalid total amount');
        }
        if (empty($delivery_location)) {
            throw new Exception('Delivery location is required');
        }
        if ($user_id <= 0) {
            throw new Exception('Invalid user ID - Please log in');
        }
        if (empty($payment_method)) {
            throw new Exception('Payment method is required');
        }

        // Validate and store payment details
        $payment_details = null;
        if ($payment_method === 'upi') {
            $upi_id = $_POST['upi_id'] ?? '';
            if (!preg_match('/^[a-zA-Z0-9]+@[a-zA-Z0-9]+$/', $upi_id)) {
                throw new Exception('Invalid UPI ID');
            }
            $payment_details = $upi_id;
        } elseif ($payment_method === 'card') {
            $card_number = $_POST['card_number'] ?? '';
            $card_expiry = $_POST['card_expiry'] ?? '';
            $card_cvc = $_POST['card_cvc'] ?? '';
            if (!preg_match('/^\d{16}$/', $card_number) ||
                !preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $card_expiry) ||
                !preg_match('/^\d{3}$/', $card_cvc)) {
                throw new Exception('Invalid card details');
            }
            $payment_details = 'Card ending in ' . substr($card_number, -4);
        } elseif ($payment_method === 'cash') {
            $payment_details = null;
        }

        // Start transaction
        $conn->begin_transaction();

        // Insert into orders
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, delivery_location) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $user_id, $total, $delivery_location);
        $stmt->execute();
        $order_id = $conn->insert_id;
        $stmt->close();

        // Prepare statements for item processing
        $selectStmt = $conn->prepare("SELECT item_id FROM menu_items WHERE name = ? LIMIT 1");
        $insertStmt = $conn->prepare("INSERT INTO order_items (order_id, item_id, quantity, price_at_time) VALUES (?, ?, ?, ?)");

        foreach ($cart as $item) {
            if (!isset($item['name'], $item['price'], $item['quantity'])) {
                throw new Exception('Invalid cart item data');
            }

            $selectStmt->bind_param("s", $item['name']);
            $selectStmt->execute();
            $selectStmt->bind_result($item_id);
            if (!$selectStmt->fetch()) {
                throw new Exception("Item not found in menu_items: " . $item['name']);
            }
            $selectStmt->reset();

            $insertStmt->bind_param("iiid", $order_id, $item_id, $item['quantity'], $item['price']);
            $insertStmt->execute();
        }

        $selectStmt->close();
        $insertStmt->close();

        // Insert into payments
        $paymentStmt = $conn->prepare("INSERT INTO payments (order_id, user_id, payment_method, payment_details, amount) VALUES (?, ?, ?, ?, ?)");
        $paymentStmt->bind_param("i ss sd", $order_id, $user_id, $payment_method, $payment_details, $total);
        $paymentStmt->execute();
        $paymentStmt->close();

        // Commit transaction
        $conn->commit();

        // Clear cart
        unset($_SESSION['cart']);

        // Set session message and redirect
        $_SESSION['payment_success'] = "Payment successful! Order #$order_id will be delivered soon.";
        header("Location: new.php?payment_success=1");
        exit();

    } catch (Exception $e) {
        if ($conn->errno) {
            $conn->rollback();
        }
        error_log("Error in save_order.php: " . $e->getMessage());
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
ob_end_flush();
?>
