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
                                <img :src="asset('/app/main/image/profile/') + user.avatar" alt="user-img" width="36" class="img-circle">
                                <span>{{ user.name }}</span>
                            </a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<div class="user-box">
										<div class="u-img"><img :src="asset('/app/main/image/profile/') + user.avatar" alt="user"></div>
										<div class="u-text">
											<h4>{{ user.name }}</h4>
											<p class="text-muted">Administrator</p>
										</div>
									</div>
								</li>
								<div class="dropdown-divider"></div>
								<inertia-link :href="route('admin.profile')" class="dropdown-item" :class="route().current('admin.*') ? 'active' : ''">
									<i class="fas fa-fw fa-user"></i> Profil
								</inertia-link>
								<div class="dropdown-divider"></div>
								<inertia-link :href="route('admin.logout')" class="dropdown-item" v-on:click.prevent="logout()">
									<i class="fas fa-fw fa-sign-out-alt"></i> Keluar
								</inertia-link>
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
						<inertia-link :href="route('dashboard.index')">
							<i class="fas fa-fw fa-fire"></i>
							<p>Dashboard</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="route().current('kategori.*') ? 'active' : ''">
						<inertia-link :href="route('kategori.index')">
							<i class="fas fa-fw fa-tags"></i>
							<p>Kategori</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="(route().current('buku.*') || route().current('mapel.*')) ? 'active' : ''">
						<inertia-link :href="route('buku.index')">
							<i class="fas fas fa-book"></i>
							<p>Buku</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="route().current('tingkat.*') ? 'active' : ''">
						<inertia-link :href="route('tingkat.index')">
							<i class="fas fa-fw fa-layer-group"></i>
							<p>Tingkat</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="route().current('kelas.*') ? 'active' : ''">
						<inertia-link :href="route('kelas.index')">
							<i class="fas fa-fw fa-door-open"></i>
							<p>Kelas</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="route().current('siswa.*') ? 'active' : ''">
						<inertia-link :href="route('siswa.index')">
							<i class="fas fa-fw fa-user-graduate"></i>
							<p>Siswa</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="(route().current('peminjaman.*') || route().current('peminjaman_mapel.*')) ? 'active' : ''">
						<inertia-link :href="route('peminjaman.index')">
							<i class="fas fa-fw fa-book-reader"></i>
							<p>Peminjaman</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="route().current('kunjungan.*') ? 'active' : ''">
						<inertia-link :href="route('kunjungan.index')">
							<i class="fas fa-fw fa-walking"></i>
							<p>Kunjungan</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="route().current('grafik.*') ? 'active' : ''">
						<inertia-link :href="route('grafik.index')">
							<i class="fas fa-fw fa-chart-pie"></i>
							<p>Grafik</p>
						</inertia-link>
					</li>
					<li class="nav-item" :class="route().current('operasi.*') ? 'active' : ''">
						<inertia-link :href="route('operasi.index')">
							<i class="fas fa-fw fa-cogs"></i>
							<p>Operasi</p>
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
		mounted () {
			this.user = this.$page.props.admin;
		},
		methods: {
			logout () {
				let onOk = () => {
					this.$awn.asyncBlock(this.$inertia.get(route('admin.logout')), null);
				}
				let onCancle = () => {
					return;
				}
				this.$awn.confirm(
					'Anda akan keluar dari aplikasi',
					onOk,
					onCancle,
					{
						labels: {
							confirm: 'APAKAH ANDA YAKIN ?'
						}
					}
				);
			},
		}
	}
</script>

<style>
@import '~vue-awesome-notifications/dist/styles/style.css';
.pointer {
	cursor: pointer;
}
</style>