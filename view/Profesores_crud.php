<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-purple-400 via-blue-500 to-indigo-600 text-white font-sans flex flex-col items-center justify-start"
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">

    <div class="bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 max-w-4xl w-full mt-16 mb-8">

        <!-- Título y botón -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-4xl font-extrabold text-indigo-600">Profesores</h1>

            <a>
                <button id="Agregar"
                    class="bg-gradient-to-r from-indigo-500 to-indigo-700 hover:from-indigo-700 hover:to-indigo-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105">
                    Agregar Nuevo Profesor
                </button>
            </a>
            <a href="<?= BASE_URL ?>RouteController/admin">
                <button
                    class="bg-gradient-to-r from-indigo-500 to-indigo-700 hover:from-indigo-700 hover:to-indigo-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-lg transition-all duration-300 transform hover:scale-105">
                    Volver
                </button>
            </a>

        </div>

        <!-- Barra de búsqueda -->
        <div class="pb-4">
            <input type="search" id="buscarProfesor"
                class="block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Buscar por código o nombre del profesor" />
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead>
                    <tr class="bg-indigo-50">
                        <th class="py-3 px-4 text-indigo-600 font-bold text-left">Código</th>
                        <th class="py-3 px-4 text-indigo-600 font-bold text-left">Nombre del profesor</th>
                        <th class="py-3 px-4 text-indigo-600 font-bold text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php /** @var ProfesorDTO $profesor */
                    foreach ($profesores as $profesor): ?>
                    <tr class="border-t hover:bg-indigo-50 profesor-row">
                        <td class="py-2 px-4 text-indigo-700 text-center">
                            <?= htmlspecialchars($profesor->getCod()) ?>
                        </td>
                        <td class="py-2 px-4 text-indigo-700">
                            <?= htmlspecialchars($profesor->getNom()) ?>
                        </td>
                        <td class="py-2 px-4 text-center">
                            <button
                                class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 text-sm open-modal"
                                data-codigo="<?= htmlspecialchars($profesor->getCod()) ?>"
                                data-nombre="<?= htmlspecialchars($profesor->getNom()) ?>">Editar</button>
                            <button
                                class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 text-sm open-modalmats"
                                data-codigo="<?= htmlspecialchars($profesor->getCod()) ?>">Gestionar
                                Materias</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <script>
                    const botonesMat = document.querySelectorAll('.open-modalmats');
                    botonesMat.forEach(btn => {
                        btn.addEventListener('click', function() {
                            const codigo = btn.dataset.codigo;

                            document.getElementById('modalCodigop').value = codigo;
                            document.getElementById('modalMateria').classList.remove('hidden');
                        });
                    });
                    </script>
                    <script>
                    const boton = document.querySelectorAll('.open-modal');
                    boton.forEach(btn => {
                        btn.addEventListener('click', function() {
                            const codigo = btn.dataset.codigo;
                            const nombre = btn.dataset.nombre;

                            document.getElementById('modalCodigo').value = codigo;
                            document.getElementById('modalNombre').value = nombre;

                            document.getElementById('modalEditar').classList.remove('hidden');


                        });
                    });
                    </script>
                    <!-- Modal para editar -->
                    <div id="modalEditar"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                            <h2 class="text-xl font-bold text-indigo-600 mb-4">Editar Profesor</h2>

                            <form id="formEditar" method="POST" action="<?= BASE_URL ?>Profesorcontroller/update">
                                <!-- Input oculto para el código -->
                                <input type="hidden" name="codigo" id="modalCodigo">

                                <!-- Campo editable para el nombre -->
                                <div class="mb-4">
                                    <label for="modalNombre" class="block text-gray-700">Nombre:</label>
                                    <input type="text" name="nombre" id="modalNombre"
                                        class="w-full p-2 border rounded-lg text-gray-900" required>
                                </div>

                                <!-- Botones -->
                                <div class="flex justify-end space-x-2">
                                    <button type="button" id="cerrarModal"
                                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 text-gray-800">Cancelar</button>
                                    <button type="submit"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </script>

                    <!-- Agregar profesores -->
                    <div id="modalAgregar"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                            <h2 class="text-xl font-bold text-indigo-600 mb-4">Agregar Profesor</h2>

                            <form id="formEditar" method="POST" action="<?= BASE_URL ?>Profesorcontroller/create">
                                <div class="mb-4">
                                    <label for="modalCodigo" class="block text-gray-700">Codigo:</label>
                                    <input type="text" name="codigo" id="modalAggCodigo"
                                        class="w-full p-2 border rounded-lg text-gray-900" required>
                                </div>
                                <div class="mb-4">
                                    <label for="modalNombre" class="block text-gray-700">Nombre:</label>
                                    <input type="text" name="nombre" id="modalAggNombre"
                                        class="w-full p-2 border rounded-lg text-gray-900" required>
                                </div>

                                <div class="flex justify-end space-x-2">
                                    <button type="button" id="cerrarModalagg"
                                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 text-gray-800">Cancelar</button>
                                    <button type="submit"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Asignar Materias -->
                    <div id="modalMateria"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                            <h2 class="text-xl font-bold text-indigo-600 mb-4">Asignar Materias</h2>

                            <form id="formEditar" method="POST"
                                action="<?= BASE_URL ?>Profesorcontroller/createrelation">
                                <input type="hidden" name="codigo" id="modalCodigop">
                                <div class="mb-4">
                                    <select name="area" id="area" class=" bg-gray-50 border border-gray-300 text-gray-900
                                text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                dark:focus:ring-blue-500 dark:focus:border-blue-500 ">
                                        <?php /** @var AreaDTO $area */
                                        ?>
                                        <?php foreach ($areas as $area): ?>
                                        <option value="<?= $area->getCodigo() ?>">
                                            <?= $area->getCodigo() . " - " . $area->getNombre() ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <select name="materia" id="materia" class=" bg-gray-50 border border-gray-300 text-gray-900
                                text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                dark:focus:ring-blue-500 dark:focus:border-blue-500 ">
                                        <?php /** @var MateriaDTO $materia */
                                        ?>
                                        <?php foreach ($materias as $materia): ?>
                                        <option value="<?= $materia->getId() ?>">
                                            <?= $materia->getId() . " - " . $materia->getNom_materia() ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="flex justify-end space-x-2">
                                    <button type="button" id="cerrarModalmat"
                                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 text-gray-800">Cancelar</button>
                                    <button type="submit"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                    document.getElementById('Agregar').addEventListener('click', function() {
                        document.getElementById('modalAgregar').classList.remove('hidden');
                    });
                    </script>

                    <script>
                    document.getElementById('cerrarModal').addEventListener('click', function() {
                        document.getElementById('modalEditar').classList.add('hidden');

                    });
                    document.getElementById('cerrarModalmat').addEventListener('click', function() {
                        document.getElementById('modalMateria').classList.add('hidden');

                    });
                    document.getElementById('cerrarModalagg').addEventListener('click', function() {
                        document.getElementById('modalAgregar').classList.add('hidden');

                    });
                    </script>
                    <script>
                    document.getElementById('buscarProfesor').addEventListener('input', function() {
                        const filtro = this.value.toLowerCase(); // lo que escribe el usuario
                        const filas = document.querySelectorAll('.profesor-row'); // todas las filas de la tabla

                        filas.forEach(fila => {
                            const textoFila = fila.textContent.toLowerCase();
                            if (textoFila.includes(filtro)) {
                                fila.style.display = ''; // mostrar
                            } else {
                                fila.style.display = 'none'; // ocultar
                            }
                        });
                    });
                    </script>
                </tbody>
            </table>
        </div>
        <?php if (isset($_GET['success']) || isset($_GET['error'])): ?> <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_GET['success'])): ?>
            <?php if ($_GET['success'] == 1): ?>
            Swal.fire({
                icon: 'success',
                title: '¡Profesor creado correctamente!',
                showConfirmButton: false,
                timer: 2000
            });
            <?php elseif ($_GET['success'] == 2): ?>
            Swal.fire({
                icon: 'success',
                title: '¡Profesor actualizado correctamente!',
                showConfirmButton: false,
                timer: 2000
            });
            <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
            <?php if ($_GET['error'] == 'duplicado'): ?>
            Swal.fire({
                icon: 'error',
                title: 'El código del profesor ya existe.',
                showConfirmButton: false,
                timer: 2500
            });
            <?php else: ?>
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un error.',
                showConfirmButton: false,
                timer: 2500
            });
            <?php endif; ?>
            <?php endif; ?>
        });
        </script>
        <?php endif; ?>
</body>

</html>