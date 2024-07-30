import SignaturePad from 'signature_pad';
import { mostrarAlertas, quitarAlertas, scrollTop } from '../helpers';
import { validarDatosOTVM } from '../Validación de Formularios/formulario_orden-trabajo';
import Swal from "sweetalert2";
import validator from 'validator';
(function () {
    const formulario = document.getElementById('formularioP1');
    const formulario2 = document.getElementById('formularioP2');
    const formulario3 = document.getElementById('formularioP3');
    const buttons = document.querySelectorAll('.create-ot');
    let btnTarget = '', planta_id = '', area_id = '', elemento_id = '', equipo_id = '';

    if (formulario || formulario2 || formulario3) {
        buttons.forEach(button => button.addEventListener('click', async function (e) {
            if (await consultarOT(e.target.dataset.planta, e.target.dataset.area, e.target.dataset.elemento, 1)) {
                [planta_id, area_id, elemento_id, equipo_id, btnTarget] = [e.target.dataset.planta, e.target.dataset.area, e.target.dataset.elemento, e.target.dataset.elemento, e.target];
                ModalOT();
            }
        }));
    }

    function ModalOT() {
        const modal = document.createElement('div');
        modal.innerHTML = `
        <div id="myModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl transform transition-all w-1/2 h-4/5 overflow-y-auto">
                <div class="px-4 py-5 sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-bold text-gray-900 uppercase" id="modal-title">Formulario para Orden De Trabajo</h3>
                            <div class="w-full mt-10">
                                <p class="text-sm text-gray-500">
                                    <form method="POST" action="/administracion/orden-trabajo/store" id="formulario4">
                                        <fieldset class="p-5 mb-10 shadow-2xl">
                                            <legend class="text-xl font-bold uppercase">Datos generales de la Orden</legend>
                                            <div class="mb-5">
                                                <label for="retiro_equipo" class="mb-2 block uppercase text-gray-500 font-bold">¿Es necesario retirar el equipo?</label>
                                                <select name="retiro_equipo" id="retiro_equipo" class="w-full p-4 rounded bg-gray-50">
                                                    <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                                                    <option value="1">SI</option>
                                                    <option value="2">NO</option>
                                                </select>                                
                                            </div>
                                            <div class="mb-5 flex flex-col gap-2">
                                                <label for="problema_detectado" class="inline-block uppercase text-gray-500 font-bold">Antecedentes/Problema detectado:</label>
                                                <textarea id="problema_detectado" name="problema_detectado" rows="4" cols="50" class="border"></textarea>
                                            </div>
                                            <div class="mb-5">
                                                <label for="urgencia" class="mb-2 block uppercase text-gray-500 font-bold">Urgencia del Trabajo:</label>
                                                <select name="urgencia" id="urgencia" class="w-full p-4 rounded bg-red-50">
                                                    <option value="" class="opcion-defaul" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                                                    <option value="1" class="bg-red-500 text-white">URGENTE</option>
                                                    <option value="2" class="bg-yellow-500 text-white">MEDIA</option>
                                                    <option value="3" class="bg-green-500 text-white">BAJA</option>
                                                </select>                                
                                            </div>
                                            <div class="mb-5 flex gap-2 items-center">
                                                <label for="fecha_propuesta" class="inline-block uppercase text-gray-500 font-bold">Fecha propuesta de entrega:</label>
                                                <input type="date" name="fecha_propuesta" id="fecha_propuesta" min="${new Date().toISOString().split('T')[0]}">                              
                                            </div>
                                        </fieldset>
                                        <fieldset class="p-5 mb-10 shadow-2xl">
                                            <legend class="text-xl font-bold uppercase">Datos del jefe de área</legend>
                                            <div class="mt-5">
                                                <label for="nombre_jefearea" class="mb-2 block uppercase text-gray-500 font-bold">Nombre del jefe de Área:</label>
                                                <input autocomplete="off" type="text" id="nombre_jefearea" name="nombre_jefearea" placeholder="Nombre del jefe de área" class="border p-3 w-full rounded-lg">
                                            </div>
                                            <div class="flex justify-center items-center flex-col">
                                                <canvas id="signature-pad-2" width="400" height="200" class="bg-gray-50 mt-10 rounded-xl border border-black"></canvas>
                                                <div class="clear_btn flex justify-center items-center flex-col mt-3">
                                                    <h4 class="font-bold uppercase">Firma del jefe de área</h4>
                                                    <div id="clear-button-2" class="inline-block mt-2 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear"><span>Limpiar</span></div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="p-5 mb-2 shadow-2xl">
                                            <legend class="text-xl font-bold uppercase">Datos del solicitante</legend>
                                            <div class="flex justify-center items-center flex-col">
                                                <canvas id="signature-pad" width="400" height="200" class="bg-gray-50 mt-10 rounded-xl border border-black"></canvas>
                                                <div class="clear_btn flex justify-center items-center flex-col mt-3">
                                                    <h4 class="font-bold uppercase">Firma del solicitante</h4>
                                                    <div id="clear-button" class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear"><span>Limpiar</span></div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <input type="hidden" value="" id="firma1">
                                        <input type="hidden" value="" id="firma2">
                                        <input id="btnSaveOT" type="submit" value="Guardar" class="inline-block mt-5 bg-blue-600 hover:bg-blue-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
                                    </form>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="closeModalBtn" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 uppercase text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2  sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </div>
        </div>`;
        document.body.appendChild(modal);

        inicializarFirma();
        modalActions(modal);
        guardarDatos(modal);
    }

    function guardarDatos(modal) {
        const formulario = document.getElementById('formulario4'); 
        formulario.addEventListener('submit', async function (e) {
            e.preventDefault();

            const alertas = validarDatosOTVM();
            if (alertas.length > 0) {
                mostrarAlertas(alertas, formulario,['text-md']);
                    modal.querySelector('.bg-white').scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                return;
            }
            if (await guardarFirma()) {
                try {
                    await save(); 
                    document.body.removeChild(modal);
                } catch (error) {
                    console.error('Error al guardar la Orden de Trabajo:', error);
                    Swal.fire('Error', 'Hubo un problema al guardar la Orden de Trabajo', 'error');
                }
            }
        });
    }

    function inicializarFirma() {
        const firma1 = new SignaturePad(document.getElementById('signature-pad'));
        const firma2 = new SignaturePad(document.getElementById('signature-pad-2'));
        document.getElementById('clear-button').addEventListener('click', () => firma1.clear());
        document.getElementById('clear-button-2').addEventListener('click', () => firma2.clear());
    }

    function modalActions(modal) {
        document.getElementById('closeModalBtn').addEventListener('click', () => document.body.removeChild(modal));
        const problema_detectado = document.getElementById('problema_detectado');
        const nombre_jefearea = document.getElementById('nombre_jefearea');

        problema_detectado.addEventListener('input',function(e){
            const contenedor =  problema_detectado.parentElement;
            if(!(validator.isLength(problema_detectado.value,{max:750}))){
               mostrarAlertas(['El problema detectado no pueden exceder los 750 caracteres'],contenedor,['text-sm'])
            }else{
                quitarAlertas(contenedor);
            }
        })

        nombre_jefearea.addEventListener('input',function(e){
            const contenedor =  nombre_jefearea.parentElement;
            if(!(validator.isLength(nombre_jefearea.value,{max:35}))){
               mostrarAlertas(['El nombre del jefe de área no puede exceder los 35 caracteres'],contenedor,['text-sm'])
            }else{
                quitarAlertas(contenedor);
            }
        })
    }

    async function guardarFirma() {
        const formulario = document.getElementById('formulario4'); 
        const firma1Canvas = document.getElementById('signature-pad');
        const firma2Canvas = document.getElementById('signature-pad-2');
        const [firma1File, firma2File] = await Promise.all([
            new Promise(resolve => firma1Canvas.toBlob(resolve, 'image/png')),
            new Promise(resolve => firma2Canvas.toBlob(resolve, 'image/png'))
        ]);
        const datos = new FormData();
        datos.append('firma1', firma1File, 'firma1.png');
        datos.append('firma2', firma2File, 'firma2.png');

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = "/firmas";
        try {
            const respuesta = await fetch(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': token }, body: datos });
            const resultado = await respuesta.json();
            if (resultado.imagenes.firma1 || resultado.imagenes.firma2) {
                document.getElementById('firma1').value = resultado.imagenes.firma1;
                document.getElementById('firma2').value = resultado.imagenes.firma2;
                return true;
            } else {
                mostrarAlertas(['Hubo un error al guardar las firmas'],formulario);
                return false;
            }
        } catch (error) {
            mostrarAlertas(['Error de conexión'],formulario);
            return false;
        }
    }

    async function save() {
        const datos = {
            retiro_equipo: document.getElementById('retiro_equipo').value,
            problema_detectado: document.getElementById('problema_detectado').value,
            urgencia: document.getElementById('urgencia').value,
            fecha_propuesta: document.getElementById('fecha_propuesta').value,
            nombre_jefearea: document.getElementById('nombre_jefearea').value,
            firma_solicitante: document.getElementById('firma1').value,
            firma_jefearea: document.getElementById('firma2').value,
            planta_id, // Asegúrate de que estos valores estén definidos en tu código
            area_id,   // Asegúrate de que estos valores estén definidos en tu código
            elemento_id, // Asegúrate de que estos valores estén definidos en tu código
            equipo_id,   // Asegúrate de que estos valores estén definidos en tu código
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
    
        const url = "/administracion/ordenes-trabajos/store";
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': datos._token
            },
            credentials: 'same-origin', // Esto asegurará que las cookies de sesión se envíen con la solicitud
            body: JSON.stringify(datos)
        });
    
        if (response.ok) {
            const respuesta = await response.json();
            Swal.fire('Guardado', 'La Orden de Trabajo se creó correctamente', 'success').then(() => {
                btnTarget.querySelector('input[type="hidden"]').value = respuesta.id;
                btnTarget.classList.add('hidden');
            });
        } else {
            btnTarget.querySelector('input[type="hidden"]').value = 0;
            btnTarget.classList.add('hidden');
            Swal.fire('Error', 'Hubo un problema al guardar la Orden de Trabajo', 'error');
        }
    }
    

    async function consultarOT(planta_id, area_id, elemento_id, estado_id) {
        const url = `/administracion/orden-trabajo/${planta_id}/${area_id}/${elemento_id}/${estado_id}`;
        const response = await fetch(url);
        const data = await response.json();
        if (data.exists) {
            const result = await Swal.fire({
                title: "Ya existe una orden de trabajo",
                html: `
                    <div class="bg-gray-100 p-5 rounded-2xl text-start shadow-xl">
                        <div>
                            <p class="font-bold">Problema reportado anteriormente: </p>
                            <p>${data.ot.problema_detectado}</p> 
                        </div>

                        <div>
                            <p class="font-bold">Nombre del solicitante: </p>
                            <p>${data.ot.nombre_solicitante}</p> 
                        </div>

                        <div>
                            <p class="font-bold">Fecha en la que se solicito: </p>
                            <p>${data.ot.created_at}</p> 
                        </div>

                    </div>
                    <p class="mt-5 uppercase font-bold ">¿Quieres crear una nueva orden de trabajo?</p>
                `,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, deseo crear otra",
                cancelButtonText: "No, no deseo crear otra"
            });
            return result.isConfirmed;
        } else {
            return true;
        }
    }
})();
