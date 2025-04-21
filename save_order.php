<?php
session_start();
ob_start();

define('DB_HOST', 'my-mysql');
define('DB_NAME', 'ofd');
define('DB_USER', 'root');
define('DB_PASS', 'root');

function getDatabaseConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        die("Database connection failed: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = getDatabaseConnection();

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
            if (!preg_match('/^\d{16}$/', $card_number) || !preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $card_expiry) || !preg_match('/^\d{3}$/', $card_cvc)) {
                throw new Exception('Invalid card details');
            }
            $payment_details = 'Card ending in ' . substr($card_number, -4);
        } elseif ($payment_method === 'cash') {
            $payment_details = null;
        }

        
        $db->beginTransaction();

        
        $stmt = $db->prepare("INSERT INTO orders (user_id, total_amount, delivery_location) VALUES (:user_id, :total_amount, :delivery_location)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':total_amount' => $total,
            ':delivery_location' => $delivery_location
        ]);
        $order_id = $db->lastInsertId();

        
        $selectStmt = $db->prepare("SELECT item_id FROM menu_items WHERE name = ? LIMIT 1");
        $insertStmt = $db->prepare("INSERT INTO order_items (order_id, item_id, quantity, price_at_time) VALUES (:order_id, :item_id, :quantity, :price_at_time)");

        foreach ($cart as $item) {
            if (!isset($item['name']) || !isset($item['price']) || !isset($item['quantity'])) {
                throw new Exception('Invalid cart item data');
            }

            $selectStmt->execute([$item['name']]);
            $item_id = $selectStmt->fetchColumn();
            if ($item_id === false) {
                throw new Exception("Item not found in menu_items: " . $item['name']);
            }

            $insertStmt->execute([
                ':order_id' => $order_id,
                ':item_id' => $item_id,
                ':quantity' => (int)$item['quantity'],
                ':price_at_time' => (float)$item['price']
            ]);
        }

        # Insert into payments table
        $paymentStmt = $db->prepare("INSERT INTO payments (order_id, user_id, payment_method, payment_details, amount) VALUES (:order_id, :user_id, :payment_method, :payment_details, :amount)");
        $paymentStmt->execute([
            ':order_id' => $order_id,
            ':user_id' => $user_id,
            ':payment_method' => $payment_method,
            ':payment_details' => $payment_details,
            ':amount' => $total
        ]);

        # Commit transaction
        $db->commit();

        # Clear the cart
        unset($_SESSION['cart']); # Clear session cart if used
        # Since payment.php uses localStorage, we'll clear it via JavaScript on new.php

        # Set success message in session
        $_SESSION['payment_success'] = "Payment successful! Order #$order_id will be delivered soon.";

        # Redirect to new.php with a success flag
        header("Location: new.php?payment_success=1");
        exit;

    } catch (Exception $e) {
        if (isset($db) && $db->inTransaction()) {
            $db->rollBack();
        }
        error_log("Error in save_order.php: " . $e->getMessage());
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
} else {
    echo "Invalid request method.";
}
ob_end_flush();
