import { mostrarAlertas } from "../helpers";
import { validarFormularioOT1 } from "../Validación de Formularios/formulario_orden-trabajo";
import Swal from "sweetalert2";


(function(){
    const formulario = document.getElementById('formulario4');
    let alertas = [];
    
    if(formulario){
        const estado = document.getElementById('estado').value;
        if(estado == 2){
            formulario.addEventListener('submit', async function(e){
                e.preventDefault();

                let alertas = validarFormularioOT1();
    
                if(alertas.length > 0){
                    mostrarAlertas(alertas,formulario);
                    alertas = [];
                    return;
                }
    
                let flag = await guardarFirmas();
    
                if(flag){
                    this.submit();
                }
            })
        }
    }
    
    async function guardarFirmas(){  
        const firmaCanvas = document.getElementById('signature-pad-2');
        const firmaCanvas2 = document.getElementById('signature-pad-3');
        const firmaFile = await new Promise((resolve) => firmaCanvas.toBlob(resolve, 'image/png'));
        const firmaFile2 = await new Promise((resolve) => firmaCanvas2.toBlob(resolve, 'image/png'));
        
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = "/firmas";
        const datos = new FormData();
  
        datos.append('firma',firmaFile,'firma.png');
        datos.append('firma2',firmaFile2,'firma2.png');

        var options = {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
                },
            body: datos
        }

        try { 
            const respuesta = await fetch(url,options);
            const resultado = await respuesta.json();
    
            if(resultado.status){
                const firma = document.getElementById('firma');
                const firma2 = document.getElementById('firma2');
               
                firma.value = resultado.imagenes.firma;
                firma2.value = resultado.imagenes.firma2;
                return true;
            }else{
                Swal.fire({
                    title: 'Ha ocurrido un error',
                    text: resultado.message,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                  })
            }
            
        } catch (error) {
            console.log(error);
        }
        return false;
    }

})();
