@extends('layouts.app')
@section('title', 'DhisProject - Portfolio')
@section('content')

    <nav class="navbar fixed-top transition-navbar" id="mainNavbar">
        <div class="container">
            <div class="ms-auto d-flex align-items-center justify-content-center">
                <a href="https://github.com/CallMeYudhistira" target="_blank"
                    class="nav-link px-2 px-sm-3 fs-4 transition-hover">
                    <i class="fa-brands fa-github text-dark"></i>
                </a>
                <a href="https://wa.me/6281316560366" target="_blank" class="nav-link px-2 px-sm-3 fs-4 transition-hover">
                    <i class="fa-brands fa-whatsapp text-dark"></i>
                </a>
                <a href="https://www.linkedin.com/in/yudhis-tira-063b95382/" target="_blank"
                    class="nav-link px-2 px-sm-3 fs-4 transition-hover">
                    <i class="fa-brands fa-linkedin text-dark"></i>
                </a>
                <a href="mailto:tiray9272@gmail.com" target="_blank" class="nav-link px-2 px-sm-3 fs-4 transition-hover">
                    <i class="fa-regular fa-envelope text-dark"></i>
                </a>
                <a href="https://www.instagram.com/callmeudiss" target="_blank"
                    class="nav-link px-2 px-sm-3 fs-4 transition-hover">
                    <i class="fa-brands fa-instagram text-dark"></i>
                </a>
                <a href="https://www.youtube.com/@callmeyudhistira9805" target="_blank"
                    class="nav-link px-2 px-sm-3 fs-4 transition-hover">
                    <i class="fa-brands fa-youtube text-dark"></i>
                </a>
            </div>
        </div>
    </nav>

    <section id="home" class="hero d-flex align-items-center text-center min-vh-100 bg-light">
        <div class="container px-4">
            <h1 class="display-2 fw-bolder mb-4 tracking-tight">DhisLab</h1>
            <p class="fs-4 text-secondary mb-4">
                <span id="typed-text"></span><span class="cursor">|</span>
            </p>
            <a href="#portfolio" class="btn-dark rounded-pill transition-hover mt-4 btn btn-lg rounded-pill px-4">
                View My Work <i class="fa-solid fa-arrow-down ms-2"></i>
            </a>
        </div>
    </section>

    <div id="portfolio">
        @forelse($projects as $project)
            <section
                class="project-section min-vh-100 d-flex align-items-center {{ $loop->even ? 'bg-light' : 'bg-white' }} py-5">
                <div class="container px-3">
                    <div class="row align-items-center {{ $loop->even ? 'flex-row-reverse' : '' }} g-4 g-lg-5">
                        <div class="col-12 col-lg-6">
                            <div class="shadow-lg rounded-4 overflow-hidden transition-hover" style="aspect-ratio: 16 / 9;">
                                @if ($project->preview)
                                    <img src="{{ url($project->preview) }}" class="w-100 h-100" alt="{{ $project->title }}"
                                        style="object-fit: cover;">
                                @else
                                    <div
                                        class="bg-secondary d-flex align-items-center justify-content-center text-white w-100 h-100">
                                        <i class="fa-regular fa-image fs-1 opacity-25"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="project-info {{ $loop->even ? 'pe-lg-5' : 'ps-lg-5' }} text-center text-lg-start">
                                <span class="badge bg-dark mb-3 px-3 py-2 rounded-pill">0{{ $loop->iteration }} /
                                    Project</span>
                                <h2 class="display-4 fw-bold mb-4">{{ $project->title }}</h2>
                                <p class="lead text-muted mb-4" style="line-height: 1.8;">
                                    {{ $project->description }}
                                </p>
                                @if ($project->url)
                                    <a class="btn btn-outline-dark btn-lg rounded-pill px-4" href="{{ $project->url }}"
                                        target="_blank">
                                        Live Preview <i class="fa-solid fa-up-right-from-square ms-2 small"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        @empty
            <section class="min-vh-100 d-flex align-items-center justify-content-center bg-light text-center">
                <div class="container px-4">
                    <i class="fa-solid fa-box-open fs-1 text-muted mb-4 opacity-25"></i>
                    <h2 class="fw-bold mb-3">No projects yet</h2>
                    <p class="text-muted lead mb-4">The showcase is currently empty.</p>
                </div>
            </section>
        @endforelse
    </div>

    <style>
        .transition-navbar {
            padding: 25px 0;
            transition: all 0.4s ease;
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            padding: 12px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        html {
            scroll-behavior: smooth;
        }

        .tracking-tight {
            letter-spacing: -0.05em;
        }

        .transition-hover {
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .transition-hover:hover {
            transform: translateY(-10px);
        }
    </style>

    <script>
        const texts = [
            "Hello World.",
            "Aku Yudis, Kamu Apa?",
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
                if (charIndex === currentText.length) setTimeout(() => isDeleting = true, 1000);
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
        document.addEventListener('DOMContentLoaded', () => {
            typeEffect();
            const navbar = document.getElementById('mainNavbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) navbar.classList.add('navbar-scrolled');
                else navbar.classList.remove('navbar-scrolled');
            });
        });
    </script>
@endsection
