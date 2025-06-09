<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>cloUD - Página Principal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Hand+Precursive&family=Montserrat:wght@400;700&display=swap"
        rel="stylesheet">



</head>

<body class="relative min-h-screen bg-cover bg-center bg-no-repeat text-white"
    style="background-image: url('<?= BASE_URL ?>public/img/udfondo.jpg'); background-position: center -200px;">

    <!-- Capa morada translúcida -->
    <div class="absolute inset-0 bg-purple-900/70 z-0"></div>

    <!-- Contenido principal -->
    <div class="relative z-10">
        <?php require_once __DIR__ . '/layouts/header.php'; ?>
        <!-- Mensaje principal -->
        <main class="text-center py-16 px-4">
            <h1 class="lg:text-6xl text-4xl sm:text-5xl font-bold mb-12 font-sans md:font-sans">
                Aprende y convive con los compañeros de la UD
            </h1>

            <!-- Íconos -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-16">
                <div class="flex flex-col items-center">
                    <p class="font-sans-serif md:font-sans-serif">Gestiona Materiales Académicos</p>
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/materials.png" class="w-40 h-48 mb-2" alt="Materiales">
                    </a>
                </div>
                <div class="flex flex-col items-center">
                    <p>Gestiona Tu Usuario</p>
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/users.png" class="w-40 h-48 mb-2" alt="Usuario">
                    </a>
                </div>
                <div class="flex flex-col items-center">
                    <p>Agenda Tutorías</p>
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/calendar.png" class="w-40 h-48 mb-2" alt="Tutorías">
                    </a>
                </div>
            </div>

            <!-- Título de secciones -->
            <h2 class="text-2xl font-semibold mb-6">
                ¿En qué área necesitas ayuda?
            </h2>

            <!-- Tarjetas de áreas -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6 px-6">
                <div
                    class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center hover:scale-105 transition-transform">
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/database.png" class="w-32 h-40 mx-auto mb-2"
                            alt="Bases de Datos">
                    </a>
                    <p>Bases de Datos</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center hover:scale-105 transition-transform">
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/math.png" class="w-32 h-40 mx-auto mb-2" alt="Matemáticas">
                    </a>
                    <p>Matemáticas</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center hover:scale-105 transition-transform">
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/programming.png" class="w-32 h-40 mx-auto mb-2"
                            alt="Programación Teórica">
                    </a>
                    <p>Programación Teórica</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center hover:scale-105 transition-transform">
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/physic.png" class="w-32 h-40 mx-auto mb-2" alt="Física">
                    </a>
                    <p>Física</p>
                </div>
                <div
                    class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center hover:scale-105 transition-transform">
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/programming2.png" class="w-32 h-40 mx-auto mb-2"
                            alt="Programación Práctica">
                    </a>
                    <p>Programación Práctica</p>
                </div>
            </div>
        </main>
    </div>
</body>

</html>