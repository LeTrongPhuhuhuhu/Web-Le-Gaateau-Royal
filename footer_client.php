<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS for the footer */
        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f8f8;
            padding: 20px 0;
            text-align: center;
            flex-wrap: wrap;
        }

        .footer-logo img {
            max-width: 100px;
            height: auto;
        }

        .footer-info {
            font-size: 14px;
            margin: 0;
            display: inline-block;
        }

        .footer-right {
            text-align: right;
        }

        .footer-right img {
            margin: 0 10px;
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }

        .footer-right img:hover {
            transform: scale(1.2);
        }

        .footer-credits {
            font-size: 12px;
            margin-top: 10px;
        }

        .footer-credits p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Your website content here -->
    </div>
    <footer>
        <div class="footer-container">
            <!-- Left side: Logo, address, and phone number -->
            <div class="footer-left">
                <div class="footer-logo">
                    <a href="index.php">
                        <img src="Image/logo/logoremove.png" alt="Brand Logo">
                    </a>
                </div>
                <div class="footer-info">
                    <p><strong>Address:</strong> 123 TL43 Street, Binh Chieu Ward, Thu Duc District</p>
                    <p><strong>Phone:</strong> 0523467761</p>
                </div>
            </div>

            <!-- Right side: Social media links and credits -->
            <div class="footer-right">
                <a href="https://www.facebook.com/phu.letrong.543" target="_blank">
                    <img src="Image/logo/facebook.png" alt="Facebook">
                </a>
                <a href="#" target="_blank">
                    <img src="Image/logo/instagram.png" alt="Instagram">
                </a>
                <a href="#" target="_blank">
                    <img src="Image/logo/twitter.png" alt="Twitter">
                </a>
                <div class="footer-credits">
                    <p>Design by Le Trong Phu</p>
                    <p>&copy; Copyright by Le Trong Phu</p>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // JavaScript for footer effects (if needed)
        window.addEventListener('scroll', function() {
            var footer = document.querySelector('footer');
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                footer.classList.add('footer-visible');
            } else {
                footer.classList.remove('footer-visible');
            }
        });
    </script>
</body>
</html>
