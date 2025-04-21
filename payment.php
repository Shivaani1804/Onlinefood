<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] <= 0) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Express - Payment</title>
    <style>
        :root {
            --primary-color: #ff6347;
            --secondary-color: #2c3e50;
            --accent-color: #4CAF50;
            --text-color: #ecf0f1;
            --glass-bg: rgba(255, 255, 255, 0.15);
            --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            min-height: 100vh;
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            width: 100%;
            max-width: 800px;
        }

        header h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .location-section input {
            width: 100%;
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            font-size: 1rem;
        }

        .payment-table {
            width: 100%;
            max-width: 800px;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 40px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1001;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        th {
            background: var(--secondary-color);
            font-weight: 600;
            font-size: 1.1rem;
            position: sticky;
            top: 0;
            z-index: 1002;
        }

        td {
            font-size: 1rem;
        }

        .total-row {
            font-weight: 600;
            background: var(--secondary-color);
            position: sticky;
            bottom: 0;
            z-index: 1002;
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .quantity-btn:hover {
            background: lighten(var(--secondary-color), 10%);
        }

        .quantity {
            margin: 0 10px;
            width: 30px;
            text-align: center;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .delete-btn:hover {
            background: darken(#e74c3c, 10%);
        }

        .payment-options {
            width: 100%;
            max-width: 800px;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .payment-option {
            margin-bottom: 20px;
        }

        .payment-option label {
            font-size: 1.2rem;
            cursor: pointer;
            display: block;
            margin-bottom: 10px;
        }

        .payment-option input[type="radio"] {
            margin-right: 10px;
        }

        .payment-details {
            display: none;
            margin-top: 10px;
        }

        .payment-details.active {
            display: block;
        }

        .payment-details input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            font-size: 1rem;
        }

        .pay-now {
            background: var(--accent-color);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 1.1rem;
            margin: 20px auto;
            display: block;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pay-now:hover {
            background: darken(var(--accent-color), 10%);
            transform: scale(1.05);
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            color: var(--text-color);
            font-size: 1.2rem;
            z-index: 2000;
            display: none;
            text-align: center;
            max-width: 400px;
        }

        .popup.active {
            display: block;
        }

        footer {
            margin-top: auto;
            padding: 25px;
            background: var(--secondary-color);
            text-align: center;
            font-size: 1.1rem;
            width: 100%;
            z-index: 1000;
        }

        @media (max-width: 768px) {
            .payment-table, .payment-options {
                max-width: 100%;
            }
            th, td {
                font-size: 0.9rem;
                padding: 10px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Payment Summary</h1>
    </header>

    <!-- Form to submit data to save_order.php -->
    <form action="save_order.php" method="POST">
        <div class="location-section">
            <input type="text" id="deliveryLocation" name="delivery_location" placeholder="Enter your delivery location" required>
            <!-- Hidden fields for cart and user_id -->
            <input type="hidden" id="cartData" name="cart" value="">
            <input type="hidden" id="totalAmount" name="total" value="">
            <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
        </div>

        <div class="payment-table">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="paymentTableBody"></tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3">Grand Total</td>
                        <td id="grandTotal">$0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="payment-options">
            <h2 style="text-align: center; margin-bottom: 20px;">Select Payment Method</h2>
            <div class="payment-option">
                <label><input type="radio" name="payment_method" value="upi" onclick="showPaymentDetails('upi')" required> UPI</label>
                <div id="upi-details" class="payment-details">
                    <input type="text" id="upiId" name="upi_id" placeholder="Enter UPI ID (e.g., name@upi)">
                </div>
            </div>
            <div class="payment-option">
                <label><input type="radio" name="payment_method" value="card" onclick="showPaymentDetails('card')"> Card</label>
                <div id="card-details" class="payment-details">
                    <input type="text" id="cardNumber" name="card_number" placeholder="Card Number (16 digits)" maxlength="16">
                    <input type="text" id="cardExpiry" name="card_expiry" placeholder="MM/YY" maxlength="5">
                    <input type="text" id="cardCvc" name="card_cvc" placeholder="CVC (3 digits)" maxlength="3">
                </div>
            </div>
            <div class="payment-option">
                <label><input type="radio" name="payment_method" value="cash" onclick="showPaymentDetails('cash')"> Cash on Delivery</label>
                <div id="cash-details" class="payment-details">
                    <p>No additional details required. Pay upon delivery.</p>
                </div>
            </div>
        </div>

        <button type="submit" class="pay-now">Pay Now</button>
    </form>

    <div class="popup" id="paymentPopup"></div>

    <footer>
        © 2025 Food Express | Crafted with Passion
    </footer>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const tableBody = document.getElementById('paymentTableBody');
        const grandTotalCell = document.getElementById('grandTotal');
        const paymentPopup = document.getElementById('paymentPopup');

        function updateCartDisplay() {
            tableBody.innerHTML = '';
            let grandTotal = 0;
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                grandTotal += itemTotal;
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td>
                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                            <span class="quantity">${item.quantity}</span>
                            <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                    </td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>$${itemTotal.toFixed(2)}</td>
                    <td><button class="delete-btn" onclick="deleteItem(${index})">Delete</button></td>
                `;
                tableBody.appendChild(row);
            });
            grandTotalCell.textContent = `$${grandTotal.toFixed(2)}`;
            localStorage.setItem('cart', JSON.stringify(cart));
            // Update hidden fields for form submission
            document.getElementById('cartData').value = JSON.stringify(cart);
            document.getElementById('totalAmount').value = grandTotal;
        }

        function updateQuantity(index, change) {
            cart[index].quantity += change;
            if (cart[index].quantity < 1) cart[index].quantity = 1;
            updateCartDisplay();
        }

        function deleteItem(index) {
            cart.splice(index, 1);
            updateCartDisplay();
        }

        function showPaymentDetails(method) {
            document.querySelectorAll('.payment-details').forEach(detail => detail.classList.remove('active'));
            document.getElementById(`${method}-details`).classList.add('active');
        }

        function showPopup(message) {
            paymentPopup.textContent = message;
            paymentPopup.classList.add('active');
            setTimeout(() => paymentPopup.classList.remove('active'), 3000);
        }

        // Initial cart display
        updateCartDisplay();
    </script>
</body>
</html>