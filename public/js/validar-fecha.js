document.addEventListener('DOMContentLoaded', function() {
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'center',
            y: 'bottom',
        },
        dismisible: true,
        ripple: false,
        timeout: 2000,
    });
    const fechaInput = document.getElementById('fecha');
    if(!fechaInput) return;

    const diapermitido=parseInt(fechaInput.dataset.diapermitido);

    fechaInput.addEventListener('change', function() {
        const fechaSeleccionada = new Date(fechaInput.value + "T12:00:00"); 
        const diasemana = fechaSeleccionada.getDay();
        if(diasemana !==diapermitido){
               notyf.open({
                type: 'error',
                message: 'El dia no es permitido',
            });
            this.value = ''; // Limpiar el campo si la fecha no es válida
        }
    });
    const form = fechaInput.closest('form');
    if(form){
        form.addEventListener('submit',function(e){
            const fechaSeleccionada = new Date (fechaInput.value + "T12:00:00");
            if(fechaSeleccionada.getDay() !== diapermitido){
                e.preventDefault();
                 notyf.open({
                type: 'error',
                message: 'La fecha seleccionada no es permitida para el día de la semana especificado.',
            });
            }

        });
    }
    console.log("JS cargado y funcionando");

});