<canvas id="myChart"></canvas>
<div class="clearfix" style="height: 50px;"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var labels = {!! json_encode($labels) !!};
    var openPrices = {!! json_encode($openPrices) !!};
    var closePrices = {!! json_encode($closePrices) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Open Prices',
                    data: openPrices,
                    borderColor: 'blue',
                    fill: false
                },
                {
                    label: 'Close Prices',
                    data: closePrices,
                    borderColor: 'green',
                    fill: false
                }
            ]
        },
        options: {}
    });
</script>
