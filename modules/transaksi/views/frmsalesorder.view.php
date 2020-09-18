<style>
	.ui-autocomplete { 
		height: 90px; 
		overflow-y: auto; 
		overflow-x: hidden;
	}
</style>
<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title"><?php echo $data["title"]; ?></h4>
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
			<li class="separator">
				<i class="flaticon-right-arrow"></i>
			</li>
			<li class="nav-item">
				<a href="#"><?php echo $data["title"]; ?></a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">Form Sales Order</h4>
						<a class="btn btn-primary btn-round ml-auto" href="<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder" class="btn btn-primary"><i class="fas fa-chevron-circle-left"></i>
						Kembali</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-lg-12">
							<?php
							if(isset($data["success"])) {
								?>
								<!-- alert jika berhail simpan data -->
								<script type="text/javascript">
									Swal.fire({
										title: 'Berhasil',
										text: "<?= $data["success"]; ?>",
										icon: 'success',
										showCancelButton: false,
										confirmButtonText: 'OK',
										confirmButtonColor: '#3085d6',
										reverseButtons: false
									}).then((result) => {
										if (result.value) {
											window.location.href="<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder";
										}
									});
								</script>

							<?php }else if (isset($data["error"])) {
								?>
								<!-- alert jika gagal simpan data -->
								<script type="text/javascript">
									Swal.fire({
										title: 'Gagal',
										text: "<?= $data["error"]; ?>",
										icon: 'error',
										showCancelButton: false,
										confirmButtonText: 'OK',
										confirmButtonColor: '#3085d6',
										reverseButtons: false
									});
								</script>
							<?php } ?>

							<form method="post" role="form">

								<!-- Customer -->
								<div class="form-group">
									<label for="customer" class="col-md-3">Customer</label>
									<div class="col-md-12 p-0">
										<div class="input-group mb-3">
											<!-- Id User -->
											<input type="hidden" name="iduser" id="iduser" value="<?=$data['login']->user_id?>">
											<!-- Select Customer -->
											<select class="form-control selectpicker" id="customer" name="customer" data-live-search="true" data-size="5">
												<option value="" disabled selected>-Pilih Customer-</option>
												<?php
												foreach ($data["customer"] as $customer) {
													?><option value="<?= $customer->id ?>"><?= $customer->namaperusahaan ?></option>
												<?php } ?>
											</select>
											<div class="input-group-append">
												<button type="submit" value="Submit" class="btn btn-success">Submit</button>
											</div>
										</div>
									</div>
								</div>
							</form>
							<div class="row row-demo-grid">
								<div class="col">
									<div class="card">
										<table width="100%">
											<tr>
												<td width="50%" align="center"><h3>Total Qty :</h3></td>
												<td width="50%"><h3>0</h3></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="customer" class="col-md-3">Input Barang</label>
								<div class="col-md-12 p-0">
									<input type="text" class="form-control" name="idbarang" id="idbarang" placeholder="Masukkan ID/Kode Barang">
								</div>
							</div>
							<hr>
							<table id='tbl_keranjang' class="table table-striped table-hover table-responsive-lg" >
								<thead>
									<tr>
										<th>ID Detail</th>
										<th>Kode Barang</th>
										<th>ID Barang</th>
										<th>Qty</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var totalbaris=0;

	$('document').ready(function() {
		$('#idbarang').click(function() {
			$(this).val('');
		});

		$('#idbarang').autocomplete({
			source: "<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=autobarang",

			select: function (event, ui) {
				BarisBaru(ui.item.description, ui.item.label);
			}
		});
	});

	function BarisBaru($kd_brg, $id_brg) {
		totalbaris += 1;
		console.log(totalbaris);
		var Nomor = $('#tbl_keranjang tbody tr').length + 1;
		var Baris = "<tr>";
		Baris += "<td>";
		Baris += "<p name='iddetail[]' id='iddetail_"+totalbaris+"' ></p></td>";
		Baris += "<td>";
		Baris += "<p name='kd_brg[]' id='kd_brg_"+totalbaris+"'>"+$kd_brg+"</p>";
		Baris += "</td>";
		Baris += "<td><p name='id_brg[]' id='id_brg_"+totalbaris+"'>"+$id_brg+"</p></td>";
		Baris += "<td>";
		Baris += "<input type='text' name='qty[]' id='qty_"+totalbaris+"' size='3' style='text-align: right;' value='0'>";
		Baris += "</td>";
		Baris += "<td><button type='button' data-toggle='tooltip' title='Hapus Data'class='btn btn-icon btn-round btn-danger' onclick='hapus("+Nomor+")'><i class='fa fa-times'></i></button></td>";
		Baris += "</tr>";

		var input = $('#tbl_keranjang tbody').append(Baris);

		$('#tbl_keranjang tbody tr').each(function(){
			$(this).find('td:nth-child(4) input').focus();
		});
	}

	function hapus(nomor) {
		var id_detail="";
		id_detail = $('#tbl_keranjang tr:eq('+nomor+')').find('td:nth-child(1) p').text();
		var kode = $('#tbl_keranjang tr:eq('+nomor+')').find('td:nth-child(3) p').text(); 

		if (id_detail=='') {
			$('#tbl_keranjang tr:eq('+nomor+')').remove();
		} else {
			Swal.fire({
				title: 'Konfirmasi',
				text: "Anda ingin menghapus "+kode+"?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Hapus',
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				cancelButtonText: 'Tidak',
				reverseButtons: false
			}).then((result) => {
				if (result.value) {
					
				}
			});
		}
	}

</script>
