<div class="sidebar-wrapper scrollbar scrollbar-inner">
	<div class="sidebar-content">
		<div class="user">
			<div class="avatar-sm float-left mr-2">
				<img src="resources/assets/images/administrator.png" alt="..." class="avatar-img rounded-circle" style="border: 1px solid #555;">
			</div>
			<div class="info">
				<a><span>
					<?= $data["login"]->nama ?>
					<span class="user-level"><?= $data["login"]->name ?></span>
				</span></a>
			</div>
		</div>
		<ul class="nav nav-primary">
			<li class="nav-item <?php if($_GET['page']=='' ) echo 'active'?>">
				<a href="<?php echo PATH; ?>">
					<i class="fas fa-home"></i>
					<p>Beranda</p>
				</a>
			</li>
			<li class="nav-section">
				<span class="sidebar-mini-icon">
					<i class="fa fa-ellipsis-h"></i>
				</span>
				<h4 class="text-section">Menu</h4>
			</li>

			<!-- Sales Order -->
			<li class="nav-item <?php if($_GET['page']=='salesorder' ) echo 'active'?>">
				<a href="<?php echo PATH; ?>index.php?file=transaksi&&page=salesorder">
					<i class="fas fa-shopping-cart"></i>
					<p>Sales Order</p>
				</a>
			</li>
			
<!-- 			Menu Master
			<li class="nav-item <?php if($_GET['page']=='armada' || $_GET['page']=='bahanmaterial') echo 'active'?>">
				<a data-toggle="collapse" href="#master">
					<i class="fas fa-layer-group"></i>
					<p>Master Data</p>
					<span class="caret"></span>
				</a>
				<div class="collapse <?php if($_GET['page']!=='' && ($_GET['page']=='armada' || $_GET['page']=='bahanmaterial')) echo 'show'?>" id="master">
					<ul class="nav nav-collapse">
						<li>
							Profil Perusahaan
							<a href="<?php echo PATH; ?>index.php?file=master&&page=profilperusahaan">
								<span class="sub-item">Profil Perusahaan</span>
							</a>
						</li>
						<li>
							Armada
							<a href="<?php echo PATH; ?>index.php?file=master&&page=armada">
								<span class="sub-item">Armada</span>
							</a>
						</li>
						<li>
							Bahan Material
							<a href="<?php echo PATH; ?>index.php?file=master&&page=bahanmaterial">
								<span class="sub-item">Bahan Material</span>
							</a>
						</li>
						<li>
							Bahan Kimia
							<a href="<?php echo PATH; ?>index.php?file=master&&page=bahankimia">
								<span class="sub-item">Bahan Kimia</span>
							</a>
						</li>
						<li>
							Bahan Grey
							<a href="<?php echo PATH; ?>index.php?file=master&&page=bahangrey">
								<span class="sub-item">Bahan Grey</span>
							</a>
						</li>
						<li>
							Bahan Kain
							<a href="<?php echo PATH; ?>index.php?file=master&&page=bahankain">
								<span class="sub-item">Bahan Kain</span>
							</a>
						</li>
						<li>
							Data Proses
							<a href="<?php echo PATH; ?>index.php?file=master&&page=dataproses">
								<span class="sub-item">Data Proses</span>
							</a>
						</li>
						<li>
							Jasa Warna
							<a href="<?php echo PATH; ?>index.php?file=master&&page=jasawarna">
								<span class="sub-item">Jasa Warna</span>
							</a>
						</li>
						<li>
							Jasa PO
							<a href="<?php echo PATH; ?>index.php?file=master&&page=jasapo">
								<span class="sub-item">Jasa PO</span>
							</a>
						</li>
						<li>
							Mesin Celup
							<a href="<?php echo PATH; ?>index.php?file=master&&page=mesincelup">
								<span class="sub-item">Mesin Celup</span>
							</a>
						</li>
						<li>
							Pelanggan
							<a href="<?php echo PATH; ?>index.php?file=master&&page=pelanggan">
								<span class="sub-item">Pelanggan</span>
							</a>
						</li>
						<li>
							Pemasok
							<a href="<?php echo PATH; ?>index.php?file=master&&page=pemasok">
								<span class="sub-item">Pemasok</span>
							</a>
						</li>
					</ul>
				</div>
			</li> -->
		</ul>
	</div>
</div>