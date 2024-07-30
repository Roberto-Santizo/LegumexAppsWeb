import { firmaVacia, mostrarAlertas, reloadSign, quitarAlertas } from "../helpers";
import { validarDatosChecklistPreoperacional } from "../Validación de Formularios/formulario_checklist-preoperacional.js"
import SignaturePad from 'signature_pad';
import Stepper from 'bs-stepper';
import $ from 'jquery';
import validator from "validator";

(function(){
    const formulario = document.getElementById('formularioP2');
    const canvasPads = [];
    const signaturePads = [];
    const inputsText = document.querySelectorAll('.input-text');
    const observaciones = document.getElementById('observaciones');
    let alertas = [];

    if (formulario) {
        const stepper = new Stepper(document.querySelector('.bs-stepper'), { linear: false });
        const content = document.querySelectorAll('.content');
        
        $(document).ready(() => {
            inicializarFirmas();
            mostrarContenido(content, stepper._currentIndex);

            inputsText.forEach(input => {
                input.addEventListener('input',function(e){
                    const contenedor = input.parentElement;
                    if(!(validator.isLength(input.value,{max:29}))){
                        mostrarAlertas(['Excede los 29 caracteres'], contenedor,['text-xxs','w-1/2']);
                    }else{
                        quitarAlertas(contenedor);
                    }
                });
            })

            observaciones.addEventListener('input',function(e){
                const contenedor = observaciones.parentElement;
                if(!(validator.isLength(observaciones.value,{max:500}))){
                    mostrarAlertas(['Las observaciones exceden los 500 caracteres'], contenedor,['text-xs']);
                }else{
                    quitarAlertas(contenedor);
                }
            })

        });

        document.querySelector('.bs-stepper').addEventListener('show.bs-stepper', (e) => {
            mostrarActivo(stepper._currentIndex,e.detail.indexStep);
            mostrarContenido(content, e.detail.indexStep);
        });

        formulario.addEventListener('submit', async function(e) {
            e.preventDefault();
            alertas = validarDatosChecklistPreoperacional(canvasPads,inputsText,observaciones);
            if (alertas.length > 0) {
                mostrarAlertas(alertas, formulario);
                alertas = [];
                return;
            }
            let flag = await guardarFirmas();
            if(flag){
                this.submit();
            }
        });
    }

    function mostrarContenido(content, step) {
        content.forEach((cont, index) => {
            cont.style.display = index === step ? 'block' : 'none';
        });
    }

    function mostrarActivo(currentIndex,nextIndex){
        document.querySelectorAll('.step')[currentIndex].classList.toggle('bg-orange-500');
        document.querySelectorAll('.step')[currentIndex].classList.toggle('text-white');
        document.querySelectorAll('.step')[nextIndex].classList.toggle('bg-orange-500');
        document.querySelectorAll('.step')[nextIndex].classList.toggle('text-white');
    }
    function inicializarFirmas() {
        for (let i = 11; i <= 21; i++) {
            const canvas = document.getElementById(`signature-pad${i}`);
            if (canvas) {
                const signaturePad = new SignaturePad(canvas);
                signaturePads.push(signaturePad);
                canvasPads.push(canvas);

                const clearButton = document.getElementById(`clear-button${i}`);
                if (clearButton) {
                    clearButton.addEventListener('click', () => signaturePad.clear());
                }
            }
        }
    }

    async function guardarFirmas() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = "/firmas";
        const datos = new FormData();
    
        // Cambiamos el bucle para recorrer desde 11 hasta 21, que es el rango de tus inputs
        for (let i = 11; i <= 21; i++) {
            const canvas = canvasPads[i - 11]; // Ajustamos el índice
            const firmaFile = await new Promise((resolve) => canvas.toBlob(resolve, 'image/png'));
            datos.append(`firma${i - 10}`, firmaFile, `firma${i - 10}.png`); // Ajustamos el índice al guardar
        }
    
        const options = {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            body: datos
        };
    
        try {
            const respuesta = await fetch(url, options);
            const resultado = await respuesta.json();
    
            if (resultado.status) {
                // Recorremos los índices de 11 a 21 y los ajustamos para acceder al arreglo devuelto
                for (let i = 11; i <= 21; i++) {
                    const firmaInput = document.getElementById(`signature-pad${i}-input`);
                    if (firmaInput) {
                        // Ajustamos el índice para obtener el valor correcto del arreglo
                        firmaInput.value = resultado.imagenes[`firma${i - 10}`];
                    }
                }
                return true;
            } else {
                Swal.fire({
                    title: 'Ha ocurrido un error',
                    text: resultado.message,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        } catch (error) {
            console.log(error);
        }
        return false;
    }
    
    
})();
