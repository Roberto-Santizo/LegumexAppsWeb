(function(){
    const plantaSeleccion = document.getElementById('planta');
    if(plantaSeleccion){
        plantaSeleccion.addEventListener('change',function(e){
            mostrarAreas(e);
        })
    }

    async function mostrarAreas(e){
        const url = `/api/areas/${e.target.value}`;
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        
        if(resultado.status){
            const areas = resultado.areas;
            const selectArea = document.getElementById('area');

            while(selectArea.firstChild){
                selectArea.removeChild(selectArea.firstChild);
            }
            
            selectArea.innerHTML += '<option  value="0" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>';
            
            areas.forEach(area => {
                const selectTag = `<option value="${area.id}" class="opcion-default">${area.area}</option>`
                selectArea.innerHTML += selectTag;
            });

            selectArea.removeAttribute('disabled');
        }
    }
})();