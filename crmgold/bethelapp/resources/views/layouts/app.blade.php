<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }} | {{ $settings['site_name'] ?? 'Bethel Gold' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Your static CSS, with dynamic colors */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #FAF3E0;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .btn {
            display: inline-block;
            background: {{ $settings['primary_color'] ?? '#C9A635' }};
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #228B22;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        section {
            padding: 60px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            font-size: 36px;
            margin-bottom: 15px;
            color: {{ $settings['primary_color'] ?? '#C9A635' }};
        }

        .section-title p {
            font-size: 18px;
            color: #333;
        }

        /* Header Styles */
        header {
            background-color: {{ $settings['secondary_color'] ?? '#1A1A2E' }};
            color: #fff;
            padding: 15px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            width: auto;
            margin-right: 10px;
            border-radius: 50%;
        }

        .logo h1 {
            font-size: 28px;
            color: {{ $settings['primary_color'] ?? '#C9A635' }};
            margin-left: 10px;
        }

        .logo span {
            color: #FAF3E0;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 25px;
        }

        nav ul li a {
            color: #FAF3E0;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
            font-weight: 500;
        }

        nav ul li a:hover {
            color: {{ $settings['primary_color'] ?? '#C9A635' }};
        }

        .hamburger {
            display: none;
            font-size: 24px;
            color: #FAF3E0;
            cursor: pointer;
            padding: 10px;
        }

        .hamburger:hover {
            color: {{ $settings['primary_color'] ?? '#C9A635' }};
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .logo img {
                height: 30px;
            }

            .logo h1 {
                font-size: 24px;
            }

            .hamburger {
                display: block;
            }

            nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: {{ $settings['secondary_color'] ?? '#1A1A2E' }};
                padding: 20px 0;
            }

            nav.active {
                display: block;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
            }

            nav ul li {
                margin: 10px 0;
            }

            nav ul li a {
                font-size: 18px;
            }
        }

        /* Block-specific styles (will add more as we define blocks) */
        .hero {
            background: linear-gradient(rgba(26, 26, 46, 0.7), rgba(26, 26, 46, 0.7)), url('{{ $block->content['background_image'] ?? '/img/hero-bg.jpeg' }}') no-repeat center center/cover;
            height: 100vh;
            color: #FAF3E0;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-content h2 {
            font-size: 48px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: {{ $settings['primary_color'] ?? '#C9A635' }};
        }

        .hero-content p {
            font-size: 20px;
            margin-bottom: 30px;
        }

       /* Steps Section */
.steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}
.step-card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid {{ $settings['primary_color'] ?? '#C9A635' }};
    text-align: center;
    transition: transform 0.3s;
}
.step-card:hover {
    transform: translateY(-10px);
}
.step-card h3 {
    color: {{ $settings['primary_color'] ?? '#C9A635' }};
    margin-bottom: 10px;
}

/* Live Prices Section */
.live-prices {
    text-align: center;
}
.price-calculator {
    max-width: 500px;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid {{ $settings['primary_color'] ?? '#C9A635' }};
}
.price-calculator h3 {
    color: {{ $settings['primary_color'] ?? '#C9A635' }};
    margin-bottom: 20px;
}
.price-calculator .form-group {
    margin-bottom: 20px;
}
.price-calculator .form-group label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}
.price-calculator .form-group input,
.price-calculator .form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid {{ $settings['primary_color'] ?? '#C9A635' }};
    border-radius: 5px;
}

.contact-form .bg-green-100 {
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}
.contact-form .bg-red-100 {
    background-color: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}
.contact-form .form-group {
    margin-bottom: 20px;
}
.contact-form input, .contact-form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}






    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="{{ $settings['logo_url'] ?? '/img/Homelogo.jpg' }}" alt="Bethel Gold Logo">
                <h1>{{ $settings['site_name'] ?? 'BETHEL' }} <span>GOLD</span></h1>
            </div>
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
            <nav>
                <ul>
                    @foreach ($menu as $item)
                        <li><a href="{{ $item->url }}">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: {{ $settings['secondary_color'] ?? '#1A1A2E' }}; color: #FAF3E0; padding: 40px 0 20px;">
        <div class="container">
            <div class="footer-container">
                <div class="footer-section">
                    <h3>{{ $settings['site_name'] ?? 'Bethel Gold' }}</h3>
                    <p>Maximizing profits through gold trading, mining operations, and equipment services. Quality, integrity, and excellence since 2005.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <div class="footer-links">
                        @foreach ($menu as $item)
                            <a href="{{ $item->url }}">{{ $item->label }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Connect With Us</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 {{ $settings['site_name'] ?? 'Bethel Gold' }}. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Hamburger menu toggle
        const hamburger = document.querySelector('.hamburger');
        const nav = document.querySelector('nav');

        hamburger.addEventListener('click', () => {
            nav.classList.toggle('active');
            const icon = hamburger.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Close menu when clicking a nav link
        const navLinks = document.querySelectorAll('nav ul li a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('active');
                const icon = hamburger.querySelector('i');
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-times');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!nav.contains(event.target) && !hamburger.contains(event.target)) {
                nav.classList.remove('active');
                const icon = hamburger.querySelector('i');
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-times');
            }
        });
    </script>
</body>
</html>
