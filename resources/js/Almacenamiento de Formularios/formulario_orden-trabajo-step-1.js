import { mostrarAlertas, quitarAlertas } from "../helpers";
import { validarDatosOT } from "../Validación de Formularios/formulario_orden-trabajo";
import SignaturePad from 'signature_pad';
import Swal from "sweetalert2";
import validator from "validator";


(function(){
    const formulario = document.getElementById('formulario5');
    let alertas = [];
    
    if(formulario){
        inicializarFirma();
        validarDatosTiempoReal();
            formulario.addEventListener('submit', async function(e){
                e.preventDefault();
                let alertas = validarDatosOT();
            
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
    
    function inicializarFirma() {
        const firma1 = new SignaturePad(document.getElementById('signature-pad'));
        const firma2 = new SignaturePad(document.getElementById('signature-pad-2'));
        document.getElementById('clear-button').addEventListener('click', () => firma1.clear());
        document.getElementById('clear-button-2').addEventListener('click', () => firma2.clear());
    }

    function validarDatosTiempoReal(){
        const problema_detectado = document.getElementById('problema_detectado');
        const especifique = document.getElementById('especifique');
        const equipo_problema = document.getElementById('equipo_problema');
        const nombre_jefearea = document.getElementById('nombre_jefearea');


        problema_detectado.addEventListener('input',function(e){
            const contenedor =  problema_detectado.parentElement;
            if(!(validator.isLength(problema_detectado.value,{max:750}))){
               mostrarAlertas(['El problema detectado no pueden exceder los 750 caracteres'],contenedor,['text-sm'])
            }else{
                quitarAlertas(contenedor);
            }
        })

        especifique.addEventListener('input',function(e){
            const contenedor =  especifique.parentElement;
            if(!(validator.isLength(especifique.value,{max:60}))){
               mostrarAlertas(['El campo no debe exceder los 60 caracteres'],contenedor,['text-sm'])
            }else{
                quitarAlertas(contenedor);
            }
        })

        equipo_problema.addEventListener('input',function(e){
            const contenedor =  equipo_problema.parentElement;
            if(!(validator.isLength(equipo_problema.value,{max:60}))){
               mostrarAlertas(['El campo no debe exceder los 60 caracteres'],contenedor,['text-sm'])
            }else{
                quitarAlertas(contenedor);
            }
        })

        nombre_jefearea.addEventListener('input',function(e){
            const contenedor =  nombre_jefearea.parentElement;
            if(!(validator.isLength(nombre_jefearea.value,{max:35}))){
               mostrarAlertas(['El nombre del jefe de área no debe de exceder los 35 carcateres'],contenedor,['text-sm']);
            }else{
                quitarAlertas(contenedor);
            }
        })
    }

    async function guardarFirmas(){  
        const firmaCanvas = document.getElementById('signature-pad');
        const firmaCanvas2 = document.getElementById('signature-pad-2');
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
