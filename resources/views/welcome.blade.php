<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slider</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #000;
        }
        .slider {
            width: 80%;
            max-width: 800px;
            position: relative;
            overflow: hidden;
        }
        .slides {
            display: flex;
            width: 300%; /* Adjust according to the number of images */
            animation: slide 15s linear infinite; /* Adjust duration for speed */
        }
        .slides img {
            width: 100%;
            height: auto;
            display: block;
        }
        @keyframes slide {
            0% { transform: translateX(0); }
            33% { transform: translateX(-100%); } /* Adjust percentage based on number of images */
            66% { transform: translateX(-200%); } /* Adjust percentage based on number of images */
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="slider">
        <div class="slides">
            <img src="image1.jpg" alt="Image 1">
            <img src="image2.jpg" alt="Image 2">
            <img src="image3.jpg" alt="Image 3">
        </div>
    </div>
    <script>
        const slider = document.querySelector('.slider');

        const stopSlider = () => {
            const slides = slider.querySelector('.slides');
            slides.style.animationPlayState = 'paused';
        };

        const startSlider = () => {
            const slides = slider.querySelector('.slides');
            slides.style.animationPlayState = 'running';
        };

        slider.addEventListener('mouseover', stopSlider);
        slider.addEventListener('mouseout', startSlider);
    </script>
</body>
</html>
