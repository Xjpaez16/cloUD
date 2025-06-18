<?php
require_once(__DIR__ . '/../app/controllers/models/DTO/AdministradorDTO.php'); // Asegúrate de que el DTO esté disponible
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
    exit();
}
//require_once __DIR__ . '/layouts/nav.php'; // Incluir la barra de navegación
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>cloUD - Gestionar Administradores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/notyf.css">
</head>

<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat text-white font-sans"
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">

    <div class="relative z-10 p-4">
        <main class="text-center py-8 px-4">
            <h1 class="text-4xl xl:text-5xl lg:text-4xl md:text-3xl font-bold mb-6">Gestión de Administradores</h1>

            <button id="openAddAdminModal"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-6 transition-colors duration-300">
                Agregar Nuevo Administrador
            </button>

            <div class="overflow-x-auto bg-white bg-opacity-90 rounded-lg shadow-lg p-4 mx-auto max-w-4xl">
                <table class="min-w-full divide-y divide-gray-200 text-gray-800">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Código
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Correo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        $administradores = $data['administradores'] ?? [];
                        if (!empty($administradores)) {
                            foreach ($administradores as $admin) {
                        ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?= htmlspecialchars($admin->getCodigo()) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?= htmlspecialchars($admin->getNombre()) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?= htmlspecialchars($admin->getCorreo()) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="openEditAdminModal bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-300"
                                            data-id="<?= htmlspecialchars($admin->getCodigo()) ?>"
                                            data-nombre="<?= htmlspecialchars($admin->getNombre()) ?>"
                                            data-correo="<?= htmlspecialchars($admin->getCorreo()) ?>"
                                            data-respuesta_preg="<?= htmlspecialchars($admin->getRespuesta_preg()) ?>">
                                            Editar
                                        </button>
                                        <form action="<?= BASE_URL ?>AdminController/deleteAdmin" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este administrador?');">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($admin->getCodigo()) ?>">
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs ml-2 transition-colors duration-300">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay administradores registrados.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div id="adminModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl max-w-lg w-full text-gray-800 relative">
            <button id="closeAdminModal" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-2xl font-bold">&times;</button>
            <h2 id="modalTitle" class="text-2xl font-bold mb-6 text-center"></h2>
            <form id="adminForm" action="" method="POST" class="space-y-4">
                <input type="hidden" id="adminId" name="id">

                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                    <input type="text" id="codigo" name="codigo" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                    <input type="email" id="correo" name="correo" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña (dejar vacío para mantener la actual)</label>
                    <input type="password" id="password" name="password"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="respuesta_preg1" class="block text-sm font-medium text-gray-700">Respuesta de Seguridad Parte 1</label>
                    <input type="text" id="respuesta_preg1" name="respuesta_preg1" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="respuesta_preg2" class="block text-sm font-medium text-gray-700">Respuesta de Seguridad Parte 2</label>
                    <input type="text" id="respuesta_preg2" name="respuesta_preg2" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancelAdminForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-300">Cancelar</button>
                    <button type="submit" id="submitAdminForm" class="bg-purple-600 hover:bg-purple-900 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const notyf = new Notyf({
            duration: 3000,
            className: 'rounded-lg text-white text-[11px] sm:text-sm md:text-base px-2 sm:px-4 py-1.5 sm:py-2 shadow-md font-sans font-semibold max-w-[95vw] w-fit min-w-[120px] min-h-[36px] sm:min-h-[44px]',
            position: { x: 'right', y: 'top' },
            types: [
                { type: 'success', background: '#76dd77' },
                { type: 'error', background: '#FF0000' }
            ]
        });

        // Mostrar mensajes de éxito/error de las operaciones CRUD
        <?php if (isset($_GET['success'])) { ?>
            <?php
            $successMessages = [
                'admin_added' => 'Administrador agregado con éxito.',
                'admin_updated' => 'Administrador actualizado con éxito.',
                'admin_deleted' => 'Administrador eliminado con éxito.'
            ];
            $msg = $successMessages[$_GET['success']] ?? 'Operación realizada con éxito.';
            ?>
            notyf.open({ type: 'success', message: '<?= $msg ?>' });
        <?php } ?>

        <?php if (isset($_GET['error'])) { ?>
            <?php
            $errorMessages = [
                'add_failed' => 'Error al agregar el administrador. Inténtalo de nuevo.',
                'update_failed' => 'Error al actualizar el administrador. Inténtalo de nuevo.',
                'delete_failed' => 'Error al eliminar el administrador. Inténtalo de nuevo.',
                'admin_not_found' => 'Administrador no encontrado.',
                'email_invalido' => 'El formato del correo es inválido.',
                'password_invalida' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.',
                'correo_existente' => 'El correo ya está registrado para otro administrador.',
                'email_invalido_edit' => 'El formato del correo es inválido.',
                'password_invalida_edit' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.',
                'correo_existente_edit' => 'El correo ya está registrado para otro administrador.',
                'cannot_delete_self' => 'No puedes eliminar tu propia cuenta de administrador.'
            ];
            $msg = $errorMessages[$_GET['error']] ?? 'Ha ocurrido un error inesperado.';
            ?>
            notyf.open({ type: 'error', message: '<?= $msg ?>' });
        <?php } ?>

        // Lógica del Modal (Agregar/Editar)
        const adminModal = document.getElementById('adminModal');
        const openAddAdminModalBtn = document.getElementById('openAddAdminModal');
        const closeAdminModalBtn = document.getElementById('closeAdminModal');
        const cancelAdminFormBtn = document.getElementById('cancelAdminForm');
        const adminForm = document.getElementById('adminForm');
        const modalTitle = document.getElementById('modalTitle');
        const adminIdInput = document.getElementById('adminId');
        const codigoInput = document.getElementById('codigo');
        const nombreInput = document.getElementById('nombre');
        const correoInput = document.getElementById('correo');
        const passwordInput = document.getElementById('password');
        const respuestaPreg1Input = document.getElementById('respuesta_preg1');
        const respuestaPreg2Input = document.getElementById('respuesta_preg2');

        function openModal(mode, adminData = {}) {
            adminModal.classList.remove('hidden');
            if (mode === 'add') {
                modalTitle.textContent = 'Agregar Nuevo Administrador';
                adminForm.action = '<?= BASE_URL ?>AdminController/addAdmin';
                adminIdInput.value = '';
                codigoInput.value = '';
                nombreInput.value = '';
                correoInput.value = '';
                passwordInput.value = '';
                passwordInput.setAttribute('required', 'true');
                respuestaPreg1Input.value = '';
                respuestaPreg2Input.value = '';
                codigoInput.readOnly = false;
            } else if (mode === 'edit') {
                modalTitle.textContent = 'Editar Administrador';
                adminForm.action = '<?= BASE_URL ?>AdminController/editAdmin';
                adminIdInput.value = adminData.id;
                codigoInput.value = adminData.id;
                nombreInput.value = adminData.nombre;
                correoInput.value = adminData.correo;
                passwordInput.value = '';
                passwordInput.removeAttribute('required');
                // Si la respuesta de seguridad se guarda concatenada, hay que separarla para los campos
                const rta_preg = adminData.respuesta_preg;
                respuestaPreg1Input.value = rta_preg.substring(0, rta_preg.length / 2);
                respuestaPreg2Input.value = rta_preg.substring(rta_preg.length / 2);
                codigoInput.readOnly = true; 
            }
        }

        function closeAdminModal() {
            adminModal.classList.add('hidden');
            adminForm.reset(); // Limpiar el formulario
        }

        openAddAdminModalBtn.addEventListener('click', () => openModal('add'));
        closeAdminModalBtn.addEventListener('click', closeAdminModal);
        cancelAdminFormBtn.addEventListener('click', closeAdminModal);

        // Event listeners para los botones de editar
        document.querySelectorAll('.openEditAdminModal').forEach(button => {
            button.addEventListener('click', (event) => {
                const id = event.target.dataset.id;
                const nombre = event.target.dataset.nombre;
                const correo = event.target.dataset.correo;
                const respuesta_preg = event.target.dataset.respuesta_preg;

                openModal('edit', {
                    id: id,
                    nombre: nombre,
                    correo: correo,
                    respuesta_preg: respuesta_preg
                });
            });
        });

        // Para evitar el reenvío del formulario al recargar la página
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href.split('?')[0]);
        }
    </script>
</body>

</html>