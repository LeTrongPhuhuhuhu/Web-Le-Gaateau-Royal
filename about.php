<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Le Gâteau Royal</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="site-wrapper">
        <header>
            <?php include 'navbar_client.php'; ?>
        </header>

        <main>
            <section class="about-us" data-aos="fade-up">
                <div class="container">
                    <h1>About Us</h1>
                    <img src="Image/logo/bakery.jpg" alt="Cake" class="about-image">
                    <div class="content">
                        <h2>Le Gâteau Royal</h2>
                        <p>At Le Gâteau Royal, every cake is a unique story with its own breath and spirit, unmistakable and distinct.</p>
                        <p>We – the artisan bakers – always strive to respect the originality, naturalness, and authenticity of each ingredient. This harmony of individual elements comes together to create a perfectly balanced and delicious cake.</p>
                        <p>So, whenever you crave rustic, sophisticated flavors without compromising on appeal, visit us. There are always many special things waiting for you to discover!</p>
                    </div>
                </div>
            </section>
        </main>

    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <?php include 'footer_client.php'; ?>
</body>

</html>
