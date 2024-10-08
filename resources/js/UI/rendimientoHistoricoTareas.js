import { Chart, LinearScale, CategoryScale, BarController, BarElement, PointElement, LineController, LineElement, Title, Tooltip, Legend } from 'chart.js';
import Swal from "sweetalert2";
let datasets = [];

(function(){
    const grafico = document.getElementById('myChart');
    const tarea_id = document.getElementById('tarea_id');
    const form_rendimientos = document.getElementById('form_rendimientos');
    const loading_icon = document.getElementById('loading_icon');
    const alerta_datos = document.getElementById('alerta_datos');
    let myChartInstance = null;

    if (grafico) {
        form_rendimientos.addEventListener('submit',function(e){
            e.preventDefault();
            let flag = checkSelectsAndFetch();
            
            if(flag){
                loading_icon.classList.toggle('hidden');
                loading_icon.classList.toggle('flex');
                const finca_id = document.getElementById('finca_id').value;
                const year = document.getElementById('year').value;
                mostrarDatos(finca_id,year);
            }else{
                Swal.fire({
                    title: 'Error',
                    text: 'ASEGURESE DE SELECCIONAR UNA FINCA Y UN PERIODO',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                  })
            }
        });

    
    }

    async function mostrarDatos(finca_id,year) {
        Chart.register(LinearScale, CategoryScale, BarController, BarElement, PointElement, LineController, LineElement, Title, Tooltip, Legend);

        if (myChartInstance) {
            myChartInstance.destroy(); 
        }

        datasets = await obtenerRendimiento(tarea_id.value,finca_id,year);
        if(datasets.length === 0){
            alerta_datos.classList.toggle('hidden');
            loading_icon.classList.toggle('hidden');
            loading_icon.classList.toggle('flex');
            return;
        }else{
            alerta_datos.classList.toggle('hidden'); 
        }
        const labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
       
        const chartData = {
            labels: labels, 
            datasets: datasets 
        };
                
        const config = {
            type: 'bar', 
            data: chartData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true 
                    }
                }
            }
        };

        myChartInstance = new Chart(grafico, config);
        loading_icon.classList.toggle('hidden');
        loading_icon.classList.toggle('flex');
    }

    function checkSelectsAndFetch() {
        const finca_id = document.getElementById('finca_id').value;
        const year = document.getElementById('year').value;

        if (!(finca_id != '' && year != '')) {
            return false;
        }

        return true;
    }

    async function obtenerRendimiento(tarea_id,finca_id,year) {
        try {
            const url = `/api/rendimiento/${tarea_id}/${finca_id}/${year}`;
            const response = await fetch(url);
            const data = await response.json();
             
            const datasets = data.data.map(item => ({
                label: item.label, 
                data: item.datasets,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', 
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }));
            return datasets;
        } catch (error) {
            console.error('Error al obtener el rendimiento:', error);
        }
    }
    
})();
