import { mostrarAlertas, quitarAlertas } from "../helpers";
import { validarFormularioOT2 } from "../Validación de Formularios/formulario_orden-trabajo";
import Swal from "sweetalert2";
import validator from "validator";

(function(){
    const formulario = document.getElementById('formulario4');
    let alertas = [];
    
    if(formulario){
        const estado = document.getElementById('estado').value;
        validarDatosTiempoReal();
        if(estado == 3){
            formulario.addEventListener('submit', async function(e){
                e.preventDefault();
                let alertas = validarFormularioOT2();
    
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
    function validarDatosTiempoReal(){
        const trabajo_realizado = document.getElementById('trabajo_realizado');
        const repuestos_utilizados = document.getElementById('repuestos_utilizados');

        if(trabajo_realizado){
            trabajo_realizado.addEventListener('input',function(e){
                const contenedor =  trabajo_realizado.parentElement;
                if(!(validator.isLength(trabajo_realizado.value,{max:750}))){
                   mostrarAlertas(['El texto de trabajo realizado no puede exceder los 750 caracteres'],contenedor,['text-sm'])
                }else{
                    quitarAlertas(contenedor);
                }
            })
    
            repuestos_utilizados.addEventListener('input',function(e){
                const contenedor =  repuestos_utilizados.parentElement;
                if(!(validator.isLength(repuestos_utilizados.value,{max:750}))){
                   mostrarAlertas(['El texto de repuestos utilizados no puede exceder los 750 caracteres'],contenedor,['text-sm'])
                }else{
                    quitarAlertas(contenedor);
                }
            })
    
        }
        
    }
    
    async function guardarFirmas(){  
        const firmaCanvas = document.getElementById('signature-pad-3');
        const firmaFile = await new Promise((resolve) => firmaCanvas.toBlob(resolve, 'image/png'));
        
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = "/firmas";
        const datos = new FormData();
  
        datos.append('firma',firmaFile,'firma.png');

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
                const firma = document.getElementById('firma2');
                firma.value = resultado.imagenes.firma;
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
