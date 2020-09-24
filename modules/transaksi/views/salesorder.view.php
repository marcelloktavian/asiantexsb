<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title">Sales Order</h4>
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
				<a href="#">Sales Order</a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">Data Sales Order</h4>
						<a class="btn btn-primary btn-round ml-auto" href="<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=insert" class="btn btn-primary"><i class="fa fa-plus"></i>
						Tambah Data</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="tabelmaster" class="display table table-striped table-hover" >
							<thead>
								<tr>
									<th></th>
									<th width="5%">No</th>
									<th>ID Trans</th>
									<th>Customer</th>
									<th>Tanggal Trans</th>
									<th>Qty</th>
									<th width="5%">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								foreach($data["salesorder"] as $so) {
									?>
									<tr>
										<td>
										<button type="button" data-toggle="tooltip" title="Detail Data" class="btn btn-icon btn-round btn-info">
										<i class="fa fa-eye"></i>
										</button></td>
										<td><?= $no; ?></td>
										<td><?= $so->id_trans; ?></td>
										<td><?= $so->namaperusahaan; ?></td>
										<td><?= date('d F Y', strtotime($so->tgl_trans)); ?></td>
										<td><?= $so->totalqty; ?></td>
										<td>
											<div class="form-button-action">
												<button type="button" data-toggle="tooltip" title="Post Data" onclick="alert('<?= $so->id_trans ?>','posting')" class="btn btn-icon btn-round btn-warning">
													<i class="fa fa-share"></i>
												</button>
												<button type="button" data-toggle="tooltip" title="Ubah Data" onclick="window.location.href='<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=update&&id=<?php echo $so->id_trans; ?>';" class="btn btn-icon btn-round btn-primary">
													<i class="fa fa-edit"></i>
												</button>
												<button type="button" data-toggle="tooltip" title="Hapus Data" onclick="alert('<?= $so->id_trans ?>','hapus')" class="btn btn-icon btn-round btn-danger">
													<i class="fa fa-trash"></i>
												</button>
										</td>
									</tr>
									<?php
									$no++;
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){

			$('#tabelmaster').DataTable({
				"lengthMenu": [[5, 15, 30,-1], [5, 15, 30, "All"]]
			});

			$('[data-toggle="tooltip"]').tooltip();   

		});

		function alert($id, $kondisi) {
			var id 		= $id;

			if ($kondisi=='posting') {
				var kond = 'memposting';
			} else if($kondisi=='hapus'){
				var kond = 'menghapus';
			}
			Swal.fire({
				title: 'Konfirmasi',
				text: "Anda ingin "+kond+" "+id+"?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya',
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				cancelButtonText: 'Tidak',
				reverseButtons: false
			}).then((result) => {
				if (result.value) {
					if ($kondisi=='posting') {
						window.location.href="<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=posting&&id="+id+"";
					} else {
						window.location.href="<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=delete&&id="+id+"";
					}
				}
			});
		};
	</script>