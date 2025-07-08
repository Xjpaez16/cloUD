<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Áreas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#32a8a8] via-[#3c80b9] to-[#b993d6] text-white font-sans flex flex-col items-center justify-center" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat;">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 max-w-4xl w-full mt-16 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-4xl font-extrabold text-[#3c80b9] drop-shadow mb-2 md:mb-0">Áreas</h1>
            <a href="<?= BASE_URL ?>RouteController/admin">
                <button class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-700 hover:to-purple-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105">Volver</button>
            </a>
        </div>
        <h2 class="text-2xl font-semibold text-[#32a8a8] mb-4">Lista de Áreas</h2> 
        <div class="pb-8">
            <input type="search" id="search-area" class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50" placeholder="Buscar por código o nombre..." />
        </div>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full bg-white bg-opacity-80 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Código</th>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Nombre</th>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['areas'] as $area): ?>
                    <tr id="areaRow-<?= $area->getCodigo() ?>" class="area-row">
                        <td class="py-2 px-4 text-center text-[#3c80b9]"><?= htmlspecialchars($area->getCodigo()) ?></td>
                        <td class="py-2 px-4 text-[#3c80b9] area-nombre"><?= htmlspecialchars($area->getNombre()) ?></td>
                        <td class="py-2 px-4 flex gap-2 justify-center">
                            <button type="button" onclick="showEditArea('<?= $area->getCodigo() ?>', '<?= htmlspecialchars($area->getNombre()) ?>')" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold px-3 py-2 rounded shadow transition">Editar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <h2 class="text-2xl font-semibold text-[#32a8a8] mt-6 mb-4">Agregar nueva Área</h2>
        <form action="<?= BASE_URL ?>AreaAdminController/create" method="POST" class="bg-white bg-opacity-80 shadow-md rounded-lg p-6 mb-4">
            <div class="mb-4">
                <label for="codigo" class="block text-[#3c80b9] font-semibold mb-1">Código:</label>
                <input type="number" name="codigo" id="codigo" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
            </div>
            <div class="mb-4">
                <label for="nombre" class="block text-[#3c80b9] font-semibold mb-1">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
            </div>
            <button type="submit" class="bg-gradient-to-r from-[#32a8a8] to-[#3c80b9] hover:from-[#3c80b9] hover:to-[#32a8a8] text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg w-full">Agregar Área</button>
        </form>

        <!-- Modal de edición -->
        <div id="editModalArea" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
            <form id="editFormArea" action="<?= BASE_URL ?>AreaAdminController/update" method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
                <input type="hidden" name="codigo_actual" id="editCodigoActual">
                <div class="mb-4">
                    <label for="editCodigo" class="block text-[#3c80b9] font-semibold mb-1">Código:</label>
                    <input type="number" name="codigo" id="editCodigo" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
                </div>
                <div class="mb-4">
                    <label for="editNombre" class="block text-[#3c80b9] font-semibold mb-1">Nombre:</label>
                    <input type="text" name="nombre" id="editNombre" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Guardar</button>
                    <button type="button" onclick="closeEditArea()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </form>
        </div>

        <script>
            function showEditArea(codigo, nombre) {
                document.getElementById('editCodigo').value = codigo;
                document.getElementById('editCodigoActual').value = codigo;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editModalArea').classList.remove('hidden');
                document.getElementById('editModalArea').classList.add('flex');
            }

            function closeEditArea() {
                document.getElementById('editModalArea').classList.add('hidden');
                document.getElementById('editModalArea').classList.remove('flex');
            }

            document.getElementById('search-area').addEventListener('keyup', function () {
                const filtro = this.value.toLowerCase();
                document.querySelectorAll('.area-row').forEach(fila => {
                    const cod = fila.children[0]?.textContent.toLowerCase() || '';
                    const nombre = fila.querySelector('.area-nombre')?.textContent.toLowerCase() || '';
                    fila.style.display = (cod.includes(filtro) || nombre.includes(filtro)) ? '' : 'none';
                });
            });
        </script>
        <?php
            $error = $_GET['error'] ?? null;
            $success = $_GET['success'] ?? null;
        ?>

        <?php if ($error || $success): ?>
        <script>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicado'): ?>
                Swal.fire({ icon: 'error', title: 'Error', text: 'El código o nombre de carrera ya existe.', confirmButtonColor: '#6366F1' });
            <?php endif; ?>
            <?php if ($error === 'idduplicado'): ?>
                Swal.fire({ icon: 'error', title: 'Código duplicado', text: 'Ya existe un tipo de archivo con ese código.', confirmButtonColor: '#3c80b9' });
            <?php elseif ($error === 'nombreduplicado'): ?>
                Swal.fire({ icon: 'error', title: 'Nombre duplicado', text: 'Ya existe un tipo de archivo con ese nombre.', confirmButtonColor: '#3c80b9' });
            <?php elseif ($error === 'idyausado'): ?>
                Swal.fire({ icon: 'error', title: 'Código ya en uso', text: 'El nuevo código que ingresaste ya pertenece a otro tipo de archivo.', confirmButtonColor: '#3c80b9' });
            <?php elseif ($error === 'nombreyausado'): ?>
                Swal.fire({ icon: 'error', title: 'Nombre ya en uso', text: 'El nombre ingresado ya está asignado a otro tipo de archivo.', confirmButtonColor: '#3c80b9' });
            <?php endif; ?>

            <?php if ($success === '1'): ?>
                Swal.fire({ icon: 'success', title: 'Área creada', text: 'El área fue registrada exitosamente.', confirmButtonColor: '#76dd77' });
            <?php elseif ($success === '2'): ?>
                Swal.fire({ icon: 'success', title: 'Área actualizada', text: 'Los datos del área se actualizaron correctamente.', confirmButtonColor: '#76dd77' });
            <?php endif; ?>
        </script>
        <?php endif; ?>

    </div>
</body>
</html>
