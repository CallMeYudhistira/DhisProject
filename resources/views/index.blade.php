@extends('layouts.app')
@section('title', 'DhisProject')
@section('content')
    <h1 class="display-5 fw-bold mb-2">DhisLab</h1>

    <p class="lead mt-3 mb-4">
        <span id="typed-text"></span><span class="cursor">|</span>
    </p>

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
@endsection
