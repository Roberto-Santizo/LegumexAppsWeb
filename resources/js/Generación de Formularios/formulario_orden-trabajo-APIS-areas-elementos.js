(function(){
    const plantaSeleccion = document.getElementById('planta_id');
    const AreaSeleccion = document.getElementById('area_id');
    if(plantaSeleccion){
        plantaSeleccion.addEventListener('change',function(e){
            mostrarAreas(e);
        })
    }

    if(AreaSeleccion){
        AreaSeleccion.addEventListener('change',function(e){
            mostrarElementos(e);
        })
    }

    async function mostrarAreas(e){
        const url = `/api/areas/${e.target.value}`;
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        
        if(resultado.status){
            const areas = resultado.areas;
            const selectArea = document.getElementById('area_id');

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

    async function mostrarElementos(e){
        const url = `/api/areas/elementos/${e.target.value}`;
        const respuesta = await fetch(url);
        const resultado = await respuesta.json();
        
        if(resultado.status){
            const elementos = resultado.elementos;
            const selectArea = document.getElementById('elemento_id');

            while(selectArea.firstChild){
                selectArea.removeChild(selectArea.firstChild);
            }
            
            selectArea.innerHTML += '<option  value="0" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>';
            
            elementos.forEach(elemento => {
                const selectTag = `<option value="${elemento.id}" class="opcion-default">${elemento.elemento}</option>`
                selectArea.innerHTML += selectTag;
            });

            selectArea.removeAttribute('disabled');
        }
    }
})();