<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white pb-2 fw-bold">Beranda</h2>
				<h5 class="text-white op-7 mb-2">Selamat datang di SetiaBusana Application !</h5>
			</div>
		</div>
	</div>
</div>

<div class="page-inner mt--5">

	<!-- Reminder Card -->
	<div class="row mt--2">
		<div class="col-md-12">
			<div class="row">
				<div class="col-sm-6 col-md-4">
					<div class="card card-stats card-round">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col-icon">
									<div class="icon-big text-center icon-success bubble-shadow-small">
										<i class="flaticon-graph"></i>
									</div>
								</div>
								<div class="col col-stats ml-4 ml-sm-0">
									<div class="numbers">
										<p class="card-category">Penjualan / bulan</p>
										<h4 class="card-title"><?php foreach ($data["total"] as $tot) {
											echo $tot->jumlah;
										}; ?></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-4">
					<div class="card card-stats card-round">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col-icon">
									<div class="icon-big text-center icon-info bubble-shadow-small">
										<i class="flaticon-calendar"></i>
									</div>
								</div>
								<div class="col col-stats ml-4 ml-sm-0">
									<div class="numbers">
										<p class="card-category">Tanggal</p>
										<h4 class="card-title"><?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y'); ?></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="col-sm-6 col-md-4">
					<div class="card card-stats card-round">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col-icon">
									<div class="icon-big text-center icon-secondary bubble-shadow-small">
										<i class="flaticon-time"></i>
									</div>
								</div>
								<div class="col col-stats ml-3 ml-sm-0">
									<div class="numbers">
										<p class="card-category">Waktu</p>
										<h4 class="card-title" id="waktu">00:00:00</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Reminder Card -->

	<!-- Statistic Card -->
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="card-head-row">
						<div class="card-title">Statistic Pemesanan Perbulan</div>
					</div>
				</div>
				<div class="card-body">
					<div class="bd-example">
						<div id="chart-container">
							<canvas id="barChart"></canvas> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Statistic Card -->

</div>

<script>
	$(function(){
		setInterval(waktu, 1000);
	});

	function waktu() {
		$.ajax({
			url: '<?= PATH . "/modules/waktu.php" ?>',
			success: function(data) {
				$('#waktu').html(data);
			},
		});
	}

	var barChart = document.getElementById('barChart').getContext('2d');
	$.ajax({
			url: '<?php echo SITE_URL; ?>?file=dashboard&&page=home&&action=ajaxchartjs',
			success: function(data) {
				var databulan = JSON.parse(data);
				// console.log(test);
				// for(var i = 0; i < databulan.length; i++){
					// console.log(data[8].totalbulan);
					// console.log(databulan[8].totalbulan);
				// }
					var myBarChart = new Chart(barChart, {
					type: 'bar',
					data: {
						labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
						datasets : [{
							label: "PEMESANAN",
							backgroundColor: 'rgb(23, 125, 255)',
							borderColor: 'rgb(23, 125, 255)',
							data: [databulan[0].totalbulan,
							 databulan[1].totalbulan,
							  databulan[2].totalbulan,
							   databulan[3].totalbulan,
								databulan[4].totalbulan,
								 databulan[5].totalbulan,
								  databulan[6].totalbulan,
								   databulan[7].totalbulan,
									databulan[8].totalbulan,
									 databulan[9].totalbulan,
									  databulan[10].totalbulan,
									   databulan[11].totalbulan,
									],
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
			},
		});
</script>