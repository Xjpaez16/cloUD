<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>cloUD - Panel Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/home.css">
    <!-- Flaticon UIcons -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
</head>

<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat text-white font-sans"
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">

    <!-- Contenido principal -->
    <div class="relative z-10">
        <?php require_once __DIR__ . '/layouts/nav.php'; ?>
        <!-- Mensaje principal -->
        <main class="text-center py-16 px-4">
            <div class="flex flex-col">
                <h1 class="text-4xl xl:text-5xl lg:text-4xl md:text-3xl font-bold mb-2">Panel de Administrador</h1>
                <p class="text-lg xl:text-xl lg:text-lg md:text-base text-gray-300">Administra la plataforma</p>
                <br>
                <br>
                <div class="grid grid-cols-2 gap-2 xl:w-[500px] lg:w-[500px] md:w-[500px] mx-auto">
                    <a href="#">
                        <div class="bg-[#5232a8] p-4 w-60 h-56 overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300 flex flex-col items-center justify-center">
                            <i class="fi fi-rr-users text-7xl mb-2 text-white"></i>
                            <span class="mt-2 font-bold text-xl">Gestionar Tutores</span>
                            <p class="text-gray-200 text-sm mt-1">Administra los tutores registrados en la plataforma.</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="bg-[#5232a8] p-4 w-60 h-56 overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300 flex flex-col items-center justify-center">
                            <i class="fi fi-rr-user text-7xl mb-2 text-white"></i>
                            <span class="mt-2 font-bold text-xl">Gestionar Usuarios</span>
                            <p class="text-gray-200 text-sm mt-1">Administra los usuarios de la plataforma.</p>
                        </div>
                    </a>
                    <a href="#">
                        <div class="bg-[#5232a8] p-4 w-60 h-56 overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300 flex flex-col items-center justify-center">
                            <i class="fi fi-rr-file-chart-line text-7xl mb-2 text-white"></i>
                            <span class="mt-2 font-bold text-xl">Reportes</span>
                            <p class="text-gray-200 text-sm mt-1">Visualiza y genera reportes de actividad.</p>
                        </div>
                    </a>
                    <a href="<?= BASE_URL ?>LoginController/logout">
                        <div class="bg-[#5232a8] p-4 w-60 h-56 overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300 flex flex-col items-center justify-center">
                            <i class="fi fi-rr-exit text-7xl mb-2 text-white"></i>
                            <span class="mt-2 font-bold text-xl">Cerrar Sesión</span>
                            <p class="text-gray-200 text-sm mt-1">Salir del panel de administrador.</p>
                        </div>
                    </a>
                </div>
            </div>
        </main>
        <br>
        <div class="text-2xl">
            <p class="font-bold text-right p-9 ">FAQ</p>
        </div>
    </div>

</body>

</html>