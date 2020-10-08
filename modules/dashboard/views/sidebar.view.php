<div class="sidebar-wrapper scrollbar scrollbar-inner">
	<div class="sidebar-content">
		<div class="user">
			<div class="avatar-sm float-left mr-2">
				<img src="resources/assets/images/administrator.png" alt="..." class="avatar-img rounded-circle" style="border: 1px solid #555;">
			</div>
			<div class="info">
				<a><span>
					<?= ucfirst($data["login"]->nama); ?>
					<span class="user-level"><?= ucfirst($data["login"]->name) ?></span>
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

			<?php
			if($data["login"]->group_id == '1'){
				?>
				<!-- Barang -->
				<li class="nav-item <?php if($_GET['page']=='barang' ) echo 'active'?>">
					<a href="<?php echo PATH; ?>index.php?file=master&&page=barang">
						<i class="fas fa-box"></i>
						<p>Data Barang</p>
					</a>
				</li>
				<?php
			}

			if ($data["login"]->group_id == '1' || $data["login"]->group_id == '4') {
				?>
				<!-- Sales Order -->
				<li class="nav-item <?php if($_GET['page']=='salesorder' ) echo 'active'?>">
					<a href="<?php echo PATH; ?>index.php?file=transaksi&&page=salesorder">
						<i class="fas fa-shopping-cart"></i>
						<p>Sales Order</p>
					</a>
				</li>
				<?php
			}

			if ($data["login"]->group_id == '1' || $data["login"]->group_id == '5') {
				?>
				<!-- Sales Order -->
				<li class="nav-item <?php if($_GET['page']=='lapsalesorder' ) echo 'active'?>">
					<a href="<?php echo PATH; ?>index.php?file=laporan&&page=lapsalesorder">
						<i class="fas fa-file"></i>
						<p>Laporan</p>
					</a>
				</li>
				<?php
			}
			?>		

		</ul>
	</div>
</div>