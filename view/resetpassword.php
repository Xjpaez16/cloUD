<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- JS de Notyf y css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

</head>

<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat text-white font-sans "
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">

    <div>
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="max-w-[480px] w-full">
                <a href="<?= BASE_URL ?>RouteController/index"><img src="<?= BASE_URL ?>public/img/logo.png" alt="logo"
                        class="w-40 mb-8 mx-auto block" />
                </a>

                <div class="p-6 sm:p-8 rounded-2xl bg-white border border-gray-200 shadow-sm font-sans">
                    <h1 class="text-slate-900 text-center text-3xl font-bold xl:text-4xl">Cambiar Contraseña</h1>
                    <form class="mt-12 space-y-6" action="<?= BASE_URL ?>ResetController/resetPassword" method="POST">
                        <div>
                            <label class="text-slate-900 text-sm font-medium mb-2 block xl:text-xl">Correo</label>
                            <div class="relative flex items-center">
                                <input name="email" type="email" required
                                    class="w-full text-slate-900 text-sm border border-slate-300 px-4 py-3 pr-8 rounded-md outline-blue-600 xl:text-lg"
                                    placeholder="Ingrese su corrreo institucional" />
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-900 text-sm font-medium mb-2 block xl:text-xl">Escoja su
                                rol</label>
                            <div class="relative flex items-center">
                                <select name="rol" id="rol"
                                    class="w-full text-slate-900 text-sm border border-slate-300 px-4 py-3 pr-8 rounded-md outline-blue-600 xl:text-lg">
                                    <option value="estudiante">Estudiante</option>
                                    <option value="tutor">Tutor</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-900 text-sm font-medium mb-2 block xl:text-xl">¿Cual es el nombre
                                de tu primera mascota?
                            </label>
                        </div>
                        <div>
                            <label class="text-slate-900 text-sm font-medium mb-2 block xl:text-xl">Respuesta 1</label>
                            <div class="relative flex items-center">
                                <input name="response1" type="text" required
                                    class="w-full text-slate-900 text-sm border border-slate-300 px-4 py-3 pr-8 rounded-md outline-blue-600 xl:text-lg"
                                    placeholder="Coloca aqui la respuesta a la primer pregunta de seguridad" />
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-900 text-sm font-medium mb-2 block xl:text-xl">¿Cual es el nombre
                                de tu abuela?

                            </label>
                        </div>
                        <div>
                            <label class="text-slate-900 text-sm font-medium mb-2 block xl:text-xl">Respuesta 2</label>
                            <div class="relative flex items-center">
                                <input name="response2" type="text" required
                                    class="w-full text-slate-900 text-sm border border-slate-300 px-4 py-3 pr-8 rounded-md outline-blue-600 xl:text-lg"
                                    placeholder="Coloca aqui la respuesta a la segunda pregunta de seguridad" />
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-900 text-sm font-medium mb-2 block xl:text-xl">Nueva
                                Contraseña</label>
                            <div class="relative flex items-center">
                                <input id="pass" name="password" type="password" required
                                    class="w-full text-slate-900 text-sm border border-slate-300 px-4 py-3 pr-8 rounded-md outline-blue-600 xl:text-lg"
                                    placeholder="Ingrese su contraseña" />
                                <svg id="togglePass" xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb"
                                    class="w-4 h-4 absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                                    <path
                                        d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"
                                        data-original="#000000"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="!mt-12">
                            <button type="submit"
                                class="xl:text-lg w-full py-2 px-4 text-[15px] font-medium tracking-wide rounded-md text-white bg-purple-600 hover:bg-purple-900 focus:outline-none cursor-pointer">
                                Confirmar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>public/js/eye.js"></script>
    <script src="<?= BASE_URL ?>public/js/notyf.js"></script>
    <?php
if (isset($_GET['error'])) {
    $errorMessages = [
        1 => 'Respuestas de seguridad incorrectas',
        2 => 'La contraseña debe tener al menos 8 caracteres,<br> una mayúscula, una minúscula, un número y <br>un carácter especial',
        3 => 'El correo ingresado es invalido',
        
    ];
    $msg = $errorMessages[$_GET['error']] ?? $errorMessages[1];
    ?>
    <script>
      showError('<?= $msg ?>');
    </script>
<?php } ?>
</body>

</html>