function aplicarFiltro(){
    const filtroArea = document.getElementById('area').selectedOptions[0].text.toLowerCase();
    const filtroProfesor = document.getElementById('profesor').selectedOptions[0].text.toLowerCase();
    const filtroMateria = document.getElementById('materia').selectedOptions[0].text.toLowerCase();

    document.querySelectorAll('.archivo').forEach(el =>{
        const area = el.dataset.area.toLowerCase();
        const profesor = el.dataset.profesor.toLowerCase();
        const materia = el.dataset.materia.toLowerCase();

        const coincideArea = filtroArea === "ninguno" || area.includes(filtroArea);
        const coincideProfesor = filtroProfesor === "ninguno" || profesor.includes(filtroProfesor);
        const coincideMateria = filtroMateria === "ninguno" || materia.includes(filtroMateria);

       const visible = coincideArea && coincideProfesor && coincideMateria;
       el.style.display = visible ? 'block' : 'none';

    });
}

document.getElementById('area').addEventListener('change',aplicarFiltro);
document.getElementById('profesor').addEventListener('change',aplicarFiltro);
document.getElementById('materia').addEventListener('change',aplicarFiltro);