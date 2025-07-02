document.addEventListener('DOMContentLoaded', function() {
    const fechaInput = document.getElementById('fecha');
    if(!fechaInput) return;

    const diapermitido=parseInt(fechaInput.dataset.diapermitido);

    fechaInput.addEventListener('change', function() {
        const  fechaSeleccionada = new Date(this.value);
        const diasemana = fechaSeleccionada.getDay();
        if(diasemana !==diapermitido){
            alert('La fecha seleccionada no es permitida para el día de la semana especificado.');
            this.value = ''; // Limpiar el campo si la fecha no es válida
        }
    });
    const form = fechaInput.closest('form');
    if(form){
        form.addEventListener('submit',function(e){
            const fechaSeleccionada = new Date (fechaInput.value);
            if(fechaSeleccionada.getDay() !== diapermitido){
                e.preventDefault();
                alert('La fecha seleccionada no es permitida para el día de la semana especificado.');
            }

        });
    }
    console.log("JS cargado y funcionando");

});