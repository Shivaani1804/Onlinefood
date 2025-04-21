<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Express - Restaurant Selection</title>
    <style>
        :root {
            --primary-color: #ff6347;
            --secondary-color: #2c3e50;
            --accent-color: #4CAF50;
            --text-color: #ecf0f1;
            --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            --glass-bg: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, #1a1a2e, #16213e);
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--text-color);
        }

        /* Header */
        header {
            position: relative;
            padding: 80px 20px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
            overflow: hidden;
        }

        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://source.unsplash.com/random/1920x1080?food') no-repeat center/cover;
            opacity: 0.15;
            z-index: 0;
        }

        header h1 {
            font-size: 4rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: slideIn 1s ease-out;
            position: relative;
            z-index: 1;
        }

        header p {
            font-size: 1.5rem;
            margin-top: 10px;
            opacity: 0.9;
            animation: fadeIn 1.5s ease-out;
            position: relative;
            z-index: 1;
        }

        /* Restaurant List */
        .restaurant-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 40px;
            padding: 60px 40px;
            max-width: 1400px;
            margin: 0 auto;
            perspective: 1000px;
        }

        .restaurant-card {
            position: relative;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .restaurant-card:hover {
            transform: translateY(-15px) rotateX(5deg);
            box-shadow: var(--card-shadow);
        }

        .card-image {
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
            transition: transform 0.6s ease;
        }

        .restaurant-card:hover .card-image {
            transform: scale(1.1);
        }

        .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .restaurant-card:hover .card-overlay {
            opacity: 1;
        }

        .card-content {
            padding: 20px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .card-content h2 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-color);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .card-content p {
            font-size: 1.2rem;
            color: var(--text-color);
            opacity: 0.85;
            margin-top: 8px;
        }

        .card-btn {
            margin-top: 15px;
            padding: 10px 25px;
            background: var(--accent-color);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }

        .restaurant-card:hover .card-btn {
            opacity: 1;
            transform: translateY(0);
        }

        .card-btn:hover {
            background: darken(var(--accent-color), 10%);
            transform: scale(1.05);
        }

        /* Footer */
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

        /* Popup */
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
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .popup.active {
            display: block;
        }

        /* Animations */
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Media Queries */
        @media (max-width: 1024px) {
            .restaurant-list {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                padding: 40px 20px;
            }

            header h1 { font-size: 3rem; }
            header p { font-size: 1.2rem; }
        }

        @media (max-width: 768px) {
            .restaurant-card {
                margin-left: 0;
            }

            header {
                padding: 60px 15px;
                clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
            }

            header h1 { font-size: 2.5rem; }
            .card-image { height: 200px; }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Food Express</h1>
        <p>Discover Culinary Excellence</p>
    </header>

    <div class="restaurant-list">
        <div class="restaurant-card" onclick="window.location.href='restaurant-details.php?restaurant=La Fiego'">
            <div class="card-image" style="background-image: url('ita.jpg');"></div>
            <div class="card-overlay"></div>
            <div class="card-content">
                <h2>La Fiego</h2>
                <p>Savor Authentic Italian Flavors</p>
                <button class="card-btn">Explore Menu</button>
            </div>
        </div>

        <div class="restaurant-card" onclick="window.location.href='restaurant-details.php?restaurant=Yoo Wu'">
            <div class="card-image" style="background-image: url('chi.jpg');"></div>
            <div class="card-overlay"></div>
            <div class="card-content">
                <h2>Yoo Wu</h2>
                <p>Exquisite Chinese Delights</p>
                <button class="card-btn">Explore Menu</button>
            </div>
        </div>

        <div class="restaurant-card" onclick="window.location.href='restaurant-details.php?restaurant=Indo Bites'">
            <div class="card-image" style="background-image: url('ind.jpg');"></div>
            <div class="card-overlay"></div>
            <div class="card-content">
                <h2>Indo Bites</h2>
                <p>Spicy Indian Masterpieces</p>
                <button class="card-btn">Explore Menu</button>
            </div>
        </div>
    </div>

    <footer>
        <!-- Add footer content if needed -->
    </footer>

    <div class="popup" id="paymentPopup"></div>

    <script>
        // Existing card animation observer
        const cards = document.querySelectorAll('.restaurant-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'float 3s infinite ease-in-out';
                }
            });
        }, { threshold: 0.3 });

        cards.forEach(card => observer.observe(card));

        // Payment success popup and cart clearing
        <?php if (isset($_GET['payment_success']) && $_GET['payment_success'] == 1 && isset($_SESSION['payment_success'])): ?>
            // Clear localStorage cart
            localStorage.removeItem('cart');

            // Show popup
            const popup = document.getElementById('paymentPopup');
            popup.textContent = "<?php echo addslashes($_SESSION['payment_success']); unset($_SESSION['payment_success']); ?>";
            popup.classList.add('active');

            // Hide popup after 3 seconds
            setTimeout(() => {
                popup.classList.remove('active');
            }, 3000);
        <?php endif; ?>
    </script>
</body>
</html>