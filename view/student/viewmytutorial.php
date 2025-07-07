<?php
require_once __DIR__ . '/../layouts/nav.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
    exit();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tutorías | cloUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .gray-text { color: #a0aec0; }
        .calendar-day { height: 120px; }
        @media (max-width: 640px) {
            .calendar-day { height: 80px; font-size: 0.8rem; }
        }
    </style>
</head>
<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat font-sans"
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">
    
    <div class="container mx-auto mt-10 px-4">
        <div class="wrapper bg-white rounded-lg shadow-lg w-full">
            <div class="header flex justify-between items-center border-b p-4">
                <span id="monthYear" class="text-xl font-bold text-gray-800">Cargando...</span>
                <div class="buttons flex space-x-2">
                    <button onclick="prevMonth()" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-full">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="nextMonth()" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-full">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="p-2 border-r text-sm font-medium text-gray-500">Dom</th>
                        <th class="p-2 border-r text-sm font-medium text-gray-500">Lun</th>
                        <th class="p-2 border-r text-sm font-medium text-gray-500">Mar</th>
                        <th class="p-2 border-r text-sm font-medium text-gray-500">Mié</th>
                        <th class="p-2 border-r text-sm font-medium text-gray-500">Jue</th>
                        <th class="p-2 border-r text-sm font-medium text-gray-500">Vie</th>
                        <th class="p-2 text-sm font-medium text-gray-500">Sáb</th>
                    </tr>
                </thead>
                <tbody id="calendar-body"></tbody>
            </table>
        </div>

        <div class="flex justify-center pt-6 pb-20">
            <div class="flex gap-4 flex-wrap justify-center">
                <div class="rounded text-xs text-white px-3 py-1 bg-yellow-500">
                    <i class="fas fa-clock mr-1"></i> Pendiente
                </div>
                <div class="rounded text-xs text-white px-3 py-1 bg-green-500">
                    <i class="fas fa-check mr-1"></i> Aceptada
                </div>
                <div class="rounded text-xs text-white px-3 py-1 bg-red-500">
                    <i class="fas fa-times mr-1"></i> Cancelada
                </div>
            </div>
        </div>
    </div>

    <!-- Botón flotante para cancelaciones -->
    <div class="fixed bottom-6 right-6 z-40">
        <button onclick="document.getElementById('cancelationModal').classList.remove('hidden')" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-full shadow-xl flex items-center transition-all">
            <i class="fas fa-calendar-times mr-2"></i> 
            <span class="hidden md:inline">Cancelar Tutorías</span>
        </button>
        
    </div>

    <!-- Modal de cancelación integrado -->
    <div id="cancelationModal" class="fixed inset-0 bg-black bg-opacity-50  items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden mx-4">
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-bold text-gray-800">Tutorías Pendientes</h3>
                <button onclick="document.getElementById('cancelationModal').classList.add('hidden')" 
                        class="text-gray-500 hover:text-gray-700 text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-4 overflow-y-auto">
                <?php if (empty($tutoriasPendientes)): ?>
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-check text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">No tienes tutorías pendientes para cancelar.</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach ($tutoriasPendientes as $tutoria): ?>
                            <?php error_log("Tutorías pendientes: " . $tutoria->getId());?>
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            <i class="far fa-calendar-alt text-blue-500 mr-2"></i>
                                            <?= htmlspecialchars($tutoria->getFecha()) ?>
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <i class="far fa-clock text-blue-500 mr-2"></i>
                                            <?= htmlspecialchars($tutoria->getHora_inicio()) ?> - <?= htmlspecialchars($tutoria->getHora_fin()) ?>
                                        </p>
                                    </div>

                                    <button onclick="document.getElementById('cancelForm<?= $tutoria->getId() ?>').classList.toggle('hidden')" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm flex items-center">
                                        <i class="fas fa-ban mr-1"></i> Cancelar
                                    </button>
                                </div>
                                
                                <form id="cancelForm<?= $tutoria->getId() ?>" 
                                      action="<?= BASE_URL ?>index.php?url=RouteController/processCancelation" 
                                      method="POST"
                                      class="hidden mt-3 p-3 bg-gray-50 rounded-lg">
                                    <input type="hidden" name="id_tutoria" value="<?= $tutoria->getId() ?>">
                                    <?php error_log ('id tutoria: ' . $tutoria->getId());?>
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="fas fa-comment-alt text-blue-500 mr-1"></i> Motivo:
                                        </label>
                                        <select name="motivo" required 
                                                class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <?php foreach ($motivos as $motivo): ?>
                                                <option value="<?= $motivo->getCodigo() ?>">
                                                    <?= htmlspecialchars($motivo->getTipo_motivo()) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" onclick="document.getElementById('cancelForm<?= $tutoria->getId() ?>').classList.add('hidden')" 
                                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-1 rounded-lg text-sm">
                                            <i class="fas fa-arrow-left mr-1"></i> Volver
                                        </button>
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
                                            <i class="fas fa-check mr-1"></i> Confirmar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        
    function convertirA12Horas(hora24) {
    const [hora, minutos] = hora24.split(':').map(Number);
    const ampm = hora >= 12 ? 'PM' : 'AM';
    const hora12 = (hora % 12) || 12; // El 0 se convierte en 12
    return `${hora12}:${minutos.toString().padStart(2, '0')} ${ampm}`;
    }
        const tutorias = <?php echo json_encode($tutorias_json) ?>;

        function renderCalendar(date) {
            const year = date.getFullYear();
            const month = date.getMonth();

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();

            const monthNames = [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ];

            document.getElementById("monthYear").textContent = `${monthNames[month]} ${year}`;
            document.getElementById("calendar-body").innerHTML = "";

            let day = 1;
            let nextMonthDay = 1;
            
            for (let row = 0; row < 6; row++) {
                const tr = document.createElement("tr");

                for (let col = 0; col < 7; col++) {
                    const td = document.createElement("td");
                    td.className = "border p-1 calendar-day overflow-hidden transition cursor-pointer duration-300 ease hover:bg-gray-100";
                    
                    const div = document.createElement("div");
                    div.className = "flex flex-col h-full";

                    const top = document.createElement("div");
                    top.className = "top h-6 flex items-center justify-center";

                    const span = document.createElement("span");
                    span.className = "text-sm font-medium";

                    if (row === 0 && col < firstDay) {
                        const prevDay = daysInPrevMonth - firstDay + col + 1;
                        span.textContent = prevDay;
                        span.classList.add("gray-text");
                    }
                    else if (day <= daysInMonth) {
                        const currentDay = day;
                        span.textContent = currentDay;

                        const formattedDay = String(currentDay).padStart(2, '0');
                        const formattedMonth = String(month + 1).padStart(2, '0');
                        const fullDate = `${year}-${formattedMonth}-${formattedDay}`;
                        td.setAttribute("data-fecha", fullDate);

                        const bottom = document.createElement("div");
                        bottom.className = "bottom flex-grow overflow-y-auto py-1";

                        const tutoriasDelDia = tutorias.filter(t => t.fecha === fullDate);
                        tutoriasDelDia.forEach(tutoria => {
                            const tag = document.createElement("div");
                            tag.className = "rounded text-xs text-white px-1 py-0.5 my-0.5 w-full truncate flex items-center";

                            switch (tutoria.cod_estado) {
                                case 4: 
                                    tag.classList.add("bg-yellow-500");
                                    tag.innerHTML = `<i class="fas fa-clock mr-1"></i> ${convertirA12Horas(tutoria.hora_inicio)} - ${convertirA12Horas(tutoria.hora_fin)}`;
                                    break;
                                case 5: 
                                    tag.classList.add("bg-green-500");
                                    tag.innerHTML = `<i class="fas fa-check mr-1"></i>${convertirA12Horas(tutoria.hora_inicio)} - ${convertirA12Horas(tutoria.hora_fin)}`;
                                    break;
                                case 6: 
                                    tag.classList.add("bg-red-500");
                                    tag.innerHTML = `<i class="fas fa-times mr-1"></i>${convertirA12Horas(tutoria.hora_inicio)} - ${convertirA12Horas(tutoria.hora_fin)}`;
                                    break;
                                default: 
                                    tag.classList.add("bg-gray-400");
                                    tag.textContent = tutoria.hora_inicio;
                            }

                            bottom.appendChild(tag); 
                        });

                        div.appendChild(top);
                        div.appendChild(bottom);
                        td.appendChild(div);
                        tr.appendChild(td);

                        day++;
                    }
                    else {
                        span.textContent = nextMonthDay++;
                        span.classList.add("gray-text");
                    }

                    top.appendChild(span);
                    div.appendChild(top);
                    td.appendChild(div);
                    tr.appendChild(td);
                }

                document.getElementById("calendar-body").appendChild(tr);
                if (day > daysInMonth) break;
            }
        }

        function prevMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        }

        // Inicializar calendario
        let currentDate = new Date();
        renderCalendar(currentDate);
    </script>
</body>
</html>