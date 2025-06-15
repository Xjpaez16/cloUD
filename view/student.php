<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>cloUD - Página Principal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/home.css">
</head>



<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat text-white font-sans "
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">

    <!-- Contenido principal -->
    <div class="relative z-10">
        <?php require_once __DIR__ . '/layouts/nav.php'; ?>
        <!-- Mensaje principal -->
        <main class="text-center py-16 px-4">
            <div class="flex flex-col" >
                <h1 class="text-4xl xl:text-5xl lg:text-4xl md:text-3xl font-bold mb-2">Panel de Estudiante</h1>
                <p class="text-lg xl:text-xl lg:text-lg md:text-base text-gray-300">Administra tus tutorías y perfil</p>
                <br>
                <br>
                <div class="grid grid-cols-2 gap-2 xl:w-[500px] lg:w-[500px] md:w-[500px] mx-auto">
                    <a href="#">
                        <div class="bg-[#5232a8] p-4 w-60 h-56 overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300">
                            <img class="w-full h-full object-cover rounded-lg" src="<?= BASE_URL ?>public/img/tuto.png" alt="">
                        </div>
                    </a>
                    <a href="#">
                    <div class="bg-[#5232a8] p-4 w-60 h-56 overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300">
                        <img class="w-full h-full object-cover rounded-lg" src="<?= BASE_URL ?>public/img/search.png" alt="">
                    </div>
                    </a>
                    <a href="<?= BASE_URL ?>index.php?url=RouteController/editStudent">
                    <div class="bg-[#5232a8] p-4 w-60 h-56 overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300">
                        <img class="w-full h-full object-cover rounded-lg" src="<?= BASE_URL ?>public/img/edit.png" alt="">
                    </div>
                    </a>
                    <a href="<?= BASE_URL ?>LoginController/logout">
                    <div class="bg-[#5232a8] p-4 w-60 h-56 overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300">
                        <img class="w-full h-full object-cover rounded-lg" src="<?= BASE_URL ?>public/img/close.png" alt="">
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