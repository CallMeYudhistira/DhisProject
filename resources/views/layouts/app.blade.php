<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            font-family: 'Montserrat', sans-serif;
        }

        .hero {
            min-height: 100vh;
            color: black;
            padding: 0 15px;
        }

        .hero div h1 {
            font-size: 2.7rem;
            /* Tambahkan baris di bawah ini */
            animation: floating 3s ease-in-out infinite;
        }

        .hero div h4 {
            font-size: 1.7rem;
            font-weight: 500;
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

    @yield('content')

</body>

</html>
