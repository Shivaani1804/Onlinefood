<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Express - Restaurant Details</title>
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
            overflow-x: hidden;
        }

        header {
            position: relative;
            padding: 80px 20px 40px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            text-transform: uppercase;
            animation: slideIn 1s ease-out;
        }

        header p {
            font-size: 1.4rem;
            opacity: 0.9;
            margin-top: 10px;
            animation: fadeIn 1.5s ease-out;
        }

        .cart-container {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            z-index: 1001;
        }

        .cart-icon {
            width: 30px;
            height: 30px;
            background: url('https://img.icons8.com/ios-filled/50/ffffff/shopping-cart.png') no-repeat center;
            background-size: contain;
        }

        .cart-count {
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            margin-left: 5px;
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
            animation: fadeInPopup 0.3s ease-out;
        }

        .popup.active {
            display: block;
        }

        @keyframes fadeInPopup {
            from { opacity: 0; transform: translate(-50%, -60%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }

        .menu-section {
            max-width: 1200px;
            margin: 60px auto;
            padding: 20px;
            display: none;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease-out;
        }

        .menu-section.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .menu-title {
            font-size: 2.5rem;
            color: var(--accent-color);
            text-align: center;
            margin-bottom: 40px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-out;
        }

        .menu-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            justify-items: center;
            margin-bottom: 60px;
            perspective: 1000px;
        }

        .menu-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            overflow: hidden;
            width: 280px;
            text-align: center;
            padding-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }

        .menu-card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: var(--card-shadow);
        }

        .menu-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .menu-card:hover img {
            transform: scale(1.1);
        }

        .menu-card h3 {
            font-size: 1.6rem;
            margin: 15px 0;
            color: var(--primary-color);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .price {
            font-size: 1.3rem;
            color: var(--accent-color);
            margin: 10px 0;
            font-weight: 600;
        }

        .quantity-control {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px 0;
        }

        .quantity-btn {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .quantity-btn:hover {
            background: lighten(var(--secondary-color), 10%);
        }

        .quantity {
            margin: 0 15px;
            font-size: 1.2rem;
            width: 30px;
            text-align: center;
        }

        .add-to-cart {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            width: 80%;
            cursor: pointer;
            font-size: 1.1rem;
            margin-top: 15px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .add-to-cart:hover {
            background: darken(var(--primary-color), 10%);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(255, 99, 71, 0.4);
        }

        h3 {
            font-size: 2rem;
            color: var(--text-color);
            margin: 30px 0 20px;
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        footer {
            padding: 25px;
            background: var(--secondary-color);
            text-align: center;
            font-size: 1.1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @media (max-width: 1024px) {
            .menu-list {
                grid-template-columns: repeat(2, 1fr);
            }

            header h1 { font-size: 2.8rem; }
            .menu-title { font-size: 2rem; }
            .menu-card { width: 260px; }
        }

        @media (max-width: 768px) {
            .menu-list {
                grid-template-columns: 1fr;
            }

            header {
                padding: 60px 15px 40px;
                clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
            }

            .menu-card { width: 300px; }
            header h1 { font-size: 2.2rem; }
            header p { font-size: 1.2rem; }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Food Express</h1>
        <p>Indulge in Culinary Delights</p>
        <div class="cart-container" onclick="goToPayment()">
            <div class="cart-icon"></div>
            <span class="cart-count">0</span>
        </div>
    </header>

    <div class="popup" id="cartPopup">Added to Cart!</div>

    <div class="menu-section" id="la-fiego">
        <h2 class="menu-title">La Fiego - Italian Cuisine</h2>
        <h3>Food</h3>
        <div class="menu-list">
            <div class="menu-card" data-name="Pizza Margherita" data-price="8.99">
                <img src="piza.jpg" alt="Pizza">
                <h3>Pizza Margherita</h3>
                <p class="price">$8.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Spaghetti Carbonara" data-price="7.49">
                <img src="paz.jpg" alt="Pasta">
                <h3>Spaghetti Carbonara</h3>
                <p class="price">$7.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Lasagna" data-price="9.99">
                <img src="lasa.jpg" alt="Lasagna">
                <h3>Lasagna</h3>
                <p class="price">$9.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Mushroom Risotto" data-price="8.49">
                <img src="ris.jpg" alt="Risotto">
                <h3>Mushroom Risotto</h3>
                <p class="price">$8.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
        </div>
        <h3>Drinks</h3>
        <div class="menu-list">
            <div class="menu-card" data-name="Limonata" data-price="3.99">
                <img src="lemo.jpg" alt="Limonata">
                <h3>Limonata</h3>
                <p class="price">$3.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Espresso" data-price="2.99">
                <img src="esp.jpg" alt="Espresso">
                <h3>Espresso</h3>
                <p class="price">$2.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="House Red Wine" data-price="5.99">
                <img src="win.jpg" alt="Wine">
                <h3>House Red Wine</h3>
                <p class="price">$5.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Sparkling Water" data-price="2.49">
                <img src="hou.jpg" alt="Sparkling Water">
                <h3>Sparkling Water</h3>
                <p class="price">$2.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
        </div>
        <h3>Desserts</h3>
        <div class="menu-list">
            <div class="menu-card" data-name="Tiramisu" data-price="5.99">
                <img src="tir.jpg" alt="Tiramisu">
                <h3>Tiramisu</h3>
                <p class="price">$5.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Vanilla Gelato" data-price="4.99">
                <img src="vani.jpg" alt="Gelato">
                <h3>Vanilla Gelato</h3>
                <p class="price">$4.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Panna Cotta" data-price="5.49">
                <img src="pan.jpg" alt="Panna Cotta">
                <h3>Panna Cotta</h3>
                <p class="price">$5.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Cannoli" data-price="4.49">
                <img src="conn.jpg" alt="Cannoli">
                <h3>Cannoli</h3>
                <p class="price">$4.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
        </div>
    </div>

    <div class="menu-section" id="yoo-wu">
        <h2 class="menu-title">Yoo Wu - Chinese Delights</h2>
        <h3>Food</h3>
        <div class="menu-list">
            <div class="menu-card" data-name="Fried Rice" data-price="6.99">
                <img src="fried-rice-500x500.jpg" alt="Fried Rice">
                <h3>Fried Rice</h3>
                <p class="price">$6.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Chow Mein" data-price="7.49">
                <img src="noodles.jpg" alt="Noodles">
                <h3>Chow Mein</h3>
                <p class="price">$7.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Dumplings" data-price="12.99">
                <img src="dumplings.jpg" alt="Dumplings">
                <h3>Dumplings</h3>
                <p class="price">$12.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Sweet & Sour Chicken" data-price="8.99">
                <img src="Sweet-And-Sour-Chicken.jpg" alt="Sweet and Sour">
                <h3>Sweet & Sour Chicken</h3>
                <p class="price">$8.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
        </div>
        <h3>Drinks</h3>
        <div class="menu-list">
            <div class="menu-card" data-name="Green Tea" data-price="2.99">
                <img src="green tea.jpg" alt="Green Tea">
                <h3>Green Tea</h3>
                <p class="price">$2.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Bubble Tea" data-price="4.99">
                <img src="bubble tea.jpg" alt="Bubble Tea">
                <h3>Bubble Tea</h3>
                <p class="price">$4.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Plum Juice" data-price="3.49">
                <img src="plum-juice.jpg" alt="Plum Juice">
                <h3>Plum Juice</h3>
                <p class="price">$3.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Soy Milk" data-price="2.49">
                <img src="soy.jpg" alt="Soy Milk">
                <h3>Soy Milk</h3>
                <p class="price">$2.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
        </div>
        <h3>Desserts</h3>
        <div class="menu-list">
            <div class="menu-card" data-name="Mango Pudding" data-price="4.99">
                <img src="mango pudding.jpg" alt="Mango Pudding">
                <h3>Mango Pudding</h3>
                <p class="price">$4.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Sesame Balls" data-price="3.99">
                <img src="sesame-balls.jpg" alt="Sesame Balls">
                <h3>Sesame Balls</h3>
                <p class="price">$3.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Egg Tart" data-price="4.49">
                <img src="egg tart.jpg" alt="Egg Tart">
                <h3>Egg Tart</h3>
                <p class="price">$4.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Mooncake" data-price="5.99">
                <img src="moon.jpg" alt="Mooncake">
                <h3>Mooncake</h3>
                <p class="price">$5.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
        </div>
    </div>

    <div class="menu-section" id="indo-bites">
        <h2 class="menu-title">Indo Bites - Indian Spices</h2>
        <h3>Food</h3>
        <div class="menu-list">
            <div class="menu-card" data-name="Butter Chicken" data-price="9.99">
                <img src="butter chicken.jpg" alt="Butter Chicken">
                <h3>Butter Chicken</h3>
                <p class="price">$9.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Naan Bread" data-price="2.99">
                <img src="naan.jpg" alt="Naan">
                <h3>Naan Bread</h3>
                <p class="price">$2.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Chicken Biryani" data-price="10.99">
                <img src="biriyani.jpg" alt="Biryani">
                <h3>Chicken Biryani</h3>
                <p class="price">$10.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Samosa" data-price="3.99">
                <img src="samosa.jpg" alt="Samosa">
                <h3>Samosa</h3>
                <p class="price">$3.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
        </div>
        <h3>Drinks</h3>
        <div class="menu-list">
            <div class="menu-card" data-name="Mango Lassi" data-price="4.49">
                <img src="mango lassi.jpg" alt="Mango Lassi">
                <h3>Mango Lassi</h3>
                <p class="price">$4.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Masala Chai" data-price="3.99">
                <img src="masala.jpg" alt="Chai">
                <h3>Masala Chai</h3>
                <p class="price">$3.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Rose Sharbat" data-price="3.49">
                <img src="rose sharbat.jpg" alt="Rose Water">
                <h3>Rose Sharbat</h3>
                <p class="price">$3.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Jaljeera" data-price="2.99">
                <img src="jaljeera.jpg" alt="Jaljeera">
                <h3>Jaljeera</h3>
                <p class="price">$2.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
        </div>
        <h3>Desserts</h3>
        <div class="menu-list">
            <div class="menu-card" data-name="Gulab Jamun" data-price="4.99">
                <img src="gula.jpg" alt="Gulab Jamun">
                <h3>Gulab Jamun</h3>
                <p class="price">$4.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Kheer" data-price="5.49">
                <img src="kheer.jpg" alt="Kheer">
                <h3>Kheer</h3>
                <p class="price">$5.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Jalebi" data-price="3.99">
                <img src="jalebi.jpg" alt="Jalebi">
                <h3>Jalebi</h3>
                <p class="price">$3.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
            <div class="menu-card" data-name="Rasmalai" data-price="5.99">
                <img src="rasmalai.jpg" alt="Rasmalai">
                <h3>Rasmalai</h3>
                <p class="price">$5.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                </div>
                <button class="add-to-cart" onclick="addToCart(this)">Add to Cart</button>
            </div>
        </div>
    </div>

    <footer>
    </footer>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const restaurant = urlParams.get('restaurant');
        const restaurantMap = {
            'La Fiego': 'la-fiego',
            'Yoo Wu': 'yoo-wu',
            'Indo Bites': 'indo-bites'
        };
        if (restaurant && restaurantMap[restaurant]) {
            document.getElementById(restaurantMap[restaurant]).classList.add('active');
        }

        const sections = document.querySelectorAll('.menu-list');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.2 });

        sections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(50px)';
            observer.observe(section);
        });

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCount = document.querySelector('.cart-count');
        const cartPopup = document.getElementById('cartPopup');

        updateCartCount();

        function goToPayment() {
            localStorage.setItem('cart', JSON.stringify(cart));
            window.location.href = 'payment.php';
        }

        function increaseQuantity(button) {
            const quantitySpan = button.parentElement.querySelector('.quantity');
            let quantity = parseInt(quantitySpan.textContent);
            quantity++;
            quantitySpan.textContent = quantity;
        }

        function decreaseQuantity(button) {
            const quantitySpan = button.parentElement.querySelector('.quantity');
            let quantity = parseInt(quantitySpan.textContent);
            if (quantity > 1) {
                quantity--;
                quantitySpan.textContent = quantity;
            }
        }

        function addToCart(button) {
            const card = button.closest('.menu-card');
            const name = card.getAttribute('data-name');
            const price = parseFloat(card.getAttribute('data-price'));
            const quantity = parseInt(card.querySelector('.quantity').textContent);

            const existingItem = cart.find(item => item.name === name);
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({ name, price, quantity });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            showPopup();
        }

        function updateCartCount() {
            cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
        }

        function showPopup() {
            cartPopup.classList.add('active');
            setTimeout(() => {
                cartPopup.classList.remove('active');
            }, 2000);
        }
    </script>
</body>
</html>