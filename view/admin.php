<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>cloUD - Panel Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/notyf.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-[#5232a8] via-[#803cb9] to-[#b993d6] text-white font-sans flex flex-col items-center justify-center" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat;">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-10 max-w-xl w-full mt-16 mb-8">
        <h1 class="text-4xl font-extrabold text-center text-[#5232a8] mb-2 drop-shadow">Panel de Administrador</h1>
        <p class="text-lg text-center text-gray-700 mb-8">Gestiona los administradores</p>
        <div class="flex flex-col md:flex-row gap-6 justify-center mb-8">
            <a href="<?= BASE_URL ?>AdminController/index" class="flex-1">
                <button class="w-full bg-gradient-to-r from-[#803cb9] to-[#5232a8] hover:from-[#5232a8] hover:to-[#803cb9] text-white font-bold py-6 px-4 rounded-xl shadow-lg text-xl transition-all duration-300 transform hover:scale-105">
                    Ver Administradores
                </button>
            </a>
            <a href="<?= BASE_URL ?>StudentAdminController/index" class="flex-1">
                <button class="w-full bg-gradient-to-r from-[#32a852] to-[#3cb980] hover:from-[#3cb980] hover:to-[#32a852] text-white font-bold py-6 px-4 rounded-xl shadow-lg text-xl transition-all duration-300 transform hover:scale-105">
                    Ver Estudiantes
                </button>
            </a>
            <a href="<?= BASE_URL ?>LoginController/logout" class="flex-1">
                <button class="w-full bg-gradient-to-r from-red-500 to-red-700 hover:from-red-700 hover:to-red-500 text-white font-bold py-6 px-4 rounded-xl shadow-lg text-xl transition-all duration-300 transform hover:scale-105">
                    <svg class="inline-block w-7 h-7 mr-2 -mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1"/></svg>
                    Cerrar sesión
                </button>
            </a>
        </div>
        <div class="flex justify-end">
            <a href="<?= BASE_URL ?>RouteController/viewFAQ" class="text-[#803cb9] font-semibold hover:underline text-lg flex items-center">
                <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 10h.01M12 14v.01M12 10v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/></svg>
                FAQ
            </a>
        </div>
    </div>
     <?php if (isset($_GET['session']) && $_GET['session'] === 'success') { ?>
        <script>
            const notyf = new Notyf({
            duration: 1000,
            className: 'rounded-lg text-white text-[11px] sm:text-sm md:text-base px-2 sm:px-4 py-1.5 sm:py-2 shadow-md font-sans font-semibold max-w-[95vw] w-fit min-w-[120px] min-h-[36px] sm:min-h-[44px]',
            position: {
                x: 'right',
                y: 'top',
            },
            types: [
                {
                type: 'sucess',
                background: '#76dd77',
                icon: {
                    className: 'material-icons',
                    tagName: 'i',
                    text: 'w'
                }
                },
                {
                type: 'success',
                background: '#76dd77',
                duration: 2000,
                dismissible: true
                }
            ]
            });

                notyf.open({
                    type: 'success',
                    message: '¡Bienvenido al panel de administrador!'
                });
        </script>
    <?php }?>
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>