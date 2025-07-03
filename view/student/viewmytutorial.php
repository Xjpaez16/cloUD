<?php 
require_once __DIR__ . '/../layouts/nav.php';
require_once(__DIR__ . '/../../app/controllers/models/DTO/EstudianteDTO.php');


if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: ' . BASE_URL . 'index.php?url=RouteController/login&error=4');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <title>Calendario Dinámico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      .gray-text {
        color: #a0aec0;
      }
    </style>
  </head>
  <body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat  font-sans "
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">
    <div class="container mx-auto mt-10">
      <div class="wrapper bg-white rounded shadow w-full">
        <div class="header flex justify-between items-center border-b p-2">
          <span id="monthYear" class="text-lg font-bold">Cargando...</span>
          <div class="buttons">
            <button onclick="prevMonth()" class="p-1">
              ⬅️
            </button>
            <button onclick="nextMonth()" class="p-1">
              ➡️
            </button>
          </div>
        </div>
        <table class="w-full">
          <thead>
            <tr>
              <th class="p-2 border-r">Dom</th>
              <th class="p-2 border-r">Lun</th>
              <th class="p-2 border-r">Mar</th>
              <th class="p-2 border-r">Mié</th>
              <th class="p-2 border-r">Jue</th>
              <th class="p-2 border-r">Vie</th>
              <th class="p-2">Sáb</th>
            </tr>
          </thead>
          <tbody id="calendar-body"></tbody>
        </table>
      </div>
    <div class="flex justify-center pt-6">
        <div class="flex gap-4 flex-wrap justify-center">
            <div class="rounded text-xs text-white px-3 py-1 bg-yellow-500">
            Pendiente
            </div>
            <div class="rounded text-xs text-white px-3 py-1 bg-green-500">
            Aceptada
            </div>
            <div class="rounded text-xs text-white px-3 py-1 bg-red-500">
            Rechazada o cancelada
            </div>
        </div>
    </div>
    </div>
    <script>
        const tutorias = <?php echo json_encode($tutorias_json)?> //mandar por json las tutorias []
        console.log(tutorias);
    </script>
    <script>
      const calendarBody = document.getElementById("calendar-body");
      const monthYear = document.getElementById("monthYear");

      let currentDate = new Date();

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

        monthYear.textContent = `${monthNames[month]} ${year}`;
        calendarBody.innerHTML = "";

        let day = 1;
        let nextMonthDay = 1;
        for (let row = 0; row < 6; row++) {
          const tr = document.createElement("tr");

          for (let col = 0; col < 7; col++) {
            const td = document.createElement("td");
           
            td.className =
              "border p-1 h-20 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 overflow-auto transition cursor-pointer duration-500 ease hover:bg-gray-300";
            const div = document.createElement("div");
            div.className =
              "flex flex-col h-20 mx-auto xl:w-40 lg:w-30 md:w-30 sm:w-full w-10 mx-auto overflow-hidden";

            const top = document.createElement("div");
            top.className = "top h-5 w-full";

            const span = document.createElement("span");

            // Días del mes anterior
            if (row === 0 && col < firstDay) {
              const prevDay = daysInPrevMonth - firstDay + col + 1;
              span.textContent = prevDay;
              span.classList.add("gray-text");
            }
            // Días del mes actual
            else if (day <= daysInMonth) {
                const currentDay = day;
                span.textContent = currentDay;

                const formattedDay = String(currentDay).padStart(2, '0');
                const formattedMonth = String(month + 1).padStart(2, '0');
                const fullDate = `${year}-${formattedMonth}-${formattedDay}`;
                td.setAttribute("data-fecha", fullDate);

               
                const bottom = document.createElement("div");
                bottom.className = "bottom flex-grow h-30 py-1 w-full";

                const tutoriasDelDia = tutorias.filter(t => t.fecha === fullDate);
                tutoriasDelDia.forEach(tutoria => {
                    const tag = document.createElement("div");
                    tag.className = "rounded text-xs text-white px-1 py-0.5 my-0.5 w-full truncate";

                    switch (tutoria.cod_estado) {
                        case 4: tag.classList.add("bg-yellow-500"); break;
                        case 5: tag.classList.add("bg-green-500"); break;
                        case 6: tag.classList.add("bg-red-500"); break;
                        default: tag.classList.add("bg-gray-400");
                    }

                    tag.innerText = `${tutoria.hora_inicio} - ${tutoria.hora_fin}  `;
                    bottom.appendChild(tag); 
                });

                div.appendChild(top);
                div.appendChild(bottom);
                td.appendChild(div);
                tr.appendChild(td);

                day++;
            }
            // Días del mes siguiente
            else {
              span.textContent = nextMonthDay++;
              span.classList.add("gray-text");
            }

            top.appendChild(span);
            div.appendChild(top);

            const bottom = document.createElement("div");
            bottom.className = "bottom flex-grow h-30 py-1 w-full";
            div.appendChild(bottom);
            td.appendChild(div);
            tr.appendChild(td);
          }

          calendarBody.appendChild(tr);

          // Salir del bucle si ya se mostraron todos los días del mes
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

      renderCalendar(currentDate);
    </script>
    
  </body>
</html>
