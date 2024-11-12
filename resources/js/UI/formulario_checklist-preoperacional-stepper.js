import { firmaVacia, mostrarAlertas, reloadSign, quitarAlertas } from "../helpers";
import SignaturePad from 'signature_pad';
import Stepper from 'bs-stepper';
import $ from 'jquery';
import validator from "validator";

(function(){
    const formulario = document.getElementById('formularioCP');
    const canvasPads = [];
    const signaturePads = [];
    const inputsText = document.querySelectorAll('.input-text');
    const observaciones = document.getElementById('observaciones');
    let alertas = [];

    if (formulario) {
        const stepper = new Stepper(document.querySelector('.bs-stepper'), { linear: false });
        const content = document.querySelectorAll('.content');

        $(document).ready(() => {
            const total_firmas = document.getElementById('total_firmas').value;
            inicializarFirmas(total_firmas);
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
                    mostrarAlertas(['Las observaciones exceden los 500 caracteres'], contenedor, ['text-xs']);
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
            alertas = validarDatos();
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
    function inicializarFirmas(total_firmas) {
        for (let i = 0; i <= total_firmas; i++) {
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

    function validarDatos() {
        const checks = document.querySelectorAll('.table__check');
        const alertas = [];

        for(const input of inputsText){
            if(!(validator.isLength(input.value,{max:29}))){
                alertas.push('Los textos de problemas y acciones deben ser menos de 29 caracteres de lo contrario el documento no se genenarará de la manera correcta');
                break;
            }
        }

        if(!(validator.isLength(observaciones.value,{max:500}))){
            alertas.push('Las observaciones generales no pueden exceder los 500 caracteres');
        }
            
        for (const canvas of canvasPads) {
            if (firmaVacia(canvas)) {
                alertas.push("Asegurese de haber revisado todas las áreas");
                break;
            }
        }

        checks.forEach(check => {
            const problema = document.querySelector(`.problem-${check.dataset.id}`).value;
            const action = document.querySelector(`.action-${check.dataset.id}`).value;
            const responsable = document.getElementById(`responsable-${check.dataset.id}`).value;

            if(!check.checked){
                if (problema == '' || action == '' || !responsable) {
                    alertas.push("Una o varias ubicaciones se encuentran en estado NO OK, asegúrese de haber colocado la información correspondiente");
                }
            }
        });
        
        return alertas;
    }


    async function guardarFirmas() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = "/firmas";
        const datos = new FormData();
    
        for (let i = 0; i < canvasPads.length; i++) {
            const canvas = canvasPads[i];
            const firmaFile = await new Promise((resolve) => canvas.toBlob(resolve, 'image/png'));
            datos.append(`firma${i + 1}`, firmaFile, `firma${i + 1}.png`);
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
                for (let i = 1; i < canvasPads.length+1; i++) {
                    const firmaInput = document.getElementById(`signature-pad${i}-input`);
                    if (firmaInput) {
                        firmaInput.value = resultado.imagenes[`firma${i}`];
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
