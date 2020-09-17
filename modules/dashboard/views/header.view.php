<!-- Logo Header -->
<div class="logo-header" data-background-color="blue">

	<a href="index.php" class="logo navbar-brand">
		<b style="color: white;">Asiantex</b>
	</a>
	<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon">
			<i class="icon-menu"></i>
		</span>
	</button>
	<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
	<div class="nav-toggle">
		<button class="btn btn-toggle toggle-sidebar">
			<i class="icon-menu"></i>
		</button>
	</div>
</div>
<!-- End Logo Header -->

<!-- Navbar Header -->
<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
	<div class="container-fluid">
		<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
			<li class="nav-item dropdown hidden-caret">
				<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-cog"></i>
				</a>
				<ul class="dropdown-menu dropdown-user animated fadeIn">
					<div class="dropdown-user-scroll scrollbar-outer">
						<li>
							<div class="user-box">
								<div class="avatar-lg"><img src="resources/assets/images/administrator.png" alt="image profile" class="avatar-img rounded" style="border: 1px solid #555;"></div>
								<div class="u-text">
									<h4><?= $data["login"]->nama ?></h4>
									<p class="text-muted"><?= $data["login"]->name ?></p>
								</div>
							</div>
						</li>
						<li>
							<div class="dropdown-divider"></div>
							<button class="dropdown-item" onclick="logout()">Logout</button>
						</li>
					</div>
				</ul>
			</li>
		</ul>
	</div>
</nav>
<!-- End Navbar -->