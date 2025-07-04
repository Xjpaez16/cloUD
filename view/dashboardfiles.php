<?php
require_once(__DIR__ . '/../app/controllers/models/DTO/EstudianteDTO.php');
require_once(__DIR__ . '/../app/controllers/models/DTO/TutorDTO.php');
session_start();

if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], ['estudiante', 'tutor'])) {
    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
    exit();
}
require_once __DIR__ . '/layouts/nav.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>


    <meta charset="UTF-8">
    <title>cloUD - Files</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/home.css">
    <!-- notyf vía CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/notyf.css">
</head>



<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat text-white font-sans "
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">

    <!-- Contenido principal -->
    <div class="relative z-10">

        <!-- Mensaje principal -->
        <main class="text-center py-16 px-4">
            <div class="flex flex-col">
                <h1 class="text-4xl xl:text-5xl lg:text-4xl md:text-3xl font-bold mb-2">Panel de Archivos</h1>
                <p class="text-lg xl:text-xl lg:text-lg md:text-base text-gray-300">Administra tus archivo</p>
                <br>
                <br>
                <div
                    class="grid grid-cols-1 md:grid-cols-3  lg:grid-cols-3 xl:grid-cols-3 gap-8 xl:w-[800px] lg:w-[500px] md:w-[500px] mx-auto justify-center">
                    <a href="<?= BASE_URL ?>index.php?url=RouteController/uploadfiles">
                        <div
                            class="bg-[#5232a8] p-4 w-26 h-[250px] xl:w-60 xl:h-56   overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300">
                            <img class="w-full h-full object-cover rounded-lg"
                                src="<?= BASE_URL ?>public/img/updateFiles.png" alt="">
                        </div>
                    </a>
                    <a href="<?= BASE_URL ?>index.php?url=RouteController/viewmyfilesStudent">
                        <div
                            class="bg-[#5232a8] p-4 w-26 h-[250px] xl:w-60 xl:h-56  overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300">
                            <img class="w-full h-full object-cover rounded-lg"
                                src="<?= BASE_URL ?>public/img/viewfiles.png" alt="">
                        </div>
                    </a>
                    <a href="<?= BASE_URL ?>index.php?url=RouteController/viewallfiles">
                        <div
                            class="bg-[#5232a8] p-4 w-26 h-[250px] xl:w-60 xl:h-56 overflow-hidden rounded-lg border border-white hover:scale-90 transition-transform duration-300">
                            <img class="w-full h-full object-cover rounded-lg"
                                src="<?= BASE_URL ?>public/img/viewallfiles.png" alt="">
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
    <script src="<?= BASE_URL ?>public/js/notyf.js"></script>
    <?php
    if (isset($_GET['success'])) {
        $Messages = [
            1 => 'Archivo subido correctamente',

        ];
        $msg = $Messages[$_GET['success']] ?? $Messages[1];
    ?>
        <script>
            showSuccessPosition(`<?= $msg ?>`, {
                x: 'right',
                y: 'top'
            });
        </script>
    <?php } ?>
</body>

</html>