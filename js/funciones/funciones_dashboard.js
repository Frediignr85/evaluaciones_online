$(document).ready(function() {
    grafica1();
    grafica2();
    grafica3();
});

function grafica1() {
    $.ajax({
        url: "grafica.php",
        method: "POST",

        success: function(data) {
            var producto = [];
            var total = [];
            var obj = jQuery.parseJSON(data);
            var sales = [];
            for (var i in obj) {
                producto.push(obj[i].producto);
                total.push(obj[i].total);
                var json = { "name": (obj[i].producto), "data": [parseFloat(obj[i].total)] }
                sales.push(json);

            }
            Highcharts.chart('container1', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'EVALUACIONES REALIZADAS POR MES'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'CANTIDAD DE EVALUACIONES'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                },

                series: sales,

            });

        },
        error: function(data) {
            console.log(data);
        }
    });
}



function grafica2() {
    $.ajax({
        url: "grafica1.php",
        method: "POST",

        success: function(data) {
            var producto = [];
            var total = [];
            var obj = jQuery.parseJSON(data);
            var sales = [];
            for (var i in obj) {
                producto.push(obj[i].producto);
                total.push(obj[i].total);
                var json = { "name": (obj[i].producto), "data": [parseFloat(obj[i].total)] }
                sales.push(json);

            }
            Highcharts.chart('container2', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'CURSOS CON MAS EVALUACIONES'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    categories: producto,
                },
                yAxis: {
                    title: {
                        text: 'CANTIDAD DE EVALUACIONES'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                },

                series: sales,

            });

        },
        error: function(data) {
            console.log(data);
        }
    });
}



function grafica3() {
    $.ajax({
        url: "grafica2.php",
        method: "POST",

        success: function(data) {
            var producto = [];
            var total = [];
            var obj = jQuery.parseJSON(data);
            var sales = [];
            for (var i in obj) {
                producto.push(obj[i].producto);
                total.push(obj[i].total);
                var json = { "name": (obj[i].producto), "data": [parseFloat(obj[i].total)] }
                sales.push(json);

            }
            Highcharts.chart('container3', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'CURSOS CON MEJOR PROMEDIO DE NOTAS'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'NOTAS PROMEDIO'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                },

                series: sales,

            });

        },
        error: function(data) {
            console.log(data);
        }
    });
}

function ir_al_curso(id_curso) {
    window.location = 'ver_curso.php?id_curso=' + id_curso;
}

$(".btn_empezar_prueba").click(function() {
    let id_evaluacion = $(this).attr('id');
    window.location = 'realizar_evaluacion.php?id_evaluacion=' + id_evaluacion;
});