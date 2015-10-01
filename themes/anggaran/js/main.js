/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {


    $('.pie-chart').easyPieChart(
            {
//        easing: 'swing',
        onStep: function(from, to, percent) {
            $(this.el).find('.percent').text(Math.round(percent));
        },
        size: 120,
        barColor: '#4CAF50',
        scaleColor: false,
        lineWidth: 20,
        trackColor: 'rgba(255,255,255,0.2)',
//        animate: 15000,
        lineCap: 'square'
    }
            );
    
//    alert('asd');


//    NAV
    $('.header').on("click", function() {
        $('aside').toggleClass('maximized');
    });

    //Uang persediaan
    $('.up').on("click", function() {
        $('.panel-right').css('display', 'none');
        var up = $(this).attr('id');
        $('#paket-' + up).css('display', 'block');
    });

    //Close panel
    $('.close-panel').on('click', function() {
        $(this).parentsUntil('flex').find('.panel-right').hide();
    });

    //Slider
    $('.slider').each(function() {
        var dataProgress = $(this).attr('data-progress');
        var progress = dataProgress * 100;
        progress = progress.toFixed(2) + '%';
        var progressBar = $(this).find('span');

        progressBar.css('width', progress);
        $(this).find('label').text(progress);

        if (dataProgress < 0.5) {
            progressBar.addClass('bg-success');
        }
        else if (dataProgress < 0.85) {
            progressBar.addClass('bg-warning');
        }
        else {
            progressBar.addClass('bg-danger');
        }
    });




    //Superfish
    $('ul.sf-menu').superfish({
        animation: {height: 'show'}, // slide-down effect without fade-in
        delay: 1200			// 1.2 second delay on mouseout
    });


    //Chart
    $('.bar-chart').popover({
        trigger: 'hover',
        html: 'true'
    });

});



//Grafik

//$(function () {
//    $('#container').highcharts({
//        chart: {
//            type: 'column'
//        },
//        title: {
//            text: ' '
//        },
//        xAxis: {
//            categories: ['MANAGEMENT OF TRAINING (MOT)', 'MANAJEMEN PENGENDALIAN PELATIHAN KONSTRUKSI', 'PEMBEKALAN PELATIHAN MOBILE TRAINING UNIT (MTU)', 'PENINGKATAN KEMAMPUAN SDM JASA KONSTRUKSI BIDANG KETERAMPILAN', 'Peningkatan Kapasitas Pembinaan Kompetensi dan Pelatihan Konstruksi']
//        },
//        yAxis: {
//            min: 0,
//            title: {
//                text: 'Rupiah'
//            },
//            stackLabels: {
//                enabled: true,
//                style: {
//                    fontWeight: 'bold',
//                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
//                }
//            }
//        },
//        legend: {
//            align: 'right',
//            x: -70,
//            verticalAlign: 'top',
//            y: 20,
//            floating: true,
//            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
//            borderColor: '#CCC',
//            borderWidth: 1,
//            shadow: false
//        },
//        tooltip: {
//            formatter: function () {
//                return '<b>' + this.x + '</b><br/>' +
//                        this.series.name + ': ' + this.y + '<br/>' +
//                        'Total: ' + this.point.stackTotal;
//            }
//        },
//        plotOptions: {
//            column: {
//                stacking: 'normal',
//                dataLabels: {
//                    enabled: true,
//                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
//                    style: {
//                        textShadow: '0 0 3px black, 0 0 3px black'
//                    }
//                }
//            }
//        },
//        series: [{
//                name: 'Saldo',
//                data: [100000000, 150000000, 244000000, 176000000, 122000000]
//            }, {
//                name: 'Realisasi',
//                data: [455000000, 299000000, 320000000, 370000000, 189000000]
//            }]
//    });
//});