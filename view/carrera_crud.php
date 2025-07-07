<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carreras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-400 via-blue-500 to-indigo-600 text-white font-sans flex flex-col items-center justify-center" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat;">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 max-w-4xl w-full mt-16 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-4xl font-extrabold text-indigo-600">Carreras</h1>
            <a href="<?= BASE_URL ?>RouteController/admin">
                <button class="bg-gradient-to-r from-indigo-500 to-indigo-700 hover:from-indigo-700 hover:to-indigo-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105">Volver</button>
            </a>
        </div>

        <div class="pb-4">
            <input type="search" id="buscarCarrera" class="block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50" placeholder="Buscar por código o nombre de carrera..." />
        </div>

        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white bg-opacity-80 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-indigo-600 font-bold">Código</th>
                        <th class="py-3 px-4 text-indigo-600 font-bold">Nombre de la carrera</th>
                        <th class="py-3 px-4 text-indigo-600 font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['carreras'] as $carrera): ?>
                    <tr class="carrera-row">
                        <td class="py-2 px-4 text-center text-indigo-600"><?= htmlspecialchars($carrera->getCodigo()) ?></td>
                        <td class="py-2 px-4 text-indigo-600 carrera-nombre">
                            <?= htmlspecialchars($carrera->getNom_carrera()) ?>
                        </td>
                        <td class="py-2 px-4 text-center">
                            <button onclick="showEditCarrera('<?= $carrera->getCodigo() ?>', '<?= htmlspecialchars($carrera->getNom_carrera()) ?>')" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">Editar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-semibold text-purple-600 mb-4">Agregar nueva carrera</h2>
        <form action="<?= BASE_URL ?>CarreraAdminController/create" method="POST" class="bg-white bg-opacity-80 shadow-md rounded-lg p-6 mb-6">
            <div class="mb-4">
                <label for="codigo" class="block text-indigo-600 font-semibold mb-1">Código:</label>
                <input type="number" name="codigo" id="codigo" required class="border border-indigo-600 rounded w-full py-2 px-3 text-indigo-600">
            </div>
            <div class="mb-4">
                <label for="nombre_carrera" class="block text-indigo-600 font-semibold mb-1">Nombre de la carrera:</label>
                <input type="text" name="nombre_carrera" id="nombre_carrera" required class="border border-indigo-600 rounded w-full py-2 px-3 text-indigo-600">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-indigo-600 hover:to-purple-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300">Agregar Carrera</button>
        </form>

        <div id="editModalCarrera" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center hidden z-50">
            <form action="<?= BASE_URL ?>CarreraAdminController/update" method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
                <input type="hidden" name="codigo_actual" id="editCodigoActualCarrera">
                <div class="mb-4">
                    <label for="editCodigoCarrera" class="block text-indigo-600 font-semibold mb-1">Código:</label>
                    <input type="number" name="codigo" id="editCodigoCarrera" required class="border border-indigo-600 rounded w-full py-2 px-3 text-indigo-600">
                </div>
                <div class="mb-4">
                    <label for="editNombreCarrera" class="block text-indigo-600 font-semibold mb-1">Nombre de la carrera:</label>
                    <input type="text" name="nombre_carrera" id="editNombreCarrera" required class="border border-indigo-600 rounded w-full py-2 px-3 text-indigo-600">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
                    <button type="button" onclick="closeEditCarrera()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </form>
        </div>

        <script>
            function showEditCarrera(codigo, nombre) {
                document.getElementById('editCodigoCarrera').value = codigo;
                document.getElementById('editCodigoActualCarrera').value = codigo;
                document.getElementById('editNombreCarrera').value = nombre;
                const modal = document.getElementById('editModalCarrera');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeEditCarrera() {
                const modal = document.getElementById('editModalCarrera');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            document.getElementById('buscarCarrera').addEventListener('keyup', function () {
                const filtro = this.value.toLowerCase();
                document.querySelectorAll('.carrera-row').forEach(fila => {
                    const cod = fila.children[0].textContent.toLowerCase();
                    const nombre = fila.querySelector('.carrera-nombre').textContent.toLowerCase();
                    fila.style.display = cod.includes(filtro) || nombre.includes(filtro) ? '' : 'none';
                });
            });
        </script>

        <?php if (isset($_GET['error']) || isset($_GET['success'])): ?>
        <script>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicado'): ?>
                Swal.fire({ icon: 'error', title: 'Error', text: 'El código o nombre de carrera ya existe.', confirmButtonColor: '#6366F1' });
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                Swal.fire({ icon: 'success', title: 'Operación exitosa', text: <?php
                    echo json_encode(
                        $_GET['success'] === '1' ? 'Carrera creada exitosamente.' :
                        ($_GET['success'] === '2' ? 'Carrera actualizada correctamente.' : 'Carrera eliminada.')
                    );
                ?>, confirmButtonColor: '#6366F1' });
            <?php endif; ?>
        </script>
        <?php endif; ?>
    </div>
</body>
</html>
