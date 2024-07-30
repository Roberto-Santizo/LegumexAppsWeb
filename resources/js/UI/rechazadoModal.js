import { validarDatosUpdate } from "../Validación de Formularios/formulario_documentold";
import { mostrarAlertas, quitarAlertas } from "../helpers";
import Swal from "sweetalert2";
import validator from "validator";

(function () {
    const rechazarBtn = document.getElementById("rechazarBtn");
    var url = window.location.href;
    var urlObj = new URL(url);
    const orden_trabajo_id = urlObj.pathname.split("/").pop();

    rechazarBtn.addEventListener("click", function (e) {
        mostrarModal();
        validarDatosTiempoReal();
    });

    function mostrarModal() {
        const modal = document.createElement("div");
        modal.innerHTML = `
            <div id="myModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl transform transition-all w-4/5 md:w-1/2 h-3/4 overflow-y-auto">
                <div class="px-4 py-5 sm:p-6 flex flex-col">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-bold text-gray-900 uppercase" id="modal-title">Rechazo de orden de trabajo</h3>
                            <div class="w-full mt-10">
                                <form id="formulario_rechazo">
                                    <div class="mb-5">
                                        <label for="observaciones_eliminacion" class="mb-2 block uppercase text-gray-500 font-bold">Explique porque se esta rechazando</label>
                                         <textarea id="observaciones_eliminacion" name="observaciones_eliminacion" rows="10" cols="50" class="border w-full"></textarea>                            
                                    </div>

                                    <input id="btnRechazar" type="submit" value="Rechazar orden" class="inline-block mt-5 bg-red-600 hover:bg-red-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="closeModalBtn" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 uppercase text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2  sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </div>
        </div>
        `;

        document.body.append(modal);

        const modalBackground = document.getElementById("myModal");
        const closeModalBtn = document.getElementById("closeModalBtn");

        closeModalBtn.addEventListener("click", () =>
            document.body.removeChild(modal)
        );

        modalBackground.addEventListener("click", (e) => {
            if (e.target === modalBackground) {
                document.body.removeChild(modal);
            }
        });

        document
            .getElementById("formulario_rechazo")
            .addEventListener("submit", function (e) {
                e.preventDefault();
                guardarDatos();
            });
    }

    async function guardarDatos() {
        const datos = new FormData();
        const url = "/administracion/orden-trabajo/rechazar";
        const token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const observaciones_eliminacion = document.getElementById('observaciones_eliminacion').value;

        datos.append("id", orden_trabajo_id);
        datos.append("observaciones_eliminacion", observaciones_eliminacion);
        var options = {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            body: datos,
        };
        try {
            const respuesta = await fetch(url, options);
            const resultado = await respuesta.json();

            if (resultado.status) {
                Swal.fire({
                    title: "Listo!",
                    text: "La orden de trabajo ha sido rechazada!",
                    icon: "success",
                    confirmButtonText: "Ok",
                }).then(() => {
                    window.location.href = '/administracion/ordenes-trabajos'
                });
            } else {
                Swal.fire({
                    title: "Ha ocurrido un error",
                    text: resultado.message,
                    icon: "error",
                    confirmButtonText: "Ok",
                });
            }
        } catch (error) {
            console.log(error);
        }

    }

    function validarDatosTiempoReal() {
        const observaciones_eliminacion = document.getElementById(
            "observaciones_eliminacion"
        );

        observaciones_eliminacion.addEventListener("input", function (e) {
            const contenedor = observaciones_eliminacion.parentElement;
            if (
                !validator.isLength(observaciones_eliminacion.value, {
                    max: 520,
                })
            ) {
                mostrarAlertas(
                    [
                        "Las observaciones de rechazo no puede exceder los 520 caracteres",
                    ],
                    contenedor,
                    ["text-sm"]
                );
            } else {
                quitarAlertas(contenedor);
            }
        });
    }
})();
