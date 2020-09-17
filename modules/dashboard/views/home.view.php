<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">Beranda</h2>
			</div>
		</div>
	</div>
</div>
<h5 id="bar"><strong>Statistic Pasien Perbulan</strong></h5>
<div class="bd-example">
<div id="chart-container">
	<canvas id="barChart"></canvas>
</div>
</div>

<script>
var barChart = document.getElementById('barChart').getContext('2d');
var myBarChart = new Chart(barChart, {
	type: 'bar',
	data: {
		labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		datasets : [{
			label: "Pasien",
			backgroundColor: 'rgb(23, 125, 255)',
			borderColor: 'rgb(23, 125, 255)',
			data: [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4],
		}],
	},
	options: {
		responsive: true, 
		maintainAspectRatio: false,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		},
	}
});
</script>