@include('layouts.backend.data.style')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- SIDEBAR -->
<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><img style="width: 20%" src="{{ asset('/img/logo.png')}}" alt=""> WIMARTINDO </a>
		<ul class="side-menu">
			<li><a href="/dashboard" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard </a></li>
			<li class="divider" data-text="main">Main</li>
			<li><a href="/customer" ><i class='bx bxs-user-account icon' ></i> Pelanggan </a></li>
			<li>
				<a href="#"><i class='fa fa-list icon' ></i> Master Data <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="/categori">kategori</a></li>
					<li><a href="/product">produk</a></li>
					<li><a href="/add_bank">Bank</a></li>
					<li><a href="/alamat_pengirim">Alamat pengirim</a></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class='fa fa-cart-plus icon' ></i> pesanan <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="/order/all">semua pesanan</a></li>
					<li><a href="/order/0">pesanan pending</a></li>
					<li><a href="/order/1">pesanan kemas</a></li>
					<li><a href="/order/2">pesanan kirim</a></li>
					<li><a href="/order/3">pesanan selesai</a></li>
					<li><a href="/order/4">pesanan batal</a></li>
					
				</ul>
			</li>
			{{-- <li>
				<a href="#"><i class='fa fa-cog icon' ></i> Setting <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					
				</ul>
			</li> --}}
		</ul>
		
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav id="navbar">
			<i class='bx bx-menu toggle-sidebar' ></i>
			<form action="#">
				<div class="form-group">
					{{-- <input type="text" placeholder="Search...">
					<i class='bx bx-search icon' ></i> --}}
				</div>
			</form>
			<span class="divider"></span>
			<div class="profile">
				<img src="{{ asset('/img/logo.png')}}" alt="">
				<ul class="profile-link">
					<li><a href="/admin/user"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
					<li><a href="#"><i class='bx bxs-cog' ></i> Settings</a></li>
					<form method="POST" action="{{ route('logout') }}">
						@csrf
					<li><a href="{{ route('logout')  }}" onclick="event.preventDefault();
						this.closest('form').submit();"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
				</form>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->

    
    <!-- SCRIPT -->
