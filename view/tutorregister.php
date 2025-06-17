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

<body
    class="bg-[position:top_0px_center] md:bg-[position:left_-400px_center] xl:bg-[position:left_-400px_center]  2xl:bg-[position:left_0px_center] relative min-h-screen bg-cover bg-no-repeat text-white font-sans "
    style="background-image: url('<?= BASE_URL ?>public/img/sabio.png');">

    <section>
        <div class="flex flex-col items-end justify-end mt-0 mb-10  pl-5">

            <div class="xl:pr-56 lg:pr-14 md:pr-7 pr-5">
                <a href="<?= BASE_URL ?>RouteController/index" class="flex justify-center items-center"><img
                        src="<?= BASE_URL ?>public/img/logo.png" alt="logo" class="w-40 mb-8 block" />
                </a>
                <div
                    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-black text-center">
                        Registro De Tutor
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST"
                        action="<?= BASE_URL ?>RegisterController/registertutor">
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm md:text-md xl:text-lg font-medium text-gray-900 dark:text-black">Codigo</label>
                            <input type="text" name="code" id="code"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="tu codigo" required="">
                        </div>
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm md:text-md xl:text-lg font-medium text-gray-900 dark:text-black">Nombre</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="tu nombre" required="">
                        </div>
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm md:text-md xl:text-lg font-medium text-gray-900 dark:text-black">Correo</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="ejemplo@udistrital.edu.co" required="">
                        </div>
                        <label for="areas" class="block text-sm md:text-md xl:text-lg font-medium text-gray-900 dark:text-black">Escoge
                            las areas
                            que dominas</label>
                        <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                            focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                            dark:focus:border-blue-500">
                            <ul>
                                <?php /** @var AreaDTO $area */
                                foreach ($areas as $area) : ?>
                                    <li> <input type="checkbox" name="area[]" value="<?= $area->getCodigo() ?>" />
                                        <?= $area->getNombre() ?> </li>
                                <?php endforeach; ?>
                            </ul>

                        </div>
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm md:text-md xl:text-lg font-medium text-gray-900 dark:text-black">¿Cual es el nombre
                                de tu primera mascota?</label>
                            <input type="text" name="response1" id="response1"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Observación: Escribir ninguno en caso que no aplique" required="">
                            <label class="block mb-2 pt-2 text-sm  font-light text-gray-900 dark:text-black">Escribe
                                tu respuesta para ayudarte a recuperar tu cuenta si es necesario.</label>
                        </div>
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm md:text-md xl:text-lg font-medium text-gray-900 dark:text-black">¿Cual es el nombre
                                de tu abuela?</label>
                            <input type="text" name="response2" id="response2"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Ejemplo: Margarita" required="">
                            <label class="block mb-2 pt-2 text-sm  font-light text-gray-900 dark:text-black">Escribe
                                tu respuesta para ayudarte a recuperar tu cuenta si es necesario.</label>
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm  md:text-md xl:text-lg font-medium text-gray-900 dark:text-black">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="">
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-purple-700 hover:bg-purple-950 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Registrarse</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
     <script src="<?= BASE_URL ?>public/js/notyf.js"></script>
<?php  
    if (isset($_GET['error'])) {
    $errorMessages = [
        1 => 'El tutor no se ha registrado correctamente, por favor intenta de nuevo',
        2 => 'El tutor que intenta registrarse<br> ya existe,por favor intenta con otro<br> correo',
        3 => 'La contraseña debe tener al menos 8 caracteres,<br> una mayúscula, una minúscula, un número y <br>un carácter especial',
        4 => 'El correo ingresado no es válido',
        5 => 'Debes seleccionar al menos un area de tu conocimiento',
       
    ];
    $msg = $errorMessages[$_GET['error']] ?? $errorMessages[1];
    ?>
   <script>
  showErrorRegister(`<?= $msg ?>`, { x: 'right', y: 'top' });
</script>
<?php } ?>
</body>

</html>