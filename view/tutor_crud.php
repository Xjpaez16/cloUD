<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tutores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#32a8a8] via-[#3c80b9] to-[#b993d6] text-white font-sans flex flex-col items-center justify-center" style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat;">
    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 max-w-5xl w-full mt-16 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-4xl font-extrabold text-[#3c80b9] drop-shadow mb-2 md:mb-0">Tutores</h1>
            <a href="<?= BASE_URL ?>RouteController/admin">
            <button class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-700 hover:to-purple-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105">Volver</button>            </a>
        </div>
        <h2 class="text-2xl font-semibold text-[#32a8a8] mb-4">Ver tutores</h2> 
        <div class="pb-8">
            <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar por ID, nombre o correo..." />
        </div>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full bg-white bg-opacity-80 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">ID</th>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Nombre</th>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Correo</th>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Calificación</th>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Respuesta</th>
                        <th class="py-3 px-4 text-[#3c80b9] font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['tutores'] as $tut): ?>
                    <?php $activo = $tut->getCod_estado(); ?>
                    <tr id="tutorRow-<?= $tut->getCodigo()?>" class="tutor-row <?= $activo == 3 ? 'opacity-50 bg-gray-300' : '' ?>">
                        <td class="py-2 px-4 text-center text-[#3c80b9]"><?= htmlspecialchars($tut->getCodigo()) ?></td>
                        <td class="py-2 px-4 text-[#3c80b9] tutor-nombre"><?= htmlspecialchars($tut->getNombre()) ?></td>
                        <td class="py-2 px-4 text-[#3c80b9] tutor-correo"><?= htmlspecialchars($tut->getCorreo()) ?></td>
                        <td class="py-2 px-4 text-[#3c80b9]"><?= htmlspecialchars((string)($tut->getCalificacion_general() ?? '0.0')) ?></td>
                        <td class="py-2 px-4 text-[#3c80b9]"><?= htmlspecialchars($tut->getRespuesta_preg() ?? '') ?></td>
                        <td class="py-2 px-4 flex gap-2 justify-center">
                            <button type="button" onclick="toggleEstadoTutor(<?= $tut->getCodigo() ?>)" id="btnEstadoTutor-<?= $tut->getCodigo() ?>" class="w-28 <?= $activo == 2 ? 'bg-red-500 hover:bg-red-700' : 'bg-green-500 hover:bg-green-700' ?> text-white font-semibold px-3 py-2 rounded shadow transition text-base">
                                <?= $activo == 2 ? 'Desactivar' : 'Activar' ?>
                            </button>
                            <?php if ($activo == 2): ?>
                                <button type="button" class="btn-editar-tutor w-28 bg-blue-500 hover:bg-blue-700 text-white font-semibold px-3 py-2 rounded shadow transition text-base"
                                onclick="showEditTutor(
                                    '<?= $tut->getCodigo() ?>',
                                    '<?= htmlspecialchars($tut->getNombre()) ?>',
                                    '<?= htmlspecialchars($tut->getCorreo()) ?>',
                                    '<?= htmlspecialchars($tut->getRespuesta_preg()) ?>',
                                    '<?= htmlspecialchars((string)($tut->getCalificacion_general() ?? '0.0')) ?>'
                                )">
                                Editar
                            </button>

                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <h2 class="text-2xl font-semibold text-[#32a8a8] mt-6 mb-4">Agregar nuevo tutor</h2>
        <form action="<?= BASE_URL ?>TutorAdminController/create" method="POST" class="bg-white bg-opacity-80 shadow-md rounded-lg p-6 mb-4">
            <div class="mb-4">
                <label for="codigo" class="block text-[#3c80b9] font-semibold mb-1">ID:</label>
                <input type="number" name="codigo" id="codigo" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
            </div>
            <div class="mb-4">
                <label for="nombre" class="block text-[#3c80b9] font-semibold mb-1">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-[#3c80b9] font-semibold mb-1">Correo:</label>
                <input type="email" name="correo" id="correo" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
            </div>
            <div class="mb-4">
                <label for="contrasena" class="block text-[#3c80b9] font-semibold mb-1">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
            </div>
            <div class="mb-4">
                <label for="respuesta_preg" class="block text-[#3c80b9] font-semibold mb-1">Respuesta de Seguridad:</label>
                <input type="text" name="respuesta_preg" id="respuesta_preg" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
            </div>
            <button type="submit" class="bg-gradient-to-r from-[#32a8a8] to-[#3c80b9] hover:from-[#3c80b9] hover:to-[#32a8a8] text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105 w-full">Agregar Tutor</button>
        </form>

        <!-- Modal de edición -->
        <div id="editModalTutor" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
            <form id="editFormTutor" action="<?= BASE_URL ?>TutorAdminController/update" method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
                <input type="hidden" name="codigo_actual" id="editCodigoActualTutor">
                <div class="mb-4">
                    <label for="editCodigoTutor" class="block text-[#3c80b9] font-semibold mb-1">ID:</label>
                    <input type="number" name="codigo" id="editCodigoTutor" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
                </div>
                <div class="mb-4">
                    <label for="editNombreTutor" class="block text-[#3c80b9] font-semibold mb-1">Nombre:</label>
                    <input type="text" name="nombre" id="editNombreTutor" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
                </div>
                <div class="mb-4">
                    <label for="editCorreoTutor" class="block text-[#3c80b9] font-semibold mb-1">Correo:</label>
                    <input type="email" name="correo" id="editCorreoTutor" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
                </div>
                <div class="mb-4">
                    <label for="editCalificacionTutor" class="block text-[#3c80b9] font-semibold mb-1">Calificación:</label>
                    <input type="text" name="calificacion_general" id="editCalificacionTutor" readonly class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-gray-100">
                </div>
                <div class="mb-4">
                    <label for="editRespuestaTutor" class="block text-[#3c80b9] font-semibold mb-1">Respuesta de Seguridad:</label>
                    <input type="text" name="respuesta_preg" id="editRespuestaTutor" required class="border border-[#3c80b9] rounded w-full py-2 px-3 text-[#3c80b9] bg-white">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Guardar</button>
                    <button type="button" onclick="closeEditTutor()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </form>
        </div>

        <script>
            function showEditTutor(id, nombre, correo, respuesta, calificacion) {
                document.getElementById('editCodigoTutor').value = id;
                document.getElementById('editCodigoActualTutor').value = id;
                document.getElementById('editNombreTutor').value = nombre;
                document.getElementById('editCorreoTutor').value = correo;
                document.getElementById('editRespuestaTutor').value = respuesta;
                document.getElementById('editCalificacionTutor').value = calificacion;
                const modal = document.getElementById('editModalTutor');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }


            function closeEditTutor() {
                const modal = document.getElementById('editModalTutor');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            function toggleEstadoTutor(id) {
                const row = document.getElementById('tutorRow-' + id);
                const btn = document.getElementById('btnEstadoTutor-' + id);
                const isInactive = row.classList.contains('opacity-50');

                if (isInactive) {
                    row.classList.remove('opacity-50', 'bg-gray-300');
                    btn.textContent = 'Desactivar';
                    btn.classList.remove('bg-green-500', 'hover:bg-green-700');
                    btn.classList.add('bg-red-500', 'hover:bg-red-700');

                    const acciones = btn.parentNode;
                    if (!acciones.querySelector('.btn-editar-tutor')) {
                        const editBtn = document.createElement('button');
                        editBtn.className = 'btn-editar-tutor w-28 bg-blue-500 hover:bg-blue-700 text-white font-semibold px-3 py-2 rounded shadow transition text-base';
                        editBtn.textContent = 'Editar';
                        editBtn.onclick = () => showEditTutor(
                            id,
                            row.children[1].textContent.trim(),
                            row.children[2].textContent.trim(),
                            '',
                            row.children[3].textContent.trim()
                        );
                        acciones.appendChild(editBtn);
                    }

                    fetch(`<?= BASE_URL ?>TutorAdminController/activar?codigo=${id}`)
                        .catch(error => alert("Error al activar el tutor."));
                    Swal.fire({ icon: 'success', title: 'Activado', text: 'Tutor activado correctamente', confirmButtonColor: '#76dd77' });
                } else {
                    row.classList.add('opacity-50', 'bg-gray-300');
                    btn.textContent = 'Activar';
                    btn.classList.remove('bg-red-500', 'hover:bg-red-700');
                    btn.classList.add('bg-green-500', 'hover:bg-green-700');

                    const acciones = btn.parentNode;
                    const editBtn = acciones.querySelector('.btn-editar-tutor');
                    if (editBtn) acciones.removeChild(editBtn);

                    fetch(`<?= BASE_URL ?>TutorAdminController/delete?codigo=${id}`)
                        .catch(error => alert("Error al desactivar el tutor."));
                    Swal.fire({ icon: 'success', title: 'Desactivado', text: 'Tutor desactivado correctamente', confirmButtonColor: '#76dd77' });
                }
            }

            document.getElementById('default-search').addEventListener('keyup', function () {
                const filtro = this.value.toLowerCase();
                document.querySelectorAll('.tutor-row').forEach(fila => {
                    const id = fila.children[0]?.textContent.toLowerCase() || '';
                    const nombre = fila.querySelector('.tutor-nombre')?.textContent.toLowerCase() || '';
                    const correo = fila.querySelector('.tutor-correo')?.textContent.toLowerCase() || '';
                    fila.style.display = (id.includes(filtro) || nombre.includes(filtro) || correo.includes(filtro)) ? '' : 'none';
                });
            });
        </script>
        <?php if (isset($_GET['error']) || isset($_GET['success'])): ?>
        <script>
            <?php if (isset($_GET['error'])): ?>
                <?php if ($_GET['error'] === 'idduplicado'): ?>
                    Swal.fire({ icon: 'error', title: 'ID duplicado', text: 'Ya existe un tutor con ese ID.', confirmButtonColor: '#3c80b9' });
                <?php elseif ($_GET['error'] === 'emailinvalido'): ?>
                    Swal.fire({ icon: 'error', title: 'Correo no válido', text: 'El correo debe ser institucional (@udistrital.edu.co).', confirmButtonColor: '#3c80b9' });
                <?php elseif ($_GET['error'] === 'claveinvalida'): ?>
                    Swal.fire({ icon: 'error', title: 'Contraseña insegura', html: 'Debe tener al menos:<br>• Una minúscula<br>• Una mayúscula<br>• Un número<br>• Un símbolo<br>• Mínimo 8 caracteres', confirmButtonColor: '#3c80b9' });
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <?php if ($_GET['success'] === '1'): ?>
                    Swal.fire({ icon: 'success', title: 'Tutor creado', text: 'El tutor fue registrado exitosamente.', confirmButtonColor: '#76dd77' });
                <?php elseif ($_GET['success'] === '2'): ?>
                    Swal.fire({ icon: 'success', title: 'Tutor actualizado', text: 'Los datos del tutor se actualizaron correctamente.', confirmButtonColor: '#76dd77' });
                <?php endif; ?>
            <?php endif; ?>
        </script>
        <?php endif; ?>
    </div>
</body>
</html>
