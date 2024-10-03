import { error } from "jquery";
import Swal from "sweetalert2";
const my_camera = document.getElementById("my_camera");
const anchoVentana = (window.innerWidth > 500) ? 500 : window.innerWidth;
const altoVentana = (window.innerHeight > 500) ? 450 : window.innerHeight;
let images = [];

if (my_camera) {
    const permisoBtn = document.getElementById('permiso_camara');
    permisoBtn.addEventListener('click',function(){
        navigator.mediaDevices.getUserMedia({video: true}).then((stream) => {
            inicializarCamara();
        }).catch((error) => {
            Swal.fire({
                icon: 'error',
                title: 'Permiso denegado',
                text: 'Debes permitir el acceso a la cámara para tomar fotos.',
            });
        })
    });

    inicializarCamara();
}

function inicializarCamara() {
    const take_button = document.getElementById("takesnapshot");
    const upload_button = document.getElementById("upload_button");

    let flag = true;
    navigator.mediaDevices.enumerateDevices()
    .then(devices => {
        let backCameras = [];
        devices.forEach(device => {
            if (device.kind === 'videoinput' && device.label.toLowerCase().includes('back')) {
                backCameras.push({ deviceId: device.deviceId, label: device.label });
            }
        });

        const cameraOptions = document.getElementById('cameraOptions');
        const cameraOptionsContainer = document.getElementById('cameraOptionsContainer');
        if(backCameras.length > 0){
            if (backCameras.length > 1) {
                let contador = 1;
                backCameras.forEach(camera => {
                    const option = document.createElement('option');
                    option.value = camera.deviceId;
                    option.textContent = 'Camara ' + contador;
                    cameraOptions.appendChild(option);
                    contador = contador + 1;
                });
                
                cameraOptions.addEventListener('change', function () {
                    const selectedCamera = cameraOptions.value;
                    
                    try {
                        Webcam.set({
                            width: anchoVentana - 10,
                            height: altoVentana,
                            image_format: "jpeg",
                            jpeg_quality: 90,
                            constraints: {
                                deviceId: selectedCamera, 
                            },
                        });
        
                        Webcam.attach("#my_camera");
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Permiso denegado',
                            text: 'Intente con otro dispositivo de video.',
                        });
                    }
                   
                });
    
            } else {
                cameraOptionsContainer.hidden = true;
                Webcam.set({
                    width: anchoVentana - 10,
                    height: altoVentana,
                    image_format: "jpeg",
                    jpeg_quality: 90,
                    constraints: {
                        deviceId: { exact: backCameras[0].deviceId }, 
                    },
                });
            
                Webcam.attach("#my_camera");
            }
        }else{
            cameraOptionsContainer.hidden = true;
                Webcam.set({
                    width: anchoVentana - 10,
                    height: altoVentana,
                    image_format: "jpeg",
                    jpeg_quality: 90,
                });
            
                Webcam.attach("#my_camera");
        }
        
    })
    .catch(error => {
        console.error("Error al enumerar dispositivos:", error);
    });


    upload_button.addEventListener("click", function () {
        if (images.length > 0) {
            Swal.fire({
                title: "Quieres guardar las imagenes?",
                text: "Una vez guardadas no se pueden tomar más fotos o cambiar las fotos",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                denyButtonText: `No Guardar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    guardarImagenes();
                }
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Debe tomar por lo menos una foto.",
            });
        }
    });

    take_button.addEventListener("click", takeSnapshot);
}

// Función para capturar la foto
function takeSnapshot() {
    Webcam.snap(function (data_uri) {
        const imgContainer = document.createElement("div");
        imgContainer.className = "captured-image";
        imgContainer.innerHTML = `
                <div class="p-2 shadow w-full flex justify-center items-center flex-wrap gap-2">
                    <img src="${data_uri}" witdh="${anchoVentana}" height="${altoVentana}"/>
                </div>
            `;
        document.getElementById("results").appendChild(imgContainer);

        images.push(data_uri);
    });
}

async function guardarImagenes() {
    const loadingIcon = document.getElementById("loading_icon");
    loadingIcon.classList.toggle("hidden");
    const datos = new FormData();
    const url = "/api/imagenes/upload";
    const folder_id = document.getElementById("folder_id");

    const base64ToBlob = (base64, type = "image/jpeg") => {
        const [header, data] = base64.split(",");
        const byteCharacters = atob(data);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        return new Blob([new Uint8Array(byteNumbers)], { type });
    };

    // Agrega imágenes a FormData
    images.forEach((base64, index) => {
        const blob = base64ToBlob(base64, "image/jpeg");
        datos.append(`imagenes${index + 1}`, blob, `firma${index + 1}.jpg`);
    });

    if (folder_id != "") {
        datos.append("folder_id", folder_id.value);
    }

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: datos,
    });

    const result = await response.json();
    if (result.status) {
        const folder_url = document.getElementById("folder_url");
        const folder_id = document.getElementById("folder_id");
        const camera = document.getElementById("camera");

        if (folder_id.value == "" || folder_id == "") {
            folder_url.value = result.folder_url;
            folder_id.value = result.folder_id;
        }

        camera.classList.add("hidden");

        Swal.fire({
            title: "Imagenes subidas correctamente!",
            text: "Las imagenes fueron subidas correctamente",
            icon: "success",
            confirmButtonText: "Ok",
        }).then(() => {
            loadingIcon.classList.toggle("hidden");
        });
    }else{
        Swal.fire({
            title: "Error!",
            text: "Hubo un error al subir las imagenes, intentelo de nuevo más tarde!",
            icon: "error",
            confirmButtonText: "Ok",
        }).then(() => {
            loadingIcon.classList.toggle("hidden");
        });
    }
}

export { inicializarCamara };
