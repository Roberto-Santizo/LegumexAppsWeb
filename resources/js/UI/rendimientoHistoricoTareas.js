import { Chart, LinearScale, CategoryScale, BarController, BarElement, PointElement, LineController, LineElement, Title, Tooltip, Legend } from 'chart.js';

let datos = [];

(async function(){
    const grafico = document.getElementById('myChart');
    
    if (grafico) {
        Chart.register(LinearScale, CategoryScale, BarController, BarElement, PointElement, LineController, LineElement, Title, Tooltip, Legend);
        datos = await obtenerRendimiento(2);
        const labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        console.log(datos.data);
        // const data = {
        //     labels: labels,
        //     datasets: datos
        // };

        // console.log(data);

        // const config = {
        //     type: 'line', // Tipo de gráfico
        //     data: data,
        //     options: {
        //         responsive: true,
        //         scales: {
        //             y: {  // Escala Y para Finca Alameda
        //                 beginAtZero: true,
        //                 position: 'left',
        //             },
        //             y1: {  // Escala Y1 para Finca Tehuya
        //                 beginAtZero: true,
        //                 display: false,
        //                 grid: { drawOnChartArea: false } 
        //             },
        //             y2: {  // Escala Y2 para Finca Victorias
        //                 beginAtZero: true,
        //                 display: false,
        //                 grid: { drawOnChartArea: false } 
        //             },
        //             y3: {  // Escala Y2 para Finca Victorias
        //                 beginAtZero: true,
        //                 display: false,
        //                 grid: { drawOnChartArea: false } 
        //             },
        //             y4: {  // Escala Y2 para Finca Victorias
        //                 beginAtZero: true,
        //                 display: false,
        //                 grid: { drawOnChartArea: false } 
        //             },
        //         }
        //     },
        // };

        const myChart = new Chart(grafico, config);
    }

    async function obtenerRendimiento(tarea_id) {
        try {
            const url = `/api/rendimiento/${tarea_id}`;
            const response = await fetch(url);
            const data = await response.json(); // Asumiendo que 'data' contiene el formato esperado
            return data;
        } catch (error) {
            console.error('Error al obtener el rendimiento:', error);
        }
    }
    
})();
