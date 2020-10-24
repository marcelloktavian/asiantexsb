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
						<button type="button" value="Export" class="btn btn-primary btn-round ml-auto" id="cari" onclick="exportbrg()"><i class="fas fa-file-export"></i>  Export</button>
						<button type="button" value="Import" class="btn btn-primary btn-round" id="cari"  data-toggle="modal" data-target="#modalimport"><i class="fas fa-file-import"></i>  Import</button>
						<!-- <button type="button" value="Posting" class="btn btn-primary btn-round ml" id="cari" onclick="datapost()"><i class="fas fa-file-upload"></i>  Posting</button> -->

						<!-- Modal Import -->
						<div class="modal fade" id="modalimport" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="ModalLabel">Import Data Barang</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
											<div class="form-group">

													<form method="post" enctype="multipart/form-data" role="form">
														<div class="input-group mb-3">
															
															<input type="file" class="form-control" name="fileimport" id="fileimport" accept=".xls,.xlsx" required>
															<div class="input-group-append">
																<button type="submit"  value="Import" class="btn btn-primary" >Upload</button>
															</div>

														</div>
														<label class="col-md-3">* Format xls, xlsx</label>
													</form>

													<!-- </div> -->
												</div>
												<div class="container">
														<button type="button" value="Posting" class="btn btn-primary" id="posting" style="width: 100%;" onclick="datapost()"><i class="fas fa-file-upload"></i>  Posting</button>
												</div>
												<!-- </div> -->
											</div>
											<div class="modal-footer">
												
												<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>

						<!-- Modal Posting -->
						<div class="modal fade" id="ModalDetail" tabindex="-1" role="dialog" aria-labelledby="ModalDetailLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="ModalDetailLabel">Data Posting Barang</h5><h5 id="idso"></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<table id class="table table-striped table-hover table-responsive-lg">
											<thead>
												<th>No.</th>
												<th>Kode Barang</th>
												<th>ID Barang</th>
												<th>Nama Barang</th>
											</thead>
											<tbody id="listdet">

											</tbody>
										</table>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-primary" onclick="posting()">Post Data</button>
										<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>

						<!-- alert sukses import -->
						<?php
						if(isset($data["sukses"])) {
							?>
							<script type="text/javascript">
								Swal.fire({
									title: 'Berhasil',
									text: "<?= $data["sukses"]; ?>",
									icon: 'success',
									showCancelButton: false,
									confirmButtonText: 'OK',
									confirmButtonColor: '#EE4D2D',
									reverseButtons: false
								});
							</script>

						<?php } ?>

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

				function posting() {
					Swal.fire({
						title: 'Konfirmasi',
						text: "Anda ingin memposting data barang?",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Ya',
						cancelButtonText: 'Tidak',
					}).then((result) => {
						if (result.isConfirmed) {

							$('#ModalDetail').modal('hide');
							$('#modalimport').modal('hide');

							$.ajax({
								type : "ajax",
								url : "<?php echo SITE_URL; ?>?file=master&&page=barang&&action=ajaxposting",
								dataType : "json",
								async : false,
								success: function (response) {
									Swal.fire(
										'Berhasil',
										'Data Berhasil di Posting.',
										'success'
										)
								}
							});
						}
					})
				}

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
							for (i = 0; i < response.length; i++) {
								html += '<tr>' +
								'<td>'+count+'</td>'+
								'<td>'+response[i].kode_brg+'</td>'+
								'<td>'+response[i].id_barang+'</td>'+
								'<td>'+response[i].nm_barang+'</td>'+
								'</tr>';

								count++;
							}
							$('#listData').html(html);
						}
					});
				}

				function datapost() {
					show_detpost();
					// $('#modalimport').modal('hide');
					$('#ModalDetail').modal('show');
				}

				function show_detpost() {
					$.ajax({
						type: 'POST',
						url: '<?php echo SITE_URL; ?>?file=master&&page=barang&&action=listpost',
						dataType :"text",
						success: function (data) {
							var datanya = JSON.parse(data);
							// console.log(datanya);
							var html = '';
							var i;
							var no = 1;
							for (i = 0; i < datanya.length; i++) {
								html += '<tr>' +
								'<td>' + no++ + '.</td>' +
								'<td>' + datanya[i].kode_brg + '</td>' +
								'<td>' + datanya[i].id_barang + '</td>' +
								'<td>' + datanya[i].nm_barang + '</td>' +
								'</tr>';
							}
							$('#listdet').html(html);
						}
					});
				}

				function exportbrg() {
					var value = $('.dataTables_filter input').val();

					Swal.fire({
						title: 'Pilih Jenis Dokumen!!',
						showCloseButton: true,
						showCancelButton: false,
						showDenyButton: true,
						confirmButtonColor: '#EE4D2D',
						denyButtonColor: '#EE4D2D',
						confirmButtonText: '<i class="fas fa-file-pdf"></i> PDF',
						denyButtonText: '<i class="fas fa-file-excel"></i> EXCEL'
					}).then((result) => {
						if (result.isConfirmed) {
							window.open('<?php echo SITE_URL; ?>?file=master&&page=barang&&action=exportbrg&&cari='+value, '_blank');
						}else if(result.isDenied){
							window.open('<?php echo SITE_URL; ?>?file=master&&page=barang&&action=exportbrgexcel&&cari='+value, '_blank');
						}

					})
				}

			</script>