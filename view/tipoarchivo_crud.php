<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tipos de Archivo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-200 via-purple-200 to-pink-200 text-gray-800 font-sans flex flex-col items-center justify-center" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat;">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 max-w-4xl w-full mt-16 mb-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-extrabold text-blue-800">Tipos de Archivo</h1>
            <a href="<?= BASE_URL ?>RouteController/admin">
                <button class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-700 hover:to-purple-500 text-white font-bold py-2 px-4 rounded-xl shadow">Volver</button>
            </a>
        </div>

        <div class="mb-6">
            <input type="search" id="buscarTipo" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="Buscar tipo por ID o nombre...">
        </div>

        <table class="min-w-full bg-white shadow-md rounded-lg mb-6">
            <thead class="bg-blue-100 text-blue-800">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Nombre</th>
                    <th class="py-3 px-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['tipos'] as $tipo): ?>
                <tr class="border-t">
                    <td class="py-2 px-4"><?= $tipo->getId() ?></td>
                    <td class="py-2 px-4"><?= $tipo->getTipo() ?></td>
                    <td class="py-2 px-4 text-center space-x-2">
                        <button onclick="editarTipo('<?= $tipo->getId() ?>', '<?= $tipo->getTipo() ?>')" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded">Editar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="text-2xl font-semibold text-blue-700 mb-4">Agregar nuevo tipo</h2>
        <form action="<?= BASE_URL ?>TipoArchivoAdminController/create" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="codigo" class="block text-sm font-medium text-gray-700">ID</label>
                <input type="number" name="codigo" id="codigo" required class="mt-1 block w-full rounded border border-gray-300 p-2">
            </div>
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" required class="mt-1 block w-full rounded border border-gray-300 p-2">
            </div>
            <div class="col-span-1 md:col-span-2 text-right">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow">Agregar</button>
            </div>
        </form>

        <!-- Modal -->
        <div id="modalTipo" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
            <form action="<?= BASE_URL ?>TipoArchivoAdminController/update" method="POST" class="bg-white p-6 rounded shadow-md w-full max-w-md">
                <input type="hidden" name="codigo_actual" id="codigoActualTipo">
                <div class="mb-4">
                    <label for="codigoTipo" class="block text-gray-700 font-semibold mb-1">Nuevo ID</label>
                    <input type="number" name="codigo" id="codigoTipo" required class="w-full border rounded p-2">
                </div>
                <div class="mb-4">
                    <label for="nombreTipo" class="block text-gray-700 font-semibold mb-1">Nombre</label>
                    <input type="text" name="nombre" id="nombreTipo" required class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
                    <button type="button" onclick="cerrarModal()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </form>
        </div>

        <!-- Mensajes con SweetAlert -->
        <?php
            $error = $_GET['error'] ?? null;
            $success = $_GET['success'] ?? null;
        ?>

        <?php if ($error || $success): ?>
        <script>
            <?php if ($error === 'idduplicado'): ?>
                Swal.fire({ icon: 'error', title: 'Código duplicado', text: 'Ya existe un tipo de archivo con ese código.', confirmButtonColor: '#3c80b9' });
            <?php elseif ($error === 'nombreduplicado'): ?>
                Swal.fire({ icon: 'error', title: 'Nombre duplicado', text: 'Ya existe un tipo de archivo con ese nombre.', confirmButtonColor: '#3c80b9' });
            <?php elseif ($error === 'idyausado'): ?>
                Swal.fire({ icon: 'error', title: 'Código ya en uso', text: 'El nuevo código que ingresaste ya pertenece a otro tipo de archivo.', confirmButtonColor: '#3c80b9' });
            <?php elseif ($error === 'nombreyausado'): ?>
                Swal.fire({ icon: 'error', title: 'Nombre ya en uso', text: 'El nombre ingresado ya está asignado a otro tipo de archivo.', confirmButtonColor: '#3c80b9' });
            <?php elseif ($error === 'creacionfallida'): ?>
                Swal.fire({ icon: 'error', title: 'Error al crear', text: 'Hubo un problema al registrar el tipo de archivo.', confirmButtonColor: '#3c80b9' });
            <?php endif; ?>

            <?php if ($success === '1'): ?>
                Swal.fire({ icon: 'success', title: 'Registrado', text: 'Tipo de archivo creado correctamente.', confirmButtonColor: '#76dd77' });
            <?php elseif ($success === '2'): ?>
                Swal.fire({ icon: 'success', title: 'Actualizado', text: 'Tipo de archivo actualizado correctamente.', confirmButtonColor: '#76dd77' });
            <?php endif; ?>
        </script>
        <?php endif; ?>

    </div>

    <script>
        function editarTipo(codigo, nombre) {
            document.getElementById('codigoActualTipo').value = codigo;
            document.getElementById('codigoTipo').value = codigo;
            document.getElementById('nombreTipo').value = nombre;
            const modal = document.getElementById('modalTipo');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function cerrarModal() {
            const modal = document.getElementById('modalTipo');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('buscarTipo').addEventListener('keyup', function () {
            const filtro = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(fila => {
                const id = fila.children[0].textContent.toLowerCase();
                const nombre = fila.children[1].textContent.toLowerCase();
                fila.style.display = (id.includes(filtro) || nombre.includes(filtro)) ? '' : 'none';
            });
        });
    </script>
</body>
</html>