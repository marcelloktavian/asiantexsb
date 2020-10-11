<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title">Data Barang</h4>
		<ul class="breadcrumbs">
			<li class="nav-home">
				<a href="index.php">
					<i class="flaticon-home"></i>
				</a>
			</li>
			<li class="separator">
				<i class="flaticon-right-arrow"></i>
			</li>
			<li class="nav-item">
				<a href="#">Data Barang</a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">Data Barang</h4>
						<a class="btn btn-primary btn-round ml-auto" href="" class="btn btn-primary"><i class="fas fa-file-export"></i>
						Export</a>
						<a class="btn btn-primary btn-round" href="" class="btn btn-primary"><i class="fas fa-file-import"></i>
						Import</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="tabelmaster" class="display table table-striped table-hover" >
							<thead>
								<tr>
									<th width="5%">No</th>
									<th>Kode Barang</th>
									<th>ID Barang</th>
									<th>Nama Barang</th>
								</tr>
							</thead>
							<tbody id="listData">
								<!--  -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){

			show_dataBarang();

			$('#tabelmaster').DataTable({
				"lengthMenu": [[5, 15, 30,-1], [5, 15, 30, "All"]]
			});

		});


		function show_dataBarang() {
			$.ajax({
				type : "ajax",
				url : "<?php echo SITE_URL; ?>?file=master&&page=barang&&action=ajaxbarang",
				dataType : "json",
				async : false,
				success: function (response) {
					var html = '';
					var i;
					var count = 1;
					// console.log(response);
					for (i = 0; i < response.length; i++) {
						html += '<tr>' +
						'<td>'+count+'</td>'+
						'<td>'+response[i].kode_brg+'</td>'+
						'<td>'+response[i].id_barang+'</td>'+
						'<td>'+response[i].nm_barang+'</td>'+
						'</tr>';

						count++;
					}
					// console.log(html);
					$('#listData').html(html);
				}
			});
		}
	</script>