$(function () {
    try {
        //bar chart
        var ctx = document.getElementById("barChart");
        if (ctx) {
            ctx.height = 200;
            var myChart = new Chart(ctx, {
                type: 'bar',
                defaultFontFamily: 'Poppins',
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [{
                            label: "My First dataset",
                            data: [65, 59, 80, 81, 56, 55, 40],
                            borderColor: "rgba(0, 123, 255, 0.9)",
                            borderWidth: "0",
                            backgroundColor: "rgba(0, 123, 255, 0.5)",
                            fontFamily: "Poppins"
                        },
                        {
                            label: "My Second dataset",
                            data: [28, 48, 40, 19, 86, 27, 90],
                            borderColor: "rgba(0,0,0,0.09)",
                            borderWidth: "0",
                            backgroundColor: "rgba(0,0,0,0.07)",
                            fontFamily: "Poppins"
                        }
                    ]
                },
                options: {
                    legend: {
                        position: 'top',
                        labels: {
                            fontFamily: 'Poppins'
                        }

                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                fontFamily: "Poppins"

                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontFamily: "Poppins"
                            }
                        }]
                    }
                }
            });
        }


    } catch (error) {
        console.log(error);
    }

    // Map
});
(function ($) {
    // استدعاء الدالة الرئيسية
    initMap();

})(jQuery);

// دالة رئيسية لتحميل البيانات وإعداد الخريطة
function initMap() {
    $(".js-map").css('opacity', 0);

    var apiUrl = urlForm+ '/get-visited';
    fetchVisitData(apiUrl)
        .done(function (data) {
            setupVectorMap(data.visits);
            if (data.details && Object.keys(data.details).length > 0) {
                Object.entries(data.details).forEach(detail => {
                    console.log(detail);
                    renderTableVisited(detail[0], detail[1]);
                });
            }
            $(".js-map").show();
            $(".js-map").css('opacity', 1);
            $('#js-loader-visit').remove();
        })
        .fail(function (xhr, status, error) {
            console.log('Error fetching data:', error);
        });
}

// دالة لإعداد خريطة vectorMap
function setupVectorMap(visits) {
    var vmap = $('#vmap');
    if (vmap[0]) {

        vmap.vectorMap({
            map: 'world_en',
            backgroundColor: '#24E5FFFF', // لون الخلفية (لون البحر)
            color: '#FFFFFFFF',
            hoverOpacity: 0.7,
            selectedColor: '#1de9b6',
            enableZoom: true,
            showTooltip: true,
            values: visits, // استخدام البيانات المجلوبة
            scaleColors: ['#ffcccc', '#ff9999', '#ff6666', '#ff0000'], // تدرجات الألوان من الأحمر
            normalizeFunction: 'polynomial',
            onLabelShow: function (event, label, code) {
                // تحديث نص التلميحات
                label.html(`
                    <p>${label.html()}</p>
                    <p>${visits[code] || 0}</p> <!-- إظهار عدد الزيارات -->
                `);
            },
        });
    }
}


// دالة لتحميل البيانات من API
function fetchVisitData(url) {
    return $.ajax({
        url: url,
        method: 'GET',
    });
}

function renderTableVisited(country, visit) {
    var table = $('#tbody-table');
    console.log(country, visit);
    var row = $('<tr></tr>');
    row.append($('<td></td>').text(country));
    row.append($('<td></td>').text(visit));
    table.append(row);
}
