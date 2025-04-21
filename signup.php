<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Express - Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff6347;
            --secondary-color: #2c3e50;
            --accent-color: #4CAF50;
            --text-color: #ecf0f1;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(45deg, #1a1a2e, #16213e);
            overflow: hidden;
            position: relative;
        }

        /* Particle Background */
        #particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .login-container {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            width: 400px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform-style: preserve-3d;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            z-index: 1;
            animation: floatIn 1.5s ease-out forwards;
        }

        .login-container:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.5);
        }

        h2 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 32px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            animation: glow 2s infinite alternate;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }

        .input-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: var(--text-color);
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .input-group input {
            width: 100%;
            padding: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-color);
            font-size: 16px;
            outline: none;
            transition: all 0.4s ease;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .input-group input:focus {
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 15px rgba(255, 99, 71, 0.5);
            transform: scale(1.02);
        }

        .input-group input::placeholder {
            color: rgba(236, 240, 241, 0.7);
            font-style: italic;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary-color), #e63946);
            border: none;
            border-radius: 25px;
            color: white;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .login-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .login-btn:hover {
            transform: scale(1.05);
        }

        .forgot-password {
            margin-top: 15px;
        }

        .forgot-password a {
            color: var(--text-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--primary-color);
            text-decoration: underline;
            text-shadow: 0 0 5px rgba(255, 99, 71, 0.5);
        }

        /* Animations */
        @keyframes floatIn {
            0% { transform: translateY(100px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        @keyframes glow {
            0% { text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); }
            100% { text-shadow: 0 0 15px rgba(255, 99, 71, 0.7), 0 2px 4px rgba(0, 0, 0, 0.3); }
        }

        /* Media Queries */
        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                padding: 20px;
            }
            h2 { font-size: 24px; }
            .input-group input { padding: 12px; }
            .login-btn { padding: 12px; font-size: 16px; }
        }
    </style>
</head>
<body>
    <!-- Particle Background -->
    <canvas id="particles"></canvas>

    <div class="login-container" id="loginContainer">
        <h2>Sign Up</h2>
        <form action="method2.php" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="input-group">
                <label for="email">Email ID</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn">Sign Up</button>
            <div class="forgot-password">
                Already Have An Account? <a href="login.php">Login</a>
            </div>
        </form>
    </div>

    <script>
        // Particle Animation
        const canvas = document.getElementById('particles');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particlesArray = [];
        const numberOfParticles = 100;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 5 + 1;
                this.speedX = Math.random() * 1 - 0.5;
                this.speedY = Math.random() * 1 - 0.5;
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.size > 0.2) this.size -= 0.05;
            }
            draw() {
                ctx.fillStyle = 'rgba(255, 99, 71, 0.8)';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function init() {
            for (let i = 0; i < numberOfParticles; i++) {
                particlesArray.push(new Particle());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (let i = 0; i < particlesArray.length; i++) {
                particlesArray[i].update();
                particlesArray[i].draw();
                if (particlesArray[i].size <= 0.2) {
                    particlesArray.splice(i, 1);
                    i--;
                    particlesArray.push(new Particle());
                }
            }
            requestAnimationFrame(animate);
        }

        init();
        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        // 3D Tilt Effect
        const loginContainer = document.getElementById('loginContainer');
        loginContainer.addEventListener('mousemove', (e) => {
            const rect = loginContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            loginContainer.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        loginContainer.addEventListener('mouseleave', () => {
            loginContainer.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
        });
    </script>
</body>
</html>