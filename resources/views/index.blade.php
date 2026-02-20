<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DhisProject</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap');

        * {
            font-family: 'Figtree', sans-serif;
        }

        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #ffffff 30%, #d8d8d8);
            color: black;
            padding: 0 15px;
        }

        .hero h1 {
            font-size: 2.7rem;
            /* Tambahkan baris di bawah ini */
            animation: floating 3s ease-in-out infinite;
        }

        /* Definisi animasi melayang */
        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .hero p {
            font-size: 1.3rem;
            max-width: 600px;
            margin: 0 auto;
            white-space: nowrap;
            overflow: hidden;
        }

        .cursor {
            display: inline-block;
            margin-left: 4px;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <section id="home" class="hero d-flex align-items-center text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">DhisLab</h1>

            <p class="lead mt-3 mb-4">
                <span id="typed-text"></span><span class="cursor">|</span>
            </p>
        </div>
    </section>

    <script>
        const texts = [
            "Hidup Jokowi.",
            "Hidup Prabowo.",
            "Jaya Indonesiaku.",
            "https://github.com/CallMeYudhistira/"
        ];

        let textIndex = 0;
        let charIndex = 0;
        let isDeleting = false;

        const typedText = document.getElementById("typed-text");

        function typeEffect() {
            const currentText = texts[textIndex];

            if (!isDeleting) {
                typedText.textContent = currentText.substring(0, charIndex + 1);
                charIndex++;

                if (charIndex === currentText.length) {
                    setTimeout(() => isDeleting = true, 1300);
                }
            } else {
                typedText.textContent = currentText.substring(0, charIndex - 1);
                charIndex--;

                if (charIndex === 0) {
                    isDeleting = false;
                    textIndex = (textIndex + 1) % texts.length;
                }
            }

            const speed = isDeleting ? 40 : 60;
            setTimeout(typeEffect, speed);
        }

        typeEffect();
    </script>

</body>

</html>
