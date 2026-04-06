const flashData = $('.flash-data').data('flashdata');

if (flashData === 'login_error') {
	Swal.fire({
		title: 'Login Gagal',
		text: 'Username atau password salah',
		icon: 'error'
	});
}

if (flashData === 'user_tidak_aktif') {
	Swal.fire({
		title: 'User Tidak Aktif',
		icon: 'warning'
	});
}

if (flashData === 'user_tidak_ditemukan') {
	Swal.fire({
		title: 'User Tidak Ditemukan',
		icon: 'error'
	});
}

if (flashData === 'Logout') {
	Swal.fire({
		title: 'Logout Sukses',
		icon: 'success'
	});
}