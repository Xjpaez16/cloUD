<!--<?php require_once __DIR__ . '/layouts/nav.php'; ?>-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administradores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#5232a8] via-[#803cb9] to-[#b993d6] text-white font-sans flex flex-col items-center justify-center" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat;">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 max-w-3xl w-full mt-16 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-4xl font-extrabold text-[#5232a8] drop-shadow mb-2 md:mb-0">Administradores</h1>
            <a href="<?= BASE_URL ?>LoginController/logout">
                <button class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-700 hover:to-red-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105">
                    Cerrar sesión
                </button>
            </a>
        </div>
        <h2 class="text-2xl font-semibold text-[#803cb9] mb-4">Ver administradores</h2>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full bg-white bg-opacity-80 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-[#5232a8] font-bold">ID</th>
                        <th class="py-3 px-4 text-[#5232a8] font-bold">Nombre</th>
                        <th class="py-3 px-4 text-[#5232a8] font-bold">Correo</th>
                        <th class="py-3 px-4 text-[#5232a8] font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['admins'] as $admin): ?>
                    <tr class="hover:bg-[#f3e8ff] transition">
                        <td class="py-2 px-4 text-center text-[#5232a8]"><?= htmlspecialchars($admin->getId()) ?></td>
                        <td class="py-2 px-4 text-[#5232a8]"><?= htmlspecialchars($admin->getNombre()) ?></td>
                        <td class="py-2 px-4 text-[#5232a8]"><?= htmlspecialchars($admin->getCorreo()) ?></td>
                        <td class="py-2 px-4 flex gap-2 justify-center">
                            <form action="<?= BASE_URL ?>AdminController/delete" method="GET" onsubmit="return confirm('¿Seguro que deseas desactivar este administrador?');">
                                <input type="hidden" name="codigo" value="<?= $admin->getId() ?>">
                                <button type="submit" class="w-28 bg-red-500 hover:bg-red-700 text-white font-semibold px-3 py-2 rounded shadow transition text-base">Desactivar</button>
                            </form>
                            <button type="button" class="w-28 bg-blue-500 hover:bg-blue-700 text-white font-semibold px-3 py-2 rounded shadow transition text-base"
                                onclick="showEdit(<?= $admin->getId() ?>, '<?= htmlspecialchars($admin->getNombre()) ?>', '<?= htmlspecialchars($admin->getCorreo()) ?>')">Editar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <h2 class="text-2xl font-semibold text-[#803cb9] mt-6 mb-4">Agregar nuevo admin</h2>
        <form action="<?= BASE_URL ?>AdminController/create" method="POST" class="bg-white bg-opacity-80 shadow-md rounded-lg p-6 mb-4">
            <div class="mb-4">
                <label for="nombre" class="block text-[#5232a8] font-semibold mb-1">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] focus:outline-none focus:ring-2 focus:ring-[#803cb9] bg-white">
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-[#5232a8] font-semibold mb-1">Correo:</label>
                <input type="email" name="correo" id="correo" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] focus:outline-none focus:ring-2 focus:ring-[#803cb9] bg-white">
            </div>
            <div class="mb-4">
                <label for="contrasena" class="block text-[#5232a8] font-semibold mb-1">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] focus:outline-none focus:ring-2 focus:ring-[#803cb9] bg-white">
            </div>
            <button type="submit" class="bg-gradient-to-r from-[#803cb9] to-[#5232a8] hover:from-[#5232a8] hover:to-[#803cb9] text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105 w-full">Agregar Admin</button>
        </form>
        <!-- Modal para editar admin -->
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
            <form id="editForm" action="<?= BASE_URL ?>AdminController/update" method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
                <input type="hidden" name="codigo" id="editCodigo">
                <div class="mb-4">
                    <label for="editNombre" class="block text-[#5232a8] font-semibold mb-1">Nombre:</label>
                    <input type="text" name="nombre" id="editNombre" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] focus:outline-none focus:ring-2 focus:ring-[#803cb9] bg-white">
                </div>
                <div class="mb-4">
                    <label for="editCorreo" class="block text-[#5232a8] font-semibold mb-1">Correo:</label>
                    <input type="email" name="correo" id="editCorreo" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] focus:outline-none focus:ring-2 focus:ring-[#803cb9] bg-white">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Guardar</button>
                    <button type="button" onclick="closeEdit()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </form>
        </div>
        <script>
            function showEdit(id, nombre, correo) {
                document.getElementById('editCodigo').value = id;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editCorreo').value = correo;
                const modal = document.getElementById('editModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            function closeEdit() {
                const modal = document.getElementById('editModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        </script>
    </div>
</body>
</html>