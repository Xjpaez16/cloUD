<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Materias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#32a8a8] via-[#3c80b9] to-[#b993d6] text-white font-sans flex flex-col items-center justify-center" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat;">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 max-w-4xl w-full mt-16 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-4xl font-extrabold text-[#3c80b9]">Materias</h1>
            <a href="<?= BASE_URL ?>RouteController/admin">
                <button class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-700 hover:to-purple-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105">Volver</button>
            </a>
        </div>

        <div class="pb-4">
            <input type="search" id="buscarMateria" class="block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50" placeholder="Buscar por ID o nombre de materia..." />
        </div>

        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white bg-opacity-80 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">ID</th>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Nombre Materia</th>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['materias'] as $mat): ?>
                    <tr class="materia-row">
                        <td class="py-2 px-4 text-center text-[#3c80b9]"><?= htmlspecialchars($mat->getId()) ?></td>
                        <td class="py-2 px-4 text-[#3c80b9] materia-nombre"><?= htmlspecialchars($mat->getNom_materia()) ?></td>
                        <td class="py-2 px-4 text-center">
                            <button onclick="showEditMateria('<?= $mat->getId() ?>', '<?= htmlspecialchars($mat->getNom_materia()) ?>')" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">Editar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-semibold text-[#32a8a8] mb-4">Agregar nueva materia</h2>
        <form action="<?= BASE_URL ?>MateriaAdminController/create" method="POST" class="bg-white bg-opacity-80 shadow-md rounded-lg p-6 mb-6">
            <div class="mb-4">
                <label for="id" class="block text-[#3c80b9] font-semibold mb-1">ID:</label>
                <input type="number" name="id" id="id" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9]">
            </div>
            <div class="mb-4">
                <label for="nombre_materia" class="block text-[#3c80b9] font-semibold mb-1">Nombre de la Materia:</label>
                <input type="text" name="nombre_materia" id="nombre_materia" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9]">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-[#32a8a8] to-[#3c80b9] hover:from-[#3c80b9] hover:to-[#32a8a8] text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300">Agregar Materia</button>
        </form>

        <!-- Modal de edición -->
        <div id="editModalMateria" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center hidden z-50">
            <form action="<?= BASE_URL ?>MateriaAdminController/update" method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
                <input type="hidden" name="id_actual" id="editIdActualMateria">
                <div class="mb-4">
                    <label for="editIdMateria" class="block text-[#3c80b9] font-semibold mb-1">ID:</label>
                    <input type="number" name="id" id="editIdMateria" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9]">
                </div>
                <div class="mb-4">
                    <label for="editNombreMateria" class="block text-[#3c80b9] font-semibold mb-1">Nombre:</label>
                    <input type="text" name="nombre_materia" id="editNombreMateria" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9]">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
                    <button type="button" onclick="closeEditMateria()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </form>
        </div>

        <script>
            function showEditMateria(id, nombre) {
                document.getElementById('editIdMateria').value = id;
                document.getElementById('editIdActualMateria').value = id;
                document.getElementById('editNombreMateria').value = nombre;
                const modal = document.getElementById('editModalMateria');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeEditMateria() {
                const modal = document.getElementById('editModalMateria');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            document.getElementById('buscarMateria').addEventListener('keyup', function () {
                const filtro = this.value.toLowerCase();
                document.querySelectorAll('.materia-row').forEach(fila => {
                    const id = fila.children[0].textContent.toLowerCase();
                    const nombre = fila.querySelector('.materia-nombre').textContent.toLowerCase();
                    fila.style.display = id.includes(filtro) || nombre.includes(filtro) ? '' : 'none';
                });
            });
        </script>

        <?php if (isset($_GET['error']) || isset($_GET['success'])): ?>
        <script>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicado'): ?>
                Swal.fire({ icon: 'error', title: 'Error', text: 'El ID o el nombre ya existen.', confirmButtonColor: '#3c80b9' });
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                Swal.fire({ icon: 'success', title: 'Éxito', text: <?php
                    echo json_encode(
                        $_GET['success'] === '1' ? 'Materia creada exitosamente.' :
                        ($_GET['success'] === '2' ? 'Materia actualizada correctamente.' : 'Materia eliminada.')
                    );
                ?>, confirmButtonColor: '#76dd77' });
            <?php endif; ?>
        </script>
        <?php endif; ?>
    </div>
</body>
</html>
