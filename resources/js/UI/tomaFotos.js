import Swal from "sweetalert2";
const my_camera = document.getElementById("my_camera");
const anchoVentana = (window.innerWidth > 500) ? 500 : window.innerWidth;
const altoVentana = (window.innerHeight > 500) ? 450 : window.innerHeight;
let images = [];

if (my_camera) {
    const permisoBtn = document.getElementById('permiso_camara');
    permisoBtn.addEventListener('click',function(){
        navigator.mediaDevices.getUserMedia({video: true})
    });

    inicializarCamara();
}

function inicializarCamara() {
    const take_button = document.getElementById("takesnapshot");
    const upload_button = document.getElementById("upload_button");


    let flag = true;
    navigator.mediaDevices
        .enumerateDevices()
        .then((devices) => {
            devices.forEach((device) => {
                if (device.label.includes("facing back")) {
                        flag = false;
                        Webcam.set({
                            width: anchoVentana - 10,
                            height: altoVentana,
                            image_format: "jpeg",
                            jpeg_quality: 90,
                            constraints: {
                                deviceId: { exact: device.deviceId }, // Configura el deviceId aquí
                            },
                        });
                    
                        Webcam.attach("#my_camera");
                }
            });

            if(flag){
                Webcam.set({
                    width: anchoVentana - 10,
                    height: altoVentana,
                    image_format: "jpeg",
                    jpeg_quality: 90,
                });
            
                Webcam.attach("#my_camera");
            }

        })
        .catch((error) => {
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
