document.addEventListener("DOMContentLoaded", async function () {
    const desde = document.getElementById("desde");
    const hasta = document.getElementById("hasta");

    // Usa jsPDF desde el objeto global si se carga por UMD
    const { jsPDF } = window.jspdf;

    const generarPDF = (titulo, columnas, datos) => {
        const doc = new jsPDF();

    doc.setFont("helvetica", "bold");
    doc.setFontSize(16);
    doc.text(titulo, 20, 20);

    doc.autoTable({
        startY: 30,
        head: [columnas],
        body: datos,
        styles: {
            font: "helvetica",
            fontSize: 10,
            cellPadding: 4,
            textColor: [33, 33, 33], 
        },
        headStyles: {
            fillColor: [124,68,139],
            textColor: [255, 255, 255], 
            fontStyle: 'bold',
        },
        alternateRowStyles: {
            fillColor: [240, 249, 255], 
        },
        tableLineColor: [229, 231, 235], 
        tableLineWidth: 0.1,
    });

    doc.save(`${titulo}.pdf`);
    };

    const fetchData = (accion) => {
        let url = `${BASE_URL}index.php?url=ReportesController/generar&action=${accion}`;

        if ((accion === 'reporte1' || accion === 'reporte2') && (!desde.value || !hasta.value)) {
            alert("Por favor selecciona el rango de fechas.");
            return;
        }

        if (accion === 'reporte1' || accion === 'reporte2') {
            url += `&desde=${desde.value}&hasta=${hasta.value}`;
        }

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (accion === 'reporte1') generarPDF("Tutor más agendado", ["Tutor", "Sesiones"], data);
                if (accion === 'reporte2') generarPDF("Estudiante más activo", ["Estudiante", "Sesiones"], data);
                if (accion === 'reporte3') generarPDF("Top 3 Tutores Calificados", ["Tutor", "Calificación"], data);
                if (accion === 'reporte4') generarPDF("Estudiante con más archivos", ["Estudiante", "Archivos"], data);
            })
            .catch(err => console.error("Error en fetch:", err));
    };

    document.getElementById("btn-reporte1").addEventListener("click", () => fetchData("reporte1"));
    document.getElementById("btn-reporte2").addEventListener("click", () => fetchData("reporte2"));
    document.getElementById("btn-reporte3").addEventListener("click", () => fetchData("reporte3"));
    document.getElementById("btn-reporte4").addEventListener("click", () => fetchData("reporte4"));
});
