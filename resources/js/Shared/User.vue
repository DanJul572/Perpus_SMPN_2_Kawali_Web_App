<template>
    <div class="wrapper">
		<div class="main-header">
			<div class="logo-header">
				<span class="logo">
					<img :src="asset('app/main/image/logo/logo_40x36.png')"> Perpus IQRA
				</span>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
			</div>
			<nav class="navbar navbar-header navbar-expand-lg">
				<div class="container-fluid">
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item dropdown">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img :src="asset('/app/main/image/siswa/default.jpg')" alt="user-img" width="36" class="img-circle">
                                <span>Siswa</span>
                            </a>
							<ul class="dropdown-menu dropdown-user">
								<a :href="route('welcome')" class="dropdown-item">
									<i class="fas fa-fw fa-sign-out-alt"></i> Keluar
								</a>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="sidebar">
			<div class="sidebar-wrapper">
				<ul class="nav">
					<li class="nav-item" :class="route().current('dashboard.*') ? 'active' : ''">
						<inertia-link :href="route('dashboard.user')">
							<i class="fas fa-fw fa-fire"></i>
							<p>Dashboard</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="route().current('siswa.*') ? 'active' : ''">
						<inertia-link :href="route('siswa.user')">
							<i class="fas fa-fw fa-user-graduate"></i>
							<p>Siswa</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="(route().current('peminjaman.create') || route().current('peminjaman_mapel.create')) ? 'active' : ''">
						<inertia-link :href="route('peminjaman.create')">
							<i class="fas fa-fw fa-book-reader"></i>
							<p>Peminjaman</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="(route().current('peminjaman.return') || route().current('peminjaman_mapel.return')) ? 'active' : ''">
						<inertia-link :href="route('peminjaman.return')">
							<i class="fas fa-fw fa-hand-holding-heart"></i>
							<p>Pengembalian</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="route().current('kunjungan.*') ? 'active' : ''">
						<inertia-link :href="route('kunjungan.create')">
							<i class="fas fa-fw fa-walking"></i>
							<p>Kunjungan</p>
						</inertia-link>
					</li>
				</ul>
			</div>
		</div>
		<div class="main-panel">
			<div class="content">
				<slot/>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data () {
			return {
				user: '',
			}
		},
		props: {
			title: String,
		},
		watch: {
			title: {
				immediate: true,
				handler(title) {
					document.title = title
				},
			},
		},
	}
</script>

<style>
@import '~vue-awesome-notifications/dist/styles/style.css';
.pointer {
	cursor: pointer;
}
</style>