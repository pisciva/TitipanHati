<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TitipanHati')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="icon" href="/images/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="">
    @yield('content')

    @if(session('success'))
        <div id="toast-success"
            class="fixed bottom-5 right-5 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">

            <i class="fa-solid fa-circle-check text-white"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>

        <script>

            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.classList.add('opacity-0', 'transition', 'duration-5000');
                    setTimeout(() => toast.remove(), 5000);
                }
            }, 3000);
        </script>

        <style>
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fade-in 0.4s ease-out;
            }
        </style>
    @endif
</body>

</html>