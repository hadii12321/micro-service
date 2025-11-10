<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Simpeg Universitas Nurul Jadid</title>
    <meta name="description"
          content="Sistem kepegawaian Universitas Nurul Jadid - Akses semua layanan digital dengan satu akun">
    <meta name="author" content="Universitas Nurul Jadid">
    <meta name="publisher" content="Pusat Data & Sistem Informasi Universitas Nurul Jadid">
    <meta name="language" content="Indonesian">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noodp, noydir, nocache, notranslate">
    <meta name="googlebot" content="noindex, nofollow, noarchive, nosnippet, notranslate">
    <meta name="bingbot" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="slurp" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="duckduckbot" content="noindex, nofollow, noarchive, nosnippet">
    <link rel="icon" href="{{ asset('assets/media/logos/favicon.ico') }}" type="image/x-icon">
    <link rel="canonical" href="https://Simpeg.unuja.ac.id/">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1rem;
        }

        .container {
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            animation: fadeIn 1s ease-in-out;
            max-width: 90%;
            border-radius: 10px;
        }

        .error-code {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.8rem;
            animation: bounce 5s infinite;
        }

        .error-message {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .home-btn {
            background: linear-gradient(135deg, #6171ff 0%, #2b4bff 100%);
            border: none;
            color: #ffffff;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-size: 0.9rem;
            box-shadow: 0 3px 10px rgba(43, 93, 255, 0.3);
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .home-btn:hover {
            box-shadow: 0 5px 15px rgba(64, 43, 255, 0.5);
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-15px);
            }

            60% {
                transform: translateY(-8px);
            }
        }

        @media (max-width: 600px) {
            .container {
                padding: 1rem;
                max-width: 95%;
            }

            .error-code {
                font-size: 1.8rem;
            }

            .error-message {
                font-size: 0.9rem;
            }

            .home-btn {
                padding: 0.5rem 1.2rem;
                font-size: 0.8rem;
            }
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            font-size: 0.8rem;
            padding: 0.5rem;
        }
    </style>
</head>

<body style="background-color: #f1f4f8; background-image: linear-gradient(to right, rgba(206,206,206,0.31) 1px, transparent 1px), linear-gradient(to bottom, rgba(206,206,206,0.31) 1px, transparent 1px); background-size: 25px 25px; position: relative;">
<div class="container">
    <div class="error-code" id="error-code">@yield('code') - @yield('title')</div>
    <div class="error-message" id="error-message">@yield('message')</div>
    <a href="/" class="home-btn">Kembali ke Beranda</a>
</div>
</body>

</html>
