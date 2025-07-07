<!--<?php require_once __DIR__ . '/layouts/nav.php'; ?>-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administradores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#5232a8] via-[#803cb9] to-[#b993d6] text-white font-sans flex flex-col items-center justify-center" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat;">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 max-w-3xl w-full mt-16 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-4xl font-extrabold text-[#5232a8] drop-shadow mb-2 md:mb-0">Administradores</h1>
            <a href="<?= BASE_URL ?>RouteController/admin">
                <button class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-700 hover:to-purple-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105">Volver</button>
            </a>
        </div>
        <h2 class="text-2xl font-semibold text-[#803cb9] mb-4">Ver administradores</h2> 
        <div class="pb-8">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar por ID, nombre o correo..." />

                
            </div>
        </div>
        

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
                    <?php $activo = $admin->getActivo(); ?>
                    <tr id="adminRow-<?= $admin->getCodigo()?>" class="admin-row <?= $activo ? '' : 'opacity-50 bg-gray-300' ?>">
                        <td class="py-2 px-4 text-center text-[#5232a8]"><?= htmlspecialchars($admin->getCodigo()) ?></td>
                        <td class="py-2 px-4 text-[#5232a8] admin-nombre"><?= htmlspecialchars($admin->getNombre()) ?></td>
                        <td class="py-2 px-4 text-[#5232a8] admin-correo"><?= htmlspecialchars($admin->getCorreo()) ?></td>
                        <td class="py-2 px-4 flex gap-2 justify-center">
                            <button type="button" onclick="toggleEstado(<?= $admin->getCodigo() ?>)" id="btnEstado-<?= $admin->getCodigo() ?>" class="w-28 <?= $activo ? 'bg-red-500 hover:bg-red-700' : 'bg-green-500 hover:bg-green-700' ?> text-white font-semibold px-3 py-2 rounded shadow transition text-base">
                                <?= $activo ? 'Desactivar' : 'Activar' ?>
                            </button>
                            <?php if ($activo): ?>
                            <button type="button" class="btn-editar w-28 bg-blue-500 hover:bg-blue-700 text-white font-semibold px-3 py-2 rounded shadow transition text-base"
                                onclick="showEdit('<?= $admin->getCodigo() ?>', '<?= htmlspecialchars($admin->getNombre()) ?>', '<?= htmlspecialchars($admin->getCorreo()) ?>', '<?= htmlspecialchars($admin->getRespuesta_preg()) ?>')">Editar</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <h2 class="text-2xl font-semibold text-[#803cb9] mt-6 mb-4">Agregar nuevo admin</h2>
        <form action="<?= BASE_URL ?>AdminController/create" method="POST" class="bg-white bg-opacity-80 shadow-md rounded-lg p-6 mb-4">
            <div class="mb-4">
                <label for="id" class="block text-[#5232a8] font-semibold mb-1">ID:</label>
                <input type="number" name="id" id="id" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] bg-white">
            </div>
            <div class="mb-4">
                <label for="nombre" class="block text-[#5232a8] font-semibold mb-1">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] bg-white">
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-[#5232a8] font-semibold mb-1">Correo:</label>
                <input type="email" name="correo" id="correo" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] bg-white">
            </div>
            <div class="mb-4">
                <label for="contrasena" class="block text-[#5232a8] font-semibold mb-1">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] bg-white">
            </div>
            <div class="mb-4">
                <label for="respuesta_preg" class="block text-[#5232a8] font-semibold mb-1">Respuesta de Seguridad:</label>
                <input type="text" name="respuesta_preg" id="respuesta_preg" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] bg-white">
            </div>
            <button type="submit" class="bg-gradient-to-r from-[#803cb9] to-[#5232a8] hover:from-[#5232a8] hover:to-[#803cb9] text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105 w-full">Agregar Admin</button>
        </form>
        <div id="editModal" class="fixed flex inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
            <form id="editForm" action="<?= BASE_URL ?>AdminController/update" method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
            <input type="hidden" name="codigo_actual" id="editCodigoActual">
            <div class="mb-4">
                    <label for="editCodigo" class="block text-[#5232a8] font-semibold mb-1">ID:</label>
                    <input type="number" name="codigo" id="editCodigo" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] bg-white">
                </div>
                <div class="mb-4">
                    <label for="editNombre" class="block text-[#5232a8] font-semibold mb-1">Nombre:</label>
                    <input type="text" name="nombre" id="editNombre" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] bg-white">
                </div>
                <div class="mb-4">
                    <label for="editCorreo" class="block text-[#5232a8] font-semibold mb-1">Correo:</label>
                    <input type="email" name="correo" id="editCorreo" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] bg-white">
                </div>
                <div class="mb-4">
                    <label for="editRespuesta" class="block text-[#5232a8] font-semibold mb-1">Respuesta de Seguridad:</label>
                    <input type="text" name="respuesta_preg" id="editRespuesta" required class="border border-[#803cb9] rounded w-full py-2 px-3 text-[#5232a8] bg-white">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Guardar</button>
                    <button type="button" onclick="closeEdit()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </form>
        </div>
        <script>
            function showEdit(id, nombre, correo, respuesta) {
                document.getElementById('editCodigo').value = id;
                document.getElementById('editCodigoActual').value = id;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editCorreo').value = correo;
                document.getElementById('editRespuesta').value = respuesta;
                document.getElementById('editModal').classList.remove('hidden');
            }

            function closeEdit() {
                document.getElementById('editModal').classList.add('hidden');
            }

            function toggleEstado(id) {
                const row = document.getElementById('adminRow-' + id);
                const btn = document.getElementById('btnEstado-' + id);
                const isInactive = row.classList.contains('opacity-50');

                if (isInactive) {
                    // Activar visual
                    row.classList.remove('opacity-50', 'bg-gray-300');
                    btn.textContent = 'Desactivar';
                    btn.classList.remove('bg-green-500', 'hover:bg-green-700');
                    btn.classList.add('bg-red-500', 'hover:bg-red-700');

                    // Restaurar botón editar
                    const acciones = btn.parentNode;
                    if (!acciones.querySelector('.btn-editar')) {
                        const editBtn = document.createElement('button');
                        editBtn.className = 'btn-editar w-28 bg-blue-500 hover:bg-blue-700 text-white font-semibold px-3 py-2 rounded shadow transition text-base';
                        editBtn.textContent = 'Editar';
                        editBtn.onclick = () => showEdit(
                            id,
                            row.children[1].textContent.trim(),
                            row.children[2].textContent.trim(),
                            '' // No puedes recuperar respuesta_preg sin tenerla visible
                        );
                        acciones.appendChild(editBtn);
                    }

                    // Llamar al backend para activar
                    fetch(`<?= BASE_URL ?>AdminController/activar?codigo=${id}`)
                        .catch(error => alert("Error al activar el administrador."));
                        Swal.fire({
                        icon: 'success',
                        title: 'Activacion',
                        text: 'Admin activado correctamente',
                        confirmButtonColor: '#76dd77'
                        });
                } else {
                    // Desactivar visual
                    row.classList.add('opacity-50', 'bg-gray-300');
                    btn.textContent = 'Activar';
                    btn.classList.remove('bg-red-500', 'hover:bg-red-700');
                    btn.classList.add('bg-green-500', 'hover:bg-green-700');

                    // Ocultar botón editar
                    const acciones = btn.parentNode;
                    const editBtn = acciones.querySelector('.btn-editar');
                    if (editBtn) acciones.removeChild(editBtn);

                    // Llamar al backend para desactivar
                    fetch(`<?= BASE_URL ?>AdminController/delete?codigo=${id}`)
                        .catch(error => alert("Error al desactivar el administrador."));
                        Swal.fire({
                        icon: 'success',
                        title: 'Desactivado',
                        text: 'Admin desactivado correctamente',
                        confirmButtonColor: '#76dd77'
                        });
                }
            }
            document.getElementById('default-search').addEventListener('keyup', function () {
                const filtro = this.value.toLowerCase();
                document.querySelectorAll('.admin-row').forEach(fila => {
                    const id = fila.querySelector('.admin-id')?.textContent.toLowerCase() || '';
                    const nombre = fila.querySelector('.admin-nombre')?.textContent.toLowerCase() || '';
                    const correo = fila.querySelector('.admin-correo')?.textContent.toLowerCase() || '';
                    fila.style.display = (id.includes(filtro) || nombre.includes(filtro) || correo.includes(filtro)) ? '' : 'none';
                });
            });
        </script>
        
       <?php if (isset($_GET['error']) || isset($_GET['success'])): ?>
        <script>
            <?php if (isset($_GET['error'])): ?>
            <?php if ($_GET['error'] === 'idduplicado'): ?>
                Swal.fire({
                icon: 'error',
                title: 'ID duplicado',
                text: 'Ya existe un administrador con ese ID.',
                confirmButtonColor: '#803cb9'
                });
            <?php elseif ($_GET['error'] === 'emailinvalido'): ?>
                Swal.fire({
                icon: 'error',
                title: 'Correo no válido',
                text: 'El correo debe ser institucional (@udistrital.edu.co).',
                confirmButtonColor: '#803cb9'
                });
            <?php elseif ($_GET['error'] === 'claveinvalida'): ?>
                Swal.fire({
                icon: 'error',
                title: 'Contraseña insegura',
                html: 'Debe tener al menos:<br>• Una minúscula<br>• Una mayúscula<br>• Un número<br>• Un símbolo<br>• Mínimo 8 caracteres',
                confirmButtonColor: '#803cb9'
                });
            <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
            <?php if ($_GET['success'] === '1'): ?>
                Swal.fire({
                icon: 'success',
                title: 'Administrador creado',
                text: 'El administrador fue registrado exitosamente.',
                confirmButtonColor: '#76dd77'
                });
            <?php elseif ($_GET['success'] === '2'): ?>
                Swal.fire({
                icon: 'success',
                title: 'Administrador actualizado',
                text: 'Los datos del administrador se actualizaron correctamente.',
                confirmButtonColor: '#76dd77'
                });
            
                 
            <?php endif; ?>
            <?php endif; ?>
        </script>
        <?php endif; ?>


    </div>
    
</body>
</html>