import { validarDatosUpdate } from "../Validación de Formularios/formulario_documentold";
import { mostrarAlertas, quitarAlertas } from "../helpers";
import Swal from "sweetalert2";
import validator from "validator";
(function(){
    const formulario = document.getElementById('formulario2');

    if(formulario){ 
        validarDatosTiempoReal(); 
        formulario.addEventListener('submit',async function(e){
            e.preventDefault();
            let alertas = validarDatosUpdate();

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


    function validarDatosTiempoReal(){
        const observaciones_salida = document.getElementById('observaciones_salida');
        const observaciones = document.getElementById('observaciones');

        observaciones_salida.addEventListener('input',function(e){
            const contenedor = observaciones_salida.parentElement;
            if(!(validator.isLength(observaciones_salida.value,{max:75}))){
                mostrarAlertas(['Las observaciones de salida no deben exceder los 75 caracteres'],contenedor,['text-sm'])
            }else{
                quitarAlertas(contenedor);
            }
        })

        observaciones.addEventListener('input',function(e){
            const contenedor = observaciones.parentElement;
            if(!(validator.isLength(observaciones.value,{max:120}))){
                mostrarAlertas(['Las observaciones no deben exceder los 120 caracteres'],contenedor,['text-sm'])
            }else{
                quitarAlertas(contenedor);
            }
        })
    }
    async function guardarFirmas(){
        const firmaCanvas = document.getElementById('signature-pad-2');
        const firma2Canvas = document.getElementById('signature-pad');

        const firmaFile = await new Promise((resolve) => firmaCanvas.toBlob(resolve, 'image/png'));
        const firma2File = await new Promise((resolve) => firma2Canvas.toBlob(resolve, 'image/png'));
        
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = "/firmas";
        const datos = new FormData();
  
        datos.append('firma',firmaFile,'firma.png');
        datos.append('firma2',firma2File,'firma2.png');

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
                const firma2 = document.getElementById('firma');
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