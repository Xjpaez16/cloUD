<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 text-white font-sans flex flex-col items-center justify-center" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat;">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 max-w-4xl w-full mt-16 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-4xl font-extrabold text-purple-700">Estados</h1>
            <a href="<?= BASE_URL ?>RouteController/admin">
                <button class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-pink-600 hover:to-purple-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105">Volver</button>
            </a>
        </div>

        <div class="pb-4">
            <input type="search" id="buscarEstado" class="block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50" placeholder="Buscar por código o tipo de estado..." />
        </div>

        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white bg-opacity-80 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-purple-700 font-bold">Código</th>
                        <th class="py-3 px-4 text-purple-700 font-bold">Tipo Estado</th>
                        <th class="py-3 px-4 text-purple-700 font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['estados'] as $estado): ?>
                    <tr class="estado-row">
                        <td class="py-2 px-4 text-center text-purple-700"><?= htmlspecialchars($estado['codigo']) ?></td>
                        <td class="py-2 px-4 text-purple-700 estado-tipo"><?= htmlspecialchars($estado['tipo_estado']) ?></td>
                        <td class="py-2 px-4 text-center">
                            <button onclick="showEditEstado('<?= $estado['codigo'] ?>', '<?= htmlspecialchars($estado['tipo_estado']) ?>')" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">Editar</button>                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-semibold text-blue-600 mb-4">Agregar nuevo estado</h2>
        <form action="<?= BASE_URL ?>EstadoAdminController/create" method="POST" class="bg-white bg-opacity-80 shadow-md rounded-lg p-6 mb-6">
            <div class="mb-4">
                <label for="codigo" class="block text-purple-700 font-semibold mb-1">Código:</label>
                <input type="number" name="codigo" id="codigo" required class="border border-purple-500 rounded w-full py-2 px-3 text-purple-700">
            </div>
            <div class="mb-4">
                <label for="tipo_estado" class="block text-purple-700 font-semibold mb-1">Tipo de Estado:</label>
                <input type="text" name="tipo_estado" id="tipo_estado" required class="border border-purple-500 rounded w-full py-2 px-3 text-purple-700">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-purple-600 hover:to-blue-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300">Agregar Estado</button>
        </form>

        <div id="editModalEstado" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center hidden z-50">
            <form action="<?= BASE_URL ?>EstadoAdminController/update" method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
                <input type="hidden" name="codigo_actual" id="editCodigoActualEstado">
                <div class="mb-4">
                    <label for="editCodigoEstado" class="block text-purple-700 font-semibold mb-1">Código:</label>
                    <input type="number" name="codigo" id="editCodigoEstado" required class="border border-purple-500 rounded w-full py-2 px-3 text-purple-700">
                </div>
                <div class="mb-4">
                    <label for="editTipoEstado" class="block text-purple-700 font-semibold mb-1">Tipo de Estado:</label>
                    <input type="text" name="tipo_estado" id="editTipoEstado" required class="border border-purple-500 rounded w-full py-2 px-3 text-purple-700">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
                    <button type="button" onclick="closeEditEstado()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </form>
        </div>

        <script>
            function showEditEstado(codigo, tipo) {
                document.getElementById('editCodigoEstado').value = codigo;
                document.getElementById('editCodigoActualEstado').value = codigo;
                document.getElementById('editTipoEstado').value = tipo;
                const modal = document.getElementById('editModalEstado');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeEditEstado() {
                const modal = document.getElementById('editModalEstado');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            document.getElementById('buscarEstado').addEventListener('keyup', function () {
                const filtro = this.value.toLowerCase();
                document.querySelectorAll('.estado-row').forEach(fila => {
                    const cod = fila.children[0].textContent.toLowerCase();
                    const tipo = fila.querySelector('.estado-tipo').textContent.toLowerCase();
                    fila.style.display = cod.includes(filtro) || tipo.includes(filtro) ? '' : 'none';
                });
            });
        </script>

        <?php if (isset($_GET['error']) || isset($_GET['success'])): ?>
        <script>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicado'): ?>
                Swal.fire({ icon: 'error', title: 'Error', text: 'El código o tipo de estado ya existe.', confirmButtonColor: '#a855f7' });
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                Swal.fire({ icon: 'success', title: 'Exito', text: <?php
                    echo json_encode(
                        $_GET['success'] === '1' ? 'Estado creado exitosamente.' :
                        ($_GET['success'] === '2' ? 'Estado actualizado correctamente.' : 'Estado eliminado.')
                    );
                ?>, confirmButtonColor: '#22c55e' });
            <?php endif; ?>
        </script>
        <?php endif; ?>
    </div>
</body>
</html>
