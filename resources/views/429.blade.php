@extends('layouts.app')
@section('title', '429 - Too Many Request')

@section('content')
    <section class="hero d-flex align-items-center justify-content-center text-center">
        <div class="container">
            <h4 class="display-5 mb-2">429, Too many request... :(</h4>
            <p>
                Wait until... <span id="countdown" class="fw-bold">{{ $seconds }}</span> seconds.
            </p>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let seconds = {{ $seconds }};
            const countdownElement = document.getElementById("countdown");

            const interval = setInterval(function () {
                seconds--;

                if (seconds <= 0) {
                    clearInterval(interval);
                    countdownElement.innerText = 0;

                    // Reload halaman setelah waktu habis
                    window.location.reload();
                } else {
                    countdownElement.innerText = seconds;
                }
            }, 1000);
        });
    </script>
@endsection
