<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title">Laporan</h4>
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
				<a href="#">Laporan</a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">Laporan Sales Order</h4>
						<button type="button" value="Export" class="btn btn-primary btn-round ml-auto" id="cari" onclick="exportall()"><i class="fas fa-file-export"></i>  Export</button>
						<!-- <button type="button" value="Export" class="btn btn-primary btn-round ml-auto" id="cari" onclick="exportallpdf()"><i class="fas fa-file-pdf"></i>  Pdf</button>
							<button type="button" value="Export" class="btn btn-primary btn-round" id="cari" onclick="exportallexcel()"><i class="fas fa-file-excel"></i>  Excel</button> -->
						</a>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group"><label for="customer" class="col-md-3">Filter Tanggal (Dari-Sampai)</label>
						<div class="col-md-12 p-0">
							<div class="input-group mb-3">
								<!-- Dari Tanggal -->
								<input class="form-control" type="month" placeholder="Dari" id="daritgl" name="daritgl" required>
								<!-- Sampai Tanggal -->
								<input class="form-control" type="month" placeholder="Sampai" id="sampaitgl" name="sampaitgl" required>
							</select>
							<div class="input-group-append">
								<button type="button" value="Cari" class="btn btn-primary" id="cari" onclick="cari()">Cari</button>
							</div>
						</div>
					</div>
				</div>

				<div class="table-responsive">
					<table id="tabelmaster" class="display table table-striped table-hover" >
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>ID Trans</th>
								<th>Customer</th>
								<th>Tanggal Trans</th>
								<th>Qty</th>
								<th width="5%">Aksi</th>
							</tr>
						</thead>
						<tbody id="listso">
								<!-- <?php
								$no = 1;
								foreach($data["salesorder"] as $so) {
									?>
									<tr>
										<td><?= $no; ?></td>
										<td><?= $so->id_trans; ?></td>
										<td><?= $so->namaperusahaan; ?></td>
										<td><?= date('d F Y', strtotime($so->tgl_trans)); ?></td>
										<td><?= $so->totalqty; ?></td>
										<td>
											<div class="form-button-action">
												<button type="button" class="btn btn-icon btn-round btn-info btn-show" data-toggle="tooltip" title="Show Data"  data-idtrans="<?= $so->id_trans; ?>">
													<i class="fa fa-eye"></i>
												</button>
												<button type="button" data-toggle="tooltip" title="Export Data"  class="btn btn-icon btn-round btn-warning">
													<i class="fa fa-file-export"></i>
												</button>
												</div>
											</td>
										</tr>
										<?php
										$no++;
									}
									?>
								-->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Detail -->
	<div class="modal fade" id="ModalDetail" tabindex="-1" role="dialog" aria-labelledby="ModalDetailLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ModalDetailLabel">Detail Sales Order (</h5><h5 id="idso"></h5>
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
							<th>Kategori</th>
							<th>Qty</th>
						</thead>
						<tbody id="listData">

						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			table = $('#tabelmaster').DataTable({
				"lengthMenu": [[5, 15, 30,-1], [5, 15, 30, "All"]]
			});
			$('[data-toggle="tooltip"]').tooltip(); 
		});

		function dataso($id) {
			listData($id);
			$('#idso').text($id+')');
			$('#ModalDetail').modal('show');
		}

		function cari() {
			if($('#daritgl').val() !== '' && $('#sampaitgl').val() !== ''){
				table.destroy();
				show_so($('#daritgl').val(), $('#sampaitgl').val());
				table = $('#tabelmaster').DataTable({
					"lengthMenu": [[5, 15, 30,-1], [5, 15, 30, "All"]]
				});
				$('[data-toggle="tooltip"]').tooltip();
			}else{
				Swal.fire(
					'ERROR',
					'Silahkan Isi Filter Tanggal',
					'error'
					)
			}
		}

		function show_so(dari, sampai) {
			$.ajax({
				type : "ajax",
				url : "<?php echo SITE_URL; ?>?file=laporan&&page=lapsalesorder&&action=ajaxso&&dari="+dari+"&&sampai="+sampai,
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
						'<td>'+response[i].id_trans+'</td>'+
						'<td>'+response[i].namaperusahaan+'</td>'+
						'<td>'+tanggal(response[i].tgl_trans)+'</td>'+
						'<td>'+response[i].totalqty+'</td>'+
						'<td><div class="form-button-action">'+
						'<button type="button" class="btn btn-icon btn-round btn-info" data-toggle="tooltip" title="Show Data" onclick="dataso('+
						"'"+response[i].id_trans+"')"+
						'">'+
						'<i class="fa fa-eye"></i></button>'+
						'<button type="button" data-toggle="tooltip" class="btn btn-icon btn-round btn-warning" title="Export PDF" onclick="exportsatuanpdf('+
						"'"+response[i].id_trans+"')"+
						'">'+
						'<i class="fas fa-file-pdf"></i></button>'+
						'<button type="button" data-toggle="tooltip" class="btn btn-icon btn-round btn-secondary" title="Export Excel" onclick="exportsatuanexcel('+
						"'"+response[i].id_trans+"')"+
						'">'+
						'<i class="fas fa-file-excel"></i></button>'+
						'</div></td>'+
						'</tr>';

						count++;
					}
					// console.log(html);

					$('#listso').html(html);
				}
			});
		}

		function tanggal(tgl) {
			var date = new Date(tgl);
			var hari = date.getDate();
			if (hari<10) {
				hari = '0'+date.getDate();
			}
			var list = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
			var bulan = list[date.getMonth()];
			var tahun = date.getFullYear();
			var output = hari+' '+bulan+' '+tahun;
			return output;
		}

		function exportsatuanpdf(idtrans) {
			window.open('<?php echo SITE_URL; ?>?file=laporan&&page=lapsalesorder&&action=pdf&&idtrans='+idtrans, '_blank');
		}

		function exportsatuanexcel(idtrans) {
			window.open('<?php echo SITE_URL; ?>?file=laporan&&page=lapsalesorder&&action=excel&&idtrans='+idtrans, '_blank');
		}

		function exportall() {
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
					if($('#daritgl').val() !== '' && $('#sampaitgl').val() !== ''){
						window.open('<?php echo SITE_URL; ?>?file=laporan&&page=lapsalesorder&&action=pdfall&&dari='+$('#daritgl').val()+'&&sampai='+$('#sampaitgl').val(), '_blank');
					}else{
						Swal.fire(
							'ERROR',
							'Silahkan Isi Filter Tanggal',
							'error'
							)
					}
				}else if(result.isDenied){
					if($('#daritgl').val() !== '' && $('#sampaitgl').val() !== ''){
						window.open('<?php echo SITE_URL; ?>?file=laporan&&page=lapsalesorder&&action=excelall&&dari='+$('#daritgl').val()+'&&sampai='+$('#sampaitgl').val(), '_blank');
					}else{
						Swal.fire(
							'ERROR',
							'Silahkan Isi Filter Tanggal',
							'error'
							)
					}
				}

			})
		}

		function listData(idtrans) {
			$.ajax({
				type: 'POST',
				url: '<?php echo SITE_URL; ?>?file=laporan&&page=lapsalesorder&&action=list',
				data: { idtrans: idtrans },
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
								'<td>' + datanya[i].jns + '</td>' +
								'<td>' + datanya[i].qty + '</td>' +
								'</tr>';
							}
							$('#listData').html(html);
						}
					});
		}
	</script>