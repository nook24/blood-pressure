app.controller("DashboardsIndexCtrl", function ($scope, $http) {

    $scope.start = Math.floor(Date.now() / 1000);
    $scope.end = Math.floor($scope.start - (3600 * 24 * 31));

    $scope.chart = null;
    var renderChart = function (chartData) {
        var ctx = document.getElementById("chart");

        if($scope.chart !== null){
            //Update chart
            $scope.chart.data.labels = chartData.labels;
            $scope.chart.data.datasets[0].data  = chartData.systolic;
            $scope.chart.data.datasets[1].data  = chartData.diastolic;
            $scope.chart.update();
            return;
        }

        $scope.chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: "Systolic",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: chartData.systolic
                },
                {
                    label: "Diastolic",
                    lineTension: 0.3,
                    backgroundColor: "rgba(107, 12, 151, 0.05)",
                    borderColor: "rgba(107, 12, 151, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(107, 12, 151, 1)",
                    pointBorderColor: "rgba(107, 12, 151, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(107, 12, 151, 1)",
                    pointHoverBorderColor: "rgba(107, 12, 151, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: chartData.diastolic
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 10
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                                return value + ' mmHg';
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: true
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + tooltipItem.yLabel + ' mmHg';
                        }
                    }
                }
            }
        });
    };

    $scope.update = function(){
        $scope.start = Math.floor(Date.now() / 1000);
        $scope.load();
    };


    $scope.load = function () {
        $http.get("/dashboards/index.json", {
            params: {
                start: $scope.start,
                end: $scope.end
            }
        }).then(function (result) {
            renderChart(result.data.chartData);
        });
    };


    //Fire on page load
    $scope.load();

});