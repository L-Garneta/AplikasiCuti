<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
	<?php echo $this->session->flashdata('msg'); ?>
	<?php if (validation_errors()) { ?>
		<div class="alert alert-danger">
			<a class="close" data-dismiss="alert">x</a>
			<strong><?php echo strip_tags(validation_errors()); ?></strong>
		</div>
	<?php } ?>
	<div class="card">
		<h5 class="card-header">
			<strong><?= $title; ?></strong>
			<a class="btn btn-secondary btn-sm float-right" href="<?php echo base_url('admin/add_user'); ?>" data-toggle="modal" data-target="#ubah-pass"><i class="fas fa-key"></i> Ubah Password</a>
			<a class="btn btn-secondary btn-sm float-right mr-2" href="<?php echo base_url('admin/add_user'); ?>" data-toggle="modal" data-target="#ubah-prof"><i class="fas fa-user-edit"></i> Ubah Profile</a>
		</h5>
		<div class="card-body">
			<div class="row">
				<!-- Earnings (Monthly) Card Example -->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card border-left-primary shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Cuti Tahunan Karyawan</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><a href="<?php echo base_url('sdm/list_tunggu_cuti_kary'); ?>" style="text-decoration:none;"><?php echo $count_cuti_tahunan; ?> Menunggu</a></div>
								</div>
								<div class="col-auto">
									<i class="far fa-calendar-alt fa-2x text-gray-300"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Earnings (Monthly) Card Example -->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card border-left-success shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Cuti Lain Karyawan</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><a href="<?php echo base_url('sdm/list_tunggu_cuti_diluartanggungan_kary'); ?>" style="text-decoration:none;"><?php echo $count_cuti_luartanggungan; ?> Menunggu</a></div>
								</div>
								<div class="col-auto">
									<i class="far fa-edit fa-2x text-gray-300"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Earnings (Monthly) Card Example -->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card border-left-info shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cuti Karyawan Ditolak</div>
									<div class="row no-gutters align-items-center">
										<div class="col-auto">
											<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><a href="<?php echo base_url('sdm/list_cuti_ditolak'); ?>" style="text-decoration:none"><?php echo $count_cuti_ditolak; ?> Ditolak</a></div>
										</div>
									</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-star-half-alt fa-2x text-gray-300"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Pending Requests Card Example -->
				<div class="col-xl-3 col-md-6 mb-4">
					<div class="card border-left-warning shadow h-100 py-2">
						<div class="card-body">
							<div class="row no-gutters align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Registrasi User</div>
									<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_user; ?> Total User</div>
								</div>
								<div class="col-auto">
									<i class="fas fa-user-friends fa-2x text-gray-300"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Content Row -->
			<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
			<div class="row">
				<div class="col-md-12">
					<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
					<div class="card">
						<div class="card-header">
							<a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/add_user'); ?>" data-toggle="modal" data-target="#add-user"><i class="fas fa-user-plus"></i> Tambah User</a>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover" id="table-id">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Nama</th>
											<th scope="col">NIK</th>
											<th scope="col">Level</th>
											<th scope="col">Username</th>
											<th scope="col">Bagian</th>
											<th scope="col">Jabatan</th>
											<th scope="col">Status</th>
											<th scope="col">Edit</th>
											<th scope="col">Input Cuti</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php foreach ($pegawai as $p) : ?>
											<tr>
												<th scope="row"><?php echo $i++; ?></th>
												<td><?php echo $p['nama']; ?></td>
												<td><?php echo $p['nik']; ?></td>
												<?php if ($p['role_id'] == 2) : ?>
													<td>Sdm</td>
												<?php elseif ($p['role_id'] == 3) : ?>
													<td>Koordinator</td>
												<?php else : ?>
													<td>Staf</td>
												<?php endif; ?>
												<td><?php echo $p['username']; ?></td>
												<td><?php echo $p['bagian']; ?></td>
												<td><?php echo $p['jabatan']; ?></td>
												<?php if ($p['is_active'] == 1) : ?>
													<td><button class="btn btn-light btn-sm btn-block">Aktif</button></td>
												<?php else : ?>
													<td><button class="btn btn-danger btn-sm btn-block">Tidak Aktif</button></td>
												<?php endif; ?>
												<td><button class="tombol-edit btn btn-info btn-block btn-sm" data-id="<?php echo $p['id']; ?>" data-toggle="modal" data-target="#edit-user"><i class="fas fa-edit"></i> Edit</button></td>
												<td><button class="tombol-edit btn btn-secondary btn-block btn-sm" data-id="<?php echo $p['id']; ?>" data-toggle="modal" data-target="#input-cuti"><i class="fas fa-edit"></i> Input</button></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('sdm/index'); ?>" method="post">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama Lengkap :</label>
								<input type="text" class="form-control form-control-sm" name="nama" required>
							</div>
							<div class="form-group">
								<label>Jabatan :</label>
								<input type="text" class="form-control form-control-sm" name="jabatan" required>
							</div>
							<div class="form-group">
								<label>Bagian :</label>
								<input list="divisi" class="form-control form-control-sm" name="bagian" required>
								<datalist id="divisi">
									<?php foreach ($bagian as $b) : ?>
										<option value="<?php echo $b['bagian']; ?>">
										<?php endforeach; ?>
								</datalist>
							</div>
							<div class="form-group">
								<label>NIK :</label>
								<input type="text" class="form-control form-control-sm" name="nik" value="<?php echo $kode_nik; ?>" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Level Akses :</label>
								<select class="form-control form-control-sm" name="role_id">
									<option value="">- Pilih Level -</option>
									<option value="2">SDM</option>
									<option value="3">KOORDINATOR</option>
									<option value="4">STAF</option>
								</select>
							</div>
							<div class="form-group">
								<label>Username :</label>
								<input type="text" class="form-control form-control-sm" name="username" required>
							</div>
							<div class="form-group">
								<label>Password :</label>
								<input type="password" class="form-control form-control-sm" name="password1">
							</div>
							<div class="form-group">
								<label>Password :</label>
								<input type="password" class="form-control form-control-sm" name="password2" placeholder="Tulis ulang password">
							</div>
						</div>
					</div>
					<button type="submit" name="add_user" class="btn btn-primary">Simpan Data</button>
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ubah-prof" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ubah Profile</h5>
			</div>
			<div class="modal-body">
				<?php echo form_open_multipart('sdm/edit_profile'); ?>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Username</label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="username" value="<?php echo $user['username']; ?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">NIK</label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="nik" value="<?php echo $user['nik']; ?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Nama</label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="nama" value="<?php echo $user['nama']; ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Jabatan</label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="jabatan" value="<?php echo $user['jabatan']; ?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Bagian</label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="bagian" value="<?php echo $user['bagian']; ?>">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-2">Photo</div>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-3">
								<img src="<?php echo base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
							</div>
							<div class="col-sm-9">
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="image">
									<label class="custom-file-label" for="image">Choose file</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Simpan Perubahan </button>
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ubah-pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('sdm/changepassword'); ?>" method="post">
					<div class="form-group">
						<label>Password Lama</label>
						<input type="password" class="form-control form-control-sm" name="current_password" required>
					</div>
					<div class="form-group">
						<label>Password Baru</label>
						<input type="password" class="form-control form-control-sm" name="new_password1" required>
					</div>
					<div class="form-group">
						<label>Ulang Password</label>
						<input type="password" class="form-control form-control-sm" name="new_password2" placeholder="Ketik ulang password baru" required>
					</div>
					<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('sdm/edit_user'); ?>" method="post">
					<div class="form-group">
						<label>NIK :</label>
						<input type="hidden" name="id" id="id">
						<input type="text" class="form-control form-control-sm" name="nik" id="nik" readonly>
					</div>
					<div class="form-group">
						<label>Nama Lengkap :</label>
						<input type="text" class="form-control form-control-sm" name="nama" id="nama" required>
					</div>
					<div class="form-group">
						<label>Jabatan :</label>
						<input type="text" class="form-control form-control-sm" name="jabatan" id="jabatan" required>
					</div>
					<div class="form-group">
						<label>Bagian :</label>
						<input list="divisi" class="form-control form-control-sm" name="bagian" id="bagian" required>
						<datalist id="divisi">
							<?php foreach ($bagian as $b) : ?>
								<option value="<?php echo $b['bagian']; ?>">
								<?php endforeach; ?>
						</datalist>
					</div>
					<div class="form-group">
						<label>Level Akses :</label>
						<select class="form-control form-control-sm" name="role_id" id="role_id">
							<option value="">- Pilih Level -</option>
							<option value="2">SDM</option>
							<option value="3">KOORDINATOR</option>
							<option value="4">STAF</option>
						</select>
					</div>
					<div class="form-group">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline1" name="is_active" class="custom-control-input" value="1" required>
							<label class="custom-control-label" for="customRadioInline1">Aktif</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="customRadioInline2" name="is_active" class="custom-control-input" value="0" required>
							<label class="custom-control-label" for="customRadioInline2">Tidak Aktif</label>
						</div>
					</div>
					<button type="submit" name="add_user" class="btn btn-primary">Simpan Data</button>
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="input-cuti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('sdm/input_cuti'); ?>" method="post">
					<div class="form-group">
						<label>NIK :</label>
						<input type="hidden" name="id_user" id="id_cuti">
						<input type="hidden" name="role_id" id="role_id_cuti">
						<input type="text" class="form-control form-control-sm" name="nik" id="nik_cuti" readonly>
					</div>
					<div class="form-group">
						<label>Nama Lengkap :</label>
						<input type="text" class="form-control form-control-sm" name="nama" id="nama_cuti" readonly>
					</div>
					<div class="form-group">
						<label>Jabatan :</label>
						<input type="text" class="form-control form-control-sm" name="jabatan" id="jabatan_cuti" readonly>
					</div>
					<div class="form-group">
						<label>Bagian :</label>
						<input type="text" class="form-control form-control-sm" name="bagian" id="bagian_cuti" readonly>
					</div>
					<div class="form-group">
						<label>Sisa Cuti :</label>
						<input type="number" class="form-control form-control-sm" name="sisa_cuti" required>
					</div>

					<button type="submit" name="add_user" class="btn btn-primary">Simpan Data</button>
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$('.tombol-edit').on('click', function() {
		const id = $(this).data('id');
		$.ajax({
			url: '<?php echo base_url('sdm/get_user'); ?>',
			data: {
				id: id
			},
			method: 'post',
			dataType: 'json',
			success: function(data) {
				$('#nama').val(data.nama);
				$('#jabatan').val(data.jabatan);
				$('#bagian').val(data.bagian);
				$('#nik').val(data.nik);
				$('#role_id').val(data.role_id);
				$('#id').val(data.id);
				$('#id_cuti').val(data.id);
				$('#nama_cuti').val(data.nama);
				$('#jabatan_cuti').val(data.jabatan);
				$('#bagian_cuti').val(data.bagian);
				$('#nik_cuti').val(data.nik);
				$('#role_id_cuti').val(data.role_id);
			}
		});
	});
</script>
