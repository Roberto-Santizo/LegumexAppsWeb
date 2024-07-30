import { validarDatosStore } from "../Validación de Formularios/formulario_documentold";
import { mostrarAlertas,quitarAlertas } from "../helpers";
import Swal from "sweetalert2";
import validator from "validator";
(function(){
    const formulario = document.getElementById('formulario1');

    if(formulario){  
        validarDatosTiempoReal();
        formulario.addEventListener('submit',async function(e){
            e.preventDefault();
            let alertas = validarDatosStore();

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
        const observaciones_entrada = document.getElementById('observaciones_entrada');
        const observaciones = document.getElementById('observaciones');

        observaciones_entrada.addEventListener('input',function(e){
            const contenedor = observaciones_entrada.parentElement;
            if(!(validator.isLength(observaciones_entrada.value,{max:75}))){
                mostrarAlertas(['Las observaciones de entrada no deben exceder los 75 caracteres'],contenedor,['text-sm'])
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
        const firma1Canvas = document.getElementById('signature-pad');
        const firma2Canvas = document.getElementById('signature-pad-3');
        const firma3Canvas = document.getElementById('signature-pad-2');
        const firma1File = await new Promise((resolve) => firma1Canvas.toBlob(resolve, 'image/png'));
        const firma2File = await new Promise((resolve) => firma2Canvas.toBlob(resolve, 'image/png'));
        const firma3File = await new Promise((resolve) => firma3Canvas.toBlob(resolve, 'image/png'));


        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = "/firmas";
        const datos = new FormData();
  
        datos.append('firma1',firma1File,'firma1.png');
        datos.append('firma2',firma2File,'firma2.png');
        datos.append('firma3',firma3File,'firma3.png');

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
                const firma1 = document.getElementById('firma1');
                const firma2 = document.getElementById('firma2');
                const firma3 = document.getElementById('firma3');
                firma1.value = resultado.imagenes.firma1;
                firma2.value = resultado.imagenes.firma2;
                firma3.value = resultado.imagenes.firma3;
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