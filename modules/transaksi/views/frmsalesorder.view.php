<style>
	.hide{
		visibility: hidden;
	}

	.ui-autocomplete { 
		height: 90px; 
		overflow-y: auto; 
		overflow-x: hidden;
	}
</style>
<div class="page-inner">
	<div class="page-header">
		<!-- Header -->
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
		<!-- End Header -->
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
						<div class="col-md-12 col-lg-12">
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

								<div class="form-group"><label for="customer" class="col-md-3">Customer</label>
									<div class="col-md-12 p-0">
										<div class="input-group mb-3">
											<!-- Id Transaksi -->
											<input type="hidden" name="idtrans" id="idtrans" value="<?php if($_GET['action']=='update'){echo $_GET['id'];} ?>">

											<!-- Id User -->
											<input type="hidden" name="iduser" id="iduser" value="<?=$data['login']->user_id?>">

											<!-- Total Qty -->
											<input type="hidden" name="totqty" id="totqty" value="<?php if($_GET['action']=='update'){echo $data["custEdit"]->totalqty;}else{echo "0";} ?>">

											<!-- Select Customer -->
											<select class="form-control selectpicker" id="customer" name="customer" data-live-search="true" data-size="5" required>
												<?php
												if ($_GET['action']=='insert') {
													echo "<option value='' disabled selected>-Pilih Customer-</option>";
												} else {
													echo "<option value='' disabled>-Pilih Customer-</option>";
													echo "<option value=".$data["custEdit"]->customer." selected>".$data["custEdit"]->namaperusahaan."</option>";
												}
												foreach ($data["customer"] as $customer) {
													?><option value="<?= $customer->id ?>"><?= $customer->namaperusahaan ?></option>
												<?php } ?>
											</select>
											<div class="input-group-append">
												<button type="submit" value="Simpan" class="btn btn-success">Simpan</button>
											</div>
										</div>
									</div>

								</div>
								<div class="row row-demo-grid">
									<div class="col">
										<div class="card">
											<table width="100%">
												<tr>
													<td width="50%" align="center"><h3>Total Qty :</h3></td>
													<td width="50%"><h3 id="total" style="color: red;"><?php if($_GET['action']=='update'){echo $data["custEdit"]->totalqty;}else{echo "0";} ?></h3></td>
												</tr>
											</table>
										</div>
									</div>
								</div>
								<div class="form-group"><label for="idbarang" class="col-md-3">Input Barang</label>
									<div class="col-md-12 p-0">
										<div class="input-group mb-3">
											<!-- Barang -->
											<input type="text" class="form-control" name="idbarang" id="idbarang" placeholder="Masukkan ID/Kode Barang">


											<div class="input-group-append">
												<button type="button" value="Scan" id="scan" onclick="decoder.play();" class="btn btn-info" data-toggle="modal" data-target="#ModalScan">Scan</button>
											</div>
										</div>
									</div>

									<!-- Modal Scan -->
									<div class="modal fade" id="ModalScan" tabindex="-1" role="dialog" aria-labelledby="ModalScanLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="ModalScanLabel">Scan ID Barang</h5>
													<button type="button" onclick="decoder.stop();" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<center><canvas width="100%"></canvas><br/>
														<select id="cam"></select></center>
													</div>
													<div class="modal-footer">
														<button type="button" onclick="decoder.stop();" class="btn btn-info" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- End Modal Scan -->

									<hr>
									<table id='tbl_keranjang' class="table table-striped table-hover table-responsive-lg" >
										<thead>
											<tr>
												<th style="display:none;">ID Detail</th>
												<th>Kode Barang</th>
												<th>ID Barang</th>
												<th>Nama Barang</th>
												<th>Kategori</th>
												<th>Qty</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if ($_GET['action']=='update') {
												$i=1;
												foreach ($data["so"]  as $record) {
													echo "<tr><td style='display:none;'><p>".$record->id_detail."</p>";
													echo "<input type='hidden' name='iddetail[]' id='iddetail_".$i."'value='".$record->id_detail."' ></td>";
													echo "<td><p>".$record->kode_brg."</p>";
													echo "<input type='hidden' name='kd_brg[]' id='kd_brg_".$i."'value='".$record->kode_brg."' ></td>";
													echo "<td><p>".$record->id_barang."</p>";
													echo "<input type='hidden' name='id_brg[]' id='id_brg_".$i."'value='".$record->id_barang."' ></td>";
													echo "<td><p>".$record->nm_barang."</p>";
													echo "</td>";
													echo "<td><select id='jenis' name='jenis'>";
													echo "<option value='' disabled>-Pilih Kategori-</option>";

													echo "<option value=".$record->id_jns." selected>".$record->jns."</option>";

													foreach ($data["jenis"] as $jenisny) {
														if($jenisny->id_jenis !== $record->id_jns){
															?>
															<option value='<?= $jenisny->id_jenis ?>'><?= $jenisny->nm_jenis ?></option> 
														<?php } };
														echo "</select></td>";
														echo "<td><input type='text' name='qty[]' id='qty_".$i."' size='3' style='text-align: right;' value='".$record->qty."' onkeyup='hitung()'></td>";
														echo "<td><button type='button' data-toggle='tooltip' title='Hapus'class='btn btn-icon btn-round btn-danger' onclick='hapus(".$i.")'><i class='fa fa-times'></i></button></td></tr>";
														$i++;
													}
												}
												?>
											</tbody>
										</table>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
			var modal = document.getElementById('ModalScan');

			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
					decoder.stop();
				}
			}

			var arg = {
				resultFunction: function(result) {
				// var barang = result.code.split("/");
				var barang = result.code;

				$.ajax({
					type: 'POST',
					url: '<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=ajaxbarang',
					data: { barang: barang },
					dataType :"text",
					success: function(response) {
						var datanya = JSON.parse(response);
						// console.log(datanya[0].kode_brg);
						BarisBaru('',datanya[0].kode_brg, datanya[0].id_barang, datanya[0].nm_barang, '0');
						// alert(response); 
					}
				});

				// BarisBaru('', barang[0], barang[1],'0');
				$("#ModalScan").modal("hide");
				decoder.stop();
			}
		};

		var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
		decoder.buildSelectMenu("#cam");

		$('#cam').on('change', function(){
			decoder.stop().play();
		});

		var totalbaris=0;

		$('document').ready(function() {   
			hitung();
			$('#idbarang').click(function() {
				$(this).val('');
			});

			$('#idbarang').autocomplete({
				source: "<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=autobarang",

				select: function (event, ui) {
					BarisBaru('',ui.item.description, ui.item.label, ui.item.nmbrg,'0');
				}
			});
		});

		function BarisBaru($iddetail, $kd_brg, $id_brg, $nmbrg, $qty) {

			var kondisi='T';

			// $('#tbl_keranjang tbody tr').each(function(){

			// 	var idbrg = $(this).find('td:nth-child(3) p').text();

			// 	if ($id_brg==idbrg) {
			// 		kondisi='Y';
			// 	}
			// });

			// if(kondisi=='Y'){
			// 	Swal.fire({
			// 		title: 'Gagal',
			// 		text: "Barang sudah ada di keranjang.",
			// 		icon: 'error',
			// 		showCancelButton: false,
			// 		confirmButtonText: 'OK',
			// 		confirmButtonColor: '#3085d6',
			// 		reverseButtons: false
			// 	});
			// }else{
				totalbaris += 1;
			// console.log(totalbaris);
			var Nomor = $('#tbl_keranjang tbody tr').length + 1;
			var Baris = "<tr>";
			Baris += "<td style='display:none;'>";
			Baris += "<p>"+$iddetail+"</p>";
			Baris += "<input type='hidden' name='iddetail[]' id='iddetail_"+totalbaris+"'value='"+$iddetail+"' ></td>";
			Baris += "<td>";
			Baris += "<p>"+$kd_brg+"</p>";
			Baris += "<input type='hidden' name='kd_brg[]' id='kd_brg_"+totalbaris+"'value='"+$kd_brg+"' ></td>";
			Baris += "<td><p>"+$id_brg+"</p>";
			Baris += "<input type='hidden' name='id_brg[]' id='id_brg_"+totalbaris+"'value='"+$id_brg+"' ></td>";
			Baris += "<td><p>"+$nmbrg+"</p>";
			Baris += "</td>";

			Baris += "<td><select id='jenis_"+totalbaris+"' name='jenis[]'>";
			Baris += "<option value='' disabled>-Pilih Kategori-</option>";
			Baris += "<?php foreach ($data['jenis'] as $jenisny) { ?>";
			Baris += "<option value='<?= $jenisny->id_jenis ?>'><?= $jenisny->nm_jenis ?></option>";
			Baris += "<?php }; ?>";
			Baris += "</select></td>";

			Baris += "<td>";
			Baris += "<input type='text' name='qty[]' id='qty_"+totalbaris+"' size='3' style='text-align: right;' value='"+$qty+"' onkeyup='hitung()'>";
			Baris += "</td>";
			Baris += "<td><button type='button' data-toggle='tooltip' title='Hapus'class='btn btn-icon btn-round btn-danger' onclick='hapus("+Nomor+")'><i class='fa fa-times'></i></button></td>";
			Baris += "</tr>";

			var input = $('#tbl_keranjang tbody').append(Baris);

			$('#tbl_keranjang tbody tr').each(function(){
				$(this).find('td:nth-child(6) input').focus();
			});

			$('[data-toggle="tooltip"]').tooltip();
			hitung();
		// }
	}

	function hitung() {
		var Total = 0;

		$('#tbl_keranjang tbody tr').each(function(){

			var qty = $(this).find('td:nth-child(6) input').val();

			if ($(this).find('td:nth-child(6) input').val() == '') {
				qty='0';
			} else {
				qty = $(this).find('td:nth-child(6) input').val();
			}

			Total = parseInt(Total) + parseInt(qty);
		});
		$('#total').text(Total);
		$('#totqty').val(Total);

	}

	function hapus(nomor) {
		var id_detail="";
		id_detail = $('#tbl_keranjang tr:eq('+nomor+')').find('td:nth-child(1) input').val();
		var kode = $('#tbl_keranjang tr:eq('+nomor+')').find('td:nth-child(3) p').text(); 

		if (id_detail=='') {
			//hapus row
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
					//hapus db
					window.location.href="<?php echo SITE_URL; ?>?file=transaksi&&page=salesorder&&action=deleteDet&&iddet="+id_detail+"";
				}
			});
		}
		hitung();
	}

</script>
