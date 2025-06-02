import { firmaVacia } from '../helpers';
import validator from "validator";

function validarDatosHerramientas() {
    const ChecksLavadas = document.querySelectorAll('.lavadas');
    const ChecksDesinfectadas = document.querySelectorAll('.desinfectadas');
    const formulario1 = document.getElementById('formulario1');
    const formulario2 = document.getElementById('formulario2');

    if (formulario1 || formulario2) {
        ChecksLavadas.forEach(function (checkLav) {
            checkLav.addEventListener('change', function (e) {
                CheckboxComprobacion(checkLav, ChecksLavadas, e);
            })
        });


        ChecksDesinfectadas.forEach(function (checkDes) {
            checkDes.addEventListener('change', function (e) {
                CheckboxComprobacion(checkDes, ChecksDesinfectadas, e);
            })
        });
    }

    function CheckboxComprobacion(check, Checks, e) {
        Checks.forEach(function (checkbox) {
            if ((checkbox.value == check.value)) {
                if ((checkbox.name != check.name)) {
                    checkbox.checked = false;
                }
            }
        })
    }
}
function validarDatosStore() {
    const nombreTecnico = document.getElementById('tecnico_mantenimiento').value;
    const planta = document.getElementById('planta').value;
    const area = document.getElementById('area').value;

    const entrada = document.getElementById('entrada').value;
    const observaciones_entrada = document.getElementById('observaciones_entrada').value;

    const observaciones = document.getElementById('observaciones').value;

    const herramientasLavadasArreglo = document.querySelectorAll('.lavadas');
    const herramientasDesinfectadasArreglo = document.querySelectorAll('.desinfectadas');
    const firma1 = document.getElementById('signature-pad-3');
    const firma2 = document.getElementById('signature-pad');
    const firma3 = document.getElementById('signature-pad-2');

    let array1 = [];
    let array2 = [];

    herramientasLavadasArreglo.forEach(herramienta => {
        if (herramienta.checked) {
            array1.push(herramienta.value);
        }
    });
    herramientasDesinfectadasArreglo.forEach(herramienta => {
        if (herramienta.checked) {
            array2.push(herramienta.value);
        }
    })

    let alertas = [];

    const sonIguales = array1.length === array2.length && array1.every((element, index) => element === array2[index]);
    if (!sonIguales || (array1.length == 0) || (array2.length == 0)) {
        alertas.push('Asegurese de ingresar la información de las herramientas correctamente');
    }

    if (firmaVacia(firma1) || firmaVacia(firma2) || firmaVacia(firma3)) {
        alertas.push('Asegurese de haber firmado');
    }


    if (validator.isEmpty(nombreTecnico) || !validator.isLength(nombreTecnico, { min: 10 })) {
        alertas.push('El nombre del técnico no debe ir vacío y contenedor por lo menos 10 caracteres');
    }

    if (validator.matches(nombreTecnico, /\d/)) {
        alertas.push('El nombre del técnico no debe contener números');
    }

    if (planta == '') {
        alertas.push('Seleccione una planta')
    }

    if (area == '') {
        alertas.push('Seleccione un área');
    }
    if (entrada == '') {
        alertas.push('Seleccione el estado general de la entrada de herramientas');
    }

    if (!(validator.isLength(observaciones_entrada, { max: 75 }))) {
        alertas.push('Las observaciones de entrada no pueden exceder los 75 caracteres');
    }

    if (!(validator.isLength(observaciones, { max: 120 }))) {
        alertas.push('Las observaciones generales no pueden exceder los 500 caracteres');
    }
    return alertas;
}

function validarDatosUpdate() {
    const salida = document.getElementById('salida').value;
    const observaciones_salida = document.getElementById('observaciones_salida').value;
    const observaciones = document.getElementById('observaciones').value;
    const herramientasLavadasArreglo = document.querySelectorAll('.lavadas');
    const herramientasDesinfectadasArreglo = document.querySelectorAll('.desinfectadas');
    const firma = document.getElementById('signature-pad-2');
    const firma2 = document.getElementById('signature-pad');

    let array1 = [];
    let array2 = [];

    herramientasLavadasArreglo.forEach(herramienta => {
        if (herramienta.checked) {
            array1.push(herramienta.value);
        }
    });
    herramientasDesinfectadasArreglo.forEach(herramienta => {
        if (herramienta.checked) {
            array2.push(herramienta.value);
        }
    })

    let alertas = [];

    const sonIguales = array1.length === array2.length && array1.every((element, index) => element === array2[index]);
    if (!sonIguales || (array1.length == 0) || (array2.length == 0)) {
        alertas.push('Asegurese de ingresar la información de las herramientas correctamente');
    }

    if (firmaVacia(firma) || firmaVacia(firma2)) {
        alertas.push('Asegurese de haber firmado');
    }

    if (salida == '') {
        alertas.push('Seleccione el estado general de la salida de herramientas');
    }

    if (!(validator.isLength(observaciones_salida, { max: 500 }))) {
        alertas.push('Las observaciones de salida no pueden exceder los 500 caracteres');
    }

    if (!(validator.isLength(observaciones, { max: 500 }))) {
        alertas.push('Las observaciones no deben exceder los 500 caracteres');
    }
    return alertas;
}


export { validarDatosStore, validarDatosUpdate, validarDatosHerramientas };