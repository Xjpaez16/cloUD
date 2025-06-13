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



<body class="relative min-h-screen bg-cover bg-no-repeatbg-bottom bg-no-repeat text-white font-sans "
    style="background-image: url('<?= BASE_URL ?>public/img/udfondo.jpg');">

    <!-- Contenido principal -->
    <div class="relative z-10">
        <?php require_once __DIR__ . '/layouts/nav.php'; ?>
        <!-- Mensaje principal -->
        <main class="text-center py-16 px-4">
            <h1 class="text-3xl lg:text-6xl md:text-5xl  font-bold mb-20 font-sans md:font-sans pb-20 mt-20">
                Aprende y convive con los compañeros de la UD
            </h1>

            <!-- Íconos -->
            <div class="ease-out duration-300 grid grid-cols-1 sm:grid-cols-3 gap-5 mb-80 font-bold">
                <div class="flex flex-col items-center">
                    <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] pb-2">Gestiona
                        Materiales<br>Académicos</p>
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/materials.png"
                            class="w-40 h-48 sm:w-40 sm:h-48 md:w-48 md:h-56 lg:w-60 lg:h-64 xl:w-71 xl:h-80 mb-2 transition-transform duration-300 hover:scale-95"
                            alt="Materiales">
                    </a>
                </div>
                <div class="flex flex-col items-center">
                    <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] pb-2">Gestiona Tu<br> Usuario</p>
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/users.png"
                            class="w-40 h-48 sm:w-40 sm:h-48 md:w-48 md:h-56 lg:w-60 lg:h-64 xl:w-71 xl:h-80 mb-2 transition-transform duration-300 hover:scale-95"
                            alt="Usuario">
                    </a>
                </div>
                <div class="flex flex-col items-center">
                    <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] pb-8">Agenda Tutorías</p>
                    <a href="#">
                        <img src="<?= BASE_URL ?>public/img/calendar.png"
                            class="w-40 h-48 sm:w-40 sm:h-48 md:w-48 md:h-56 lg:w-60 lg:h-64 xl:w-71 xl:h-80 mb-2 transition-transform duration-300 hover:scale-95"
                            alt="Tutorías">
                    </a>
                </div>
            </div>

            <!-- Título de secciones -->
            <h2 class="text-4xl font-semibold mb-6">
                ¿En qué área necesitas ayuda?
            </h2>
            <br>

            <!-- Tarjetas de áreas -->
             
            <div class="font-bold font-sans grid grid-cols-1 xl:grid-cols-7 sm:grid-cols-3 md:grid-cols-3 gap-6 px-6 ">
                <div class="card-container w-full h-60 sm:h-62 md:h-70 xl:h-80">
                    <div class="card-inner relative" >
                        <div
                            class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center  transition-transform card-front flex flex-col items-center justify-center absolute inset-0">
                            <a href="#">
                                <img src="<?= BASE_URL ?>public/img/database.png" class="w-32 h-40 mx-auto mb-2"
                                    alt="Bases de Datos">
                            </a>
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Bases de Datos
                            </p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center transition-transform card-back flex flex-col items-center justify-center absolute inset-0" style="transform: rotateY(180deg);">
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Explicacion BD</p>
                        </div>
                    </div>
                </div>
               <div class="card-container w-full h-60 sm:h-62 md:h-70 xl:h-80">
                    <div class="card-inner relative" >
                        <div
                            class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center  transition-transform card-front flex flex-col items-center justify-center absolute inset-0">
                            <a href="#">
                                <img src="<?= BASE_URL ?>public/img/math.png" class="w-32 h-40 mx-auto mb-2"
                                    alt="Bases de Datos">
                            </a>
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Matemáticas
                            </p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center transition-transform card-back flex flex-col items-center justify-center absolute inset-0" style="transform: rotateY(180deg);">
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Explicacion Matemáticas</p>
                        </div>
                    </div>
                </div>
                <div class="card-container w-full h-60 sm:h-62 md:h-70 xl:h-80">
                    <div class="card-inner relative" >
                        <div
                            class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center  transition-transform card-front flex flex-col items-center justify-center absolute inset-0">
                            <a href="#">
                                <img src="<?= BASE_URL ?>public/img/programming2.png" class="w-32 h-40 mx-auto mb-2"
                                    alt="Bases de Datos">
                            </a>
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Programación Practica
                            </p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center transition-transform card-back flex flex-col items-center justify-center absolute inset-0" style="transform: rotateY(180deg);">
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Explicacion Programación</p>
                        </div>
                    </div>
                </div>
                <div class="card-container w-full h-60 sm:h-62 md:h-70 xl:h-80">
                    <div class="card-inner relative" >
                        <div
                            class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center  transition-transform card-front flex flex-col items-center justify-center absolute inset-0">
                            <a href="#">
                                <img src="<?= BASE_URL ?>public/img/physic.png" class="w-32 h-40 mx-auto mb-2"
                                    alt="Bases de Datos">
                            </a>
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Fisica
                            </p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center transition-transform card-back flex flex-col items-center justify-center absolute inset-0" style="transform: rotateY(180deg);">
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Explicacion Fisica</p>
                        </div>
                    </div>
                </div>
                <div class="card-container w-full h-60 sm:h-62 md:h-70 xl:h-80">
                    <div class="card-inner relative" >
                        <div
                            class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center  transition-transform card-front flex flex-col items-center justify-center absolute inset-0">
                            <a href="#">
                                <img src="<?= BASE_URL ?>public/img/programming2.png" class="w-32 h-40 mx-auto mb-2"
                                    alt="Bases de Datos">
                            </a>
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Teoria
                            </p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center transition-transform card-back flex flex-col items-center justify-center absolute inset-0" style="transform: rotateY(180deg);">
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Explicacion de Teoria</p>
                        </div>
                    </div>
                </div>
                <div class="card-container w-full h-60 sm:h-62 md:h-70 xl:h-80">
                    <div class="card-inner relative" >
                        <div
                            class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center  transition-transform card-front flex flex-col items-center justify-center absolute inset-0">
                            <a href="#">
                                <img src="<?= BASE_URL ?>public/img/programming2.png" class="w-32 h-40 mx-auto mb-2"
                                    alt="Bases de Datos">
                            </a>
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Teoria
                            </p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center transition-transform card-back flex flex-col items-center justify-center absolute inset-0" style="transform: rotateY(180deg);">
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Explicacion de Teoria</p>
                        </div>
                    </div>
                </div>
                <div class="card-container w-full h-60 sm:h-62 md:h-70 xl:h-80">
                    <div class="card-inner relative" >
                        <div
                            class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center  transition-transform card-front flex flex-col items-center justify-center absolute inset-0">
                            <a href="#">
                                <img src="<?= BASE_URL ?>public/img/programming2.png" class="w-32 h-40 mx-auto mb-2"
                                    alt="Bases de Datos">
                            </a>
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Teoria
                            </p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm p-4 rounded-lg text-center transition-transform card-back flex flex-col items-center justify-center absolute inset-0" style="transform: rotateY(180deg);">
                            <p class="text-[20px] xl:text-[25px] lg:text-[20px] md:text-[20px] sm:text-[30px]">Explicacion de Teoria</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="<?= BASE_URL ?>public/js/flip.js"></script>
</body>

</html>