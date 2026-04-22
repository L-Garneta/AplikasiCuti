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
			<button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Cuti Lain</button>
		</h5>
		<div class="card-body">
			<!-- Page Content -->
			<?php if ($sisa_cuti['is_approve'] == 0) : ?>
				<div class="card">
					<div class="card-body">
						<form action="<?php echo base_url('kaur/add_cuti'); ?>" method="post">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="nik">Kode Cuti</label>
										<input type="text" id="nik" name="kode_unik" class="form-control" value="<?php echo $kode_unik; ?>" readonly>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="hidden" name="id_user" value="<?php echo $user['id']; ?>">
												<input type="hidden" name="role_id" value="<?php echo $user['role_id']; ?>">
												<label for="input">Tanggal Input :</label>
												<input type="text" id="input" name="input" class="form-control" value="<?php echo date('Y/m/d'); ?>" readonly>
												<?php echo form_error('input', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="nik">No Induk Karyawan :</label>
												<input type="text" id="nik" name="nik" class="form-control" value="<?php echo $user['nik']; ?>" readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="nama">Nama Lengkap :</label>
										<input type="text" id="nama" name="nama" class="form-control" value="<?php echo $user['nama']; ?>" readonly>
									</div>

									<div class="form-group">
										<label for="bagian">Bagian / Departemen :</label>
										<input type="text" id="bagian" name="bagian" class="form-control" value="<?php echo $user['bagian']; ?>" readonly>
									</div>
									<div class="form-group">
										<label for="jabatan">Jabatan :</label>
										<input type="text" id="jabatan" name="jabatan" class="form-control" value="<?php echo $user['jabatan']; ?>" readonly>
									</div>
									<div class="form-group">
										<label for="jenisCuti">Jenis Cuti</label>
										<select class="form-control" id="jenisCuti" name="jenis_cuti">
											<option>Cuti Bulanan</option>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="ket">Keterangan :</label>
										<input type="text" id="ket" name="keterangan" id="inputKeterangan" maxlength="150" oninput="limitWords(this, 20)" class="form-control" value="<?php echo $sisa_cuti['keterangan']; ?>">
										<?php echo form_error('keterangan', '<small class="text-danger pl-1">', '</small>'); ?>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="txt1">Sisa Cuti Terakhir</label>
												<?php if ($sisa_cuti['sisa_cuti'] > -1) : ?>
													<input type="text" id="txt1" class="form-control" value="<?php echo $sisa_cuti['sisa_cuti']; ?>" readonly>
												<?php elseif ($sisa_cuti['is_approve'] == 2) : ?>
													<input type="text" id="txt1" class="form-control" value="<?php echo $sisa_cuti['sisa_cuti'] + $sisa_cuti['jml_cuti']; ?>" readonly>
												<?php else : ?>
													<input type="text" id="txt1" class="form-control" value="12" readonly>
												<?php endif; ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="txt2">Jumlah Cuti Diambil :</label>
												<input type="text" id="txt2" name="jml_cuti" class="form-control" onkeyup="sum();">
												<?php echo form_error('jml_cuti', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="txt3">Sisa Cuti Sekarang :</label>
												<input type="text" id="txt3" name="sisa_cuti" class="form-control" readonly>
												<?php echo form_error('sisa_cuti', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="tglCuti1">Tanggal Cuti 1 :</label>
												<input type="date" id="tglCuti1" name="cuti" class="form-control">
												<?php echo form_error('cuti', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="tglCuti2">Tanggal Cuti 2 :</label>
												<input type="date" id="tglCuti2" name="cuti2" class="form-control">
												<?php echo form_error('cuti2', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="tglMasuk">Tanggal Masuk :</label>
												<input type="date" id="tglMasuk" name="masuk" class="form-control">
												<?php echo form_error('masuk', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="alamat">Alamat :</label>
										<input type="varchar" id="alamat" name="alamat" class="form-control" value="<?php echo $user_cuti['alamat']; ?>">
										<?php echo form_error('alamat', '<small class="text-danger pl-1">', '</small>'); ?>
									</div>
									<div class="form-group">
										<label for="telp">No Telp / HP :</label>
										<input type="varchar" id="telp" name="telp" class="form-control" value="<?php echo $user_cuti['telp']; ?>">
										<?php echo form_error('telp', '<small class="text-danger pl-1">', '</small>'); ?>
									</div>
								</div>
							</div>
							<button type="submit" name="simpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
							<button type="button" class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="far fa-calendar-alt"></i>
								Kalender
							</button>
						</form>
					</div>
				</div>

			<?php elseif ($sisa_cuti['is_approve'] == 2) : ?>
				<div class="card">
					<div class="card-body">
						<form action="<?php echo base_url('kaur/add_cuti'); ?> " method="post">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="nik">Kode Cuti</label>
										<input type="text" id="nik" name="kode_unik" class="form-control" value="<?php echo $kode_unik; ?>" readonly>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="hidden" name="id_user" value="<?php echo $user['id']; ?>">
												<input type="hidden" name="role_id" value="<?php echo $user['role_id']; ?>">
												<label for="input">Tanggal Input :</label>
												<input type="text" id="input" name="input" class="form-control" value="<?php echo date('Y/m/d'); ?>" readonly>
												<?php echo form_error('input', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="nik">No Induk Karyawan :</label>
												<input type="text" id="nik" name="nik" class="form-control" value="<?php echo $user['nik']; ?>" readonly>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="nama">Nama Lengkap :</label>
										<input type="text" id="nama" name="nama" class="form-control" value="<?php echo $user['nama']; ?>" readonly>
									</div>

									<div class="form-group">
										<label for="bagian">Bagian / Departemen :</label>
										<input type="text" id="bagian" name="bagian" class="form-control" value="<?php echo $user['bagian']; ?>" readonly>
									</div>
									<div class="form-group">
										<label for="jabatan">Jabatan :</label>
										<input type="text" id="jabatan" name="jabatan" class="form-control" value="<?php echo $user['jabatan']; ?>" readonly>
									</div>
									<div class="form-group">
										<label for="jenisCuti">Jenis Cuti</label>
										<select class="form-control" id="jenisCuti" name="jenis_cuti">
											<option>Cuti Bulanan</option>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="ket">Keterangan :</label>
										<input type="text" id="ket" name="keterangan" id="inputKeterangan" maxlength="150" oninput="limitWords(this, 20)" class="form-control" value="<?php echo $sisa_cuti['keterangan']; ?>">
										<?php echo form_error('keterangan', '<small class="text-danger pl-1">', '</small>'); ?>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="txt1">Sisa Cuti Terakhir</label>
												<?php if ($sisa_cuti['is_approve'] == 2) : ?>
													<input type="text" id="txt1" class="form-control" value="<?php echo $sisa_cuti['sisa_cuti'] + $sisa_cuti['jml_cuti']; ?>" readonly>
												<?php else : ?>
													<input type="text" id="txt1" class="form-control" value="12" readonly>
												<?php endif; ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="txt2">Jumlah Cuti Diambil :</label>
												<input type="text" id="txt2" name="jml_cuti" class="form-control" onkeyup="sum();">
												<?php echo form_error('jml_cuti', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="txt3">Sisa Cuti Sekarang :</label>
												<input type="text" id="txt3" name="sisa_cuti" class="form-control" readonly>
												<?php echo form_error('sisa_cuti', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="tglCuti1">Tanggal Cuti 1 :</label>
												<input type="date" id="tglCuti1" name="cuti" class="form-control">
												<?php echo form_error('cuti', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="tglCuti2">Tanggal Cuti 2 :</label>
												<input type="date" id="tglCuti2" name="cuti2" class="form-control">
												<?php echo form_error('cuti2', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="tglMasuk">Tanggal Masuk :</label>
												<input type="date" id="tglMasuk" name="masuk" class="form-control">
												<?php echo form_error('masuk', '<small class="text-danger pl-1">', '</small>'); ?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="alamat">Alamat :</label>
										<input type="varchar" id="alamat" name="alamat" class="form-control" value="<?php echo $user_cuti['alamat']; ?>">
										<?php echo form_error('alamat', '<small class="text-danger pl-1">', '</small>'); ?>
									</div>
									<div class="form-group">
										<label for="telp">No Telp / HP :</label>
										<input type="varchar" id="telp" name="telp" class="form-control" value="<?php echo $user_cuti['telp']; ?>">
										<?php echo form_error('telp', '<small class="text-danger pl-1">', '</small>'); ?>
									</div>
								</div>
							</div>
							<button type="submit" name="simpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
							<button type="button" class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="far fa-calendar-alt"></i>
								Kalender
							</button>
						</form>
					</div>
				</div>

			<?php else : ?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert">
							<center><strong>" CUTI ANDA BELUM DISETUJUI "</strong></center>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- /.container-fluid -->


<!-- Modal Cuti diluar tanggungan -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cuti Lain</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('kaur/add_cuti_lain'); ?>" method="post">
					<div class="form-group">
						<label for="nik">Kode Cuti</label>
						<input type="text" id="nik" name="kode_unik2" class="form-control" value="<?php echo $kode_unik2; ?>" readonly>
					</div>
					<div class="form-row">
						<input type="hidden" name="id_user" value="<?php echo $user['id']; ?>">
						<input type="hidden" name="role_id" value="<?php echo $user['role_id']; ?>">
						<div class="form-group col-md-3">
							<label for="tglInput">Tanggal Input</label>
							<input type="text" class="form-control" id="tglInput" name="tgl_input" value="<?php echo date('Y/m/d'); ?>" readonly>
						</div>
						<div class="form-group col-md-3">
							<label for="nik">NIK</label>
							<input type="text" class="form-control" id="nik" name="nik" value="<?php echo $user['nik']; ?>" readonly>
						</div>
						<div class="form-group col-md-6">
							<label for="nama">Nama</label>
							<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $user['nama']; ?>" readonly>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="jabatan">Jabatan</label>
							<input type="text" class="form-control" id="tglInput" name="jabatan" value="<?php echo $user['jabatan']; ?>" readonly>
						</div>
						<div class="form-group col-md-3">
							<label for="bagian">Bagian</label>
							<input type="text" class="form-control" id="bagian" name="bagian" value="<?php echo $user['bagian']; ?>" readonly>
						</div>
						<div class="form-group col-md-6">
							<label for="keterangan">Jenis Cuti</label>
							<input type="text" class="form-control" id="keterangan" name="jenis_cuti" value="Cuti Lain" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="alamat">Alamat</label>
						<input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $user_cuti['alamat']; ?>" required>
					</div>
					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="jenisCuti">Keterangan</label>
							<input type="text" class="form-control" id="jenisCuti" name="keterangan" id="inputKeterangan" maxlength="150" oninput="limitWords(this, 20)" placeholder="Cth: Studi Banding, dll" required>
						</div>
						<div class="form-group col-md-4">
							<label for="jenisCuti">No Telp / Handphone</label>
							<input type="text" class="form-control" id="jenisCuti" name="telp" required>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="cuti1">Tanggal Cuti</label>
							<input type="date" class="form-control" id="cuti1" name="cuti" required>
						</div>
						<div class="form-group col-md-4">
							<label for="cuti2">Tanggal Cuti 2</label>
							<input type="date" class="form-control" id="cuti1" name="cuti2" required>
						</div>
						<div class="form-group col-md-4">
							<label for="tglMasuk">Tanggal Masuk</label>
							<input type="date" class="form-control" id="tglMasuk" name="masuk" required>
						</div>
					</div>
					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
					<button type="button" class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="far fa-calendar-alt"></i>
						Kalender
					</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal Kalender -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Kalendar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<br>
			<center>
				<iframe src="https://calendar.google.com/calendar/embed?height=400&amp;wkst=1&amp;bgcolor=%23ffffff&amp;ctz=Asia%2FBangkok&amp;showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;hl=id&amp;src=ZW4uaW5kb25lc2lhbiNob2xpZGF5QGdyb3VwLnYuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;color=%237986CB" style="border-width:0" width="700" height="400" frameborder="0" scrolling="no"></iframe>
			</center>
			<br>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
