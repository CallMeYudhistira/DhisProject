<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ url('favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background-color: #fcfcfc;
            color: #333;
        }

        .hero {
            min-height: 100vh;
            color: black;
            padding: 0 15px;
        }

        .hero div h1 {
            font-size: 2.7rem;
            animation: floating 3s ease-in-out infinite;
        }

        .hero div h4 {
            font-size: 1.7rem;
            font-weight: 500;
        }

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
            font-size: clamp(1rem, 3vw, 1.3rem);
            max-width: 600px;
            margin: 0 auto;
        }

        .cursor {
            display: inline-block;
            margin-left: 4px;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        /* Responsive spacing fixes */
        @media (max-width: 576px) {
            .py-5 {
                padding-top: 3rem !important;
                padding-bottom: 3rem !important;
            }

            .px-4 {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }
        }
    </style>
</head>

<body id="page-body">

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
