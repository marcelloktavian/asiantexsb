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
							<tbody id="listso">
								<!-- <?php
								$no = 1;
								foreach($data["salesorder"] as $so) {
									?>
									<tr>
										<td>
											<button type="button" class="btn btn-icon btn-round btn-info btn-show" data-toggle="tooltip" title="Show Data" data-idtrans="<?= $so->id_trans; ?>">
												<i class="fa fa-eye"></i>
											</button></td>
											<td><?= $no; ?></td>
											<td><?= $so->id_trans; ?></td>
											<td><?= $so->namaperusahaan; ?></td>
											<td><?= date('d F Y', strtotime($so->tgl_trans)); ?></td>
											<td><?= $so->totalqty; ?></td>
											<td>
												<div class="form-button-action">
													<button type="button" data-toggle="tooltip" title="Post Data" onclick="alert('<?= $so->id_trans ?>','posting','<?= $data["login"]->user_id ?>')" class="btn btn-icon btn-round btn-warning">
														<i class="fa fa-share"></i>
													</button>
													<button type="button" data-toggle="tooltip" title="Ubah Data" onclick="window.location.href='<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=update&&id=<?php echo $so->id_trans; ?>';" class="btn btn-icon btn-round btn-primary">
														<i class="fa fa-edit"></i>
													</button>
													<button type="button" data-toggle="tooltip" title="Hapus Data" onclick="alert('<?= $so->id_trans ?>','hapus','<?= $data["login"]->user_id ?>')" class="btn btn-icon btn-round btn-danger">
														<i class="fa fa-trash"></i>
													</button>
													</div
												</td>
											</tr>
											<?php
											$no++;
										}
										?> -->
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
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<script>
				$(document).ready(function(){
					show_so();

					$('#tabelmaster').DataTable({
						"lengthMenu": [[5, 15, 30,-1], [5, 15, 30, "All"]]
					});
					$('[data-toggle="tooltip"]').tooltip();   

				});

				function dataso($id) {
					listData($id);
					$('#idso').text($id+')');
					$('#ModalDetail').modal('show');
				}


				function show_so() {
					$.ajax({
						type : "ajax",
						url : "<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=ajaxso",
						dataType : "json",
						async : false,
						success: function (response) {
							var html = '';
							var i;
							var count = 1;
							for (i = 0; i < response.length; i++) {
								html += '<tr>' +
								'<td><button type="button" class="btn btn-icon btn-round btn-info" data-toggle="tooltip" title="Show Data" onclick="dataso('+
								"'"+response[i].id_trans+"')"+
								'">'+
								'<i class="fa fa-eye"></i></button></td>'+
								'<td>'+count+'</td>'+
								'<td>'+response[i].id_trans+'</td>'+
								'<td>'+response[i].namaperusahaan+'</td>'+
								"<td>"+tanggal(response[i].tgl_trans)+"</td>"+
								'<td>'+response[i].totalqty+'</td>'+
								'<td><div class="form-button-action">'+
								'<button type="button" data-toggle="tooltip" title="Post Data" onclick="konfirmasi('+
								"'"+response[i].id_trans+"', 'posting', '<?= $data["login"]->user_id ?>')"+ 
								'" class="btn btn-icon btn-round btn-warning"><i class="fa fa-share"></i>'+
								'</button>'+
								'<button type="button" data-toggle="tooltip" title="Ubah Data" onclick="window.location.href='+
								"'<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=update&&id="+response[i].id_trans+"'"+
								'"class="btn btn-icon btn-round btn-primary"><i class="fa fa-edit"></i>'+
								'</button>'+
								'<button type="button" data-toggle="tooltip" title="Hapus Data" onclick="konfirmasi('+
								"'"+response[i].id_trans+"', 'hapus', '<?= $data["login"]->user_id ?>') "+
								'" class="btn btn-icon btn-round btn-danger"><i class="fa fa-trash"></i>'+
								'</button>'+
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

				function listData(idtrans) {
					$.ajax({
						type: 'POST',
						url: '<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=list',
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

				function konfirmasi($id, $kondisi, $iduser) {
					var id = $id;
					var user = $iduser;

					//posting
					if ($kondisi=='posting') {
						var kond = 'memposting';

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
								window.location.href="<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=posting&&id="+id+"";
							}
						});

					} else if($kondisi=='hapus'){
						//delete
						var kond = 'menghapus';

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

								Swal.fire({
									title: 'Masukan Password Anda',
									input: 'password',
									inputAttributes: {
										autocapitalize: 'off'
									},
									showCancelButton: true,
									confirmButtonText: 'Confirm',
									showLoaderOnConfirm: true,
									preConfirm: (login) => {

										$.ajax({
											type: 'POST',
											url: '<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=ajaxconfirm',
											data: { login: login },
											dataType :"text",
											success: function(response) {
												var datanya = JSON.parse(response);
												if (datanya[0].jumlah == '0') {
													Swal.fire({
														title: 'Password Salah',
														icon: 'error',
													});
												} else {
													window.location.href="<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=delete&&id="+id+"";
												}
											}
										});

									},
									allowOutsideClick: () => !Swal.isLoading()
								});
							}
						});
					}
				};
			</script>