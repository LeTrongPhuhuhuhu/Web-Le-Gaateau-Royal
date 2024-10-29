<?php
require 'db.php';
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Gâteau Royal</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
</head>

<body>
    <!-- Include Navbar -->
    <?php include 'navbar_client.php'; ?>

    <!-- Video Section -->
    <div class="video-container" data-aos="fade-up" data-aos-duration="1500">
        <video src="Image/logo/introbae.mp4" autoplay muted loop class="intro-video"></video>
    </div>

    <!-- Our Story Section -->
    <section id="our-story" class="our-story" data-aos="fade-up" data-aos-duration="1500">
        <div class="our-story-container">
            <div class="our-story-text" data-aos="fade-up" data-aos-delay="400">
                <h2>Our Story</h2>
                <p>Le Gâteau Royal is more than a business. it's a cherished family legacy dedicated to the art of crafting exceptional cakes. Rooted in our unwavering commitment to quality and excellence, we have been shaping unforgettable moments for over a decade. Each cake we meticulously create embodies a narrative of tradition, ingenuity, and an unwavering devotion to the finest ingredients.</p>
            </div>
            <div class="our-story-image" data-aos="fade-up" data-aos-delay="600">
                <img src="Image/logo/whit.png" alt="Our Story Image">
            </div>
        </div>
    </section>

    <!-- Bakery Section -->
    <h2 class="section-title" data-aos="fade-up" data-aos-duration="1500">Bakery</h2>

    <section id="bakery" class="bakery" data-aos="fade-up" data-aos-duration="1500">
        <div class="bakery-container">
            <div class="bakery-item" data-aos="fade-up" data-aos-delay="400">
                <a href="product.php?category=1">
                    <img src="Image/logo/bread.jpg" alt="Bread">
                    <h3>Bread</h3>
                </a>
            </div>
            <div class="bakery-item" data-aos="fade-up" data-aos-delay="600">
                <a href="product.php?category=6">
                    <img src="Image/logo/cake.jpg" alt="Cake">
                    <h3>Cake</h3>
                </a>
            </div>
            <div class="bakery-item" data-aos="fade-up" data-aos-delay="800">
                <a href="product.php?category=4">
                    <img src="Image/logo/pastry.jpg" alt="Pastry">
                    <h3>Pastry</h3>
                </a>
            </div>
            <div class="bakery-item" data-aos="fade-up" data-aos-delay="1000">
                <a href="product.php?category=2">
                    <img src="Image/logo/sandwich.jpg" alt="Sandwich">
                    <h3>Sandwich</h3>
                </a>
            </div>
        </div>
    </section>

    <!-- Beverage Section -->
    <h2 class="section-title" data-aos="fade-up" data-aos-duration="1500">Beverage</h2>

    <section id="beverage" class="beverage" data-aos="fade-up" data-aos-duration="1500">
        <div class="beverage-container">
            <div class="beverage-item" data-aos="fade-up" data-aos-delay="400">
                <a href="product.php?category=7">
                    <img src="Image/logo/coffee.jpg" alt="Coffee">
                    <h3>Coffee</h3>
                </a>
            </div>
            <div class="beverage-item" data-aos="fade-up" data-aos-delay="600">
                <a href="product.php?category=8">
                    <img src="Image/logo/tea.jpg" alt="Tea">
                    <h3>Tea</h3>
                </a>
            </div>
            <div class="beverage-item" data-aos="fade-up" data-aos-delay="800">
                <a href="product.php?category=9">
                    <img src="Image/logo/smoothie.jpg" alt="Juice">
                    <h3>Blended</h3>
                </a>
            </div>
           
        </div>
    </section>

    <!-- Include Footer -->
   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <?php include 'footer_client.php'; ?>
</body>

</html>
