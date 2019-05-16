<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<div class="row margin-top-10">
		<div class="row">
			<div class="col-md-12">
				<?= $this->session->flashdata('msg') ?>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet box grey-cascade">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-globe"></i> Form Edit Karyawan
						</div>
					</div>
					<div class="portlet-body">
						<?= form_open_multipart('admin/edit-karyawan/' . $id) ?>
							<div class="form-group">
								<label for="nama">Nama</label>
								<input type="text" name="nama" value="<?= $karyawan->nama ?>" class="form-control">
							</div>
							<div class="form-group">
								<label for="nik">NIK</label>
								<input type="text" name="nik" value="<?= $karyawan->nik ?>" class="form-control">
							</div>
							<div class="form-group">
								<label for="divisi">Divisi</label>
								<select class="form-control" name="id_divisi" required>
									<?php foreach ($divisi as $row): ?>
										<option <?= $karyawan->id_divisi == $row->id ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->divisi ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="lama_bekerja">Lama Bekerja (Tahun)</label>
								<input type="number" name="lama_bekerja" value="<?= $karyawan->lama_bekerja ?>" class="form-control">
							</div>
							<div class="form-group">
								<label for="status">Status</label>
								<select class="form-control" name="status" required>
									<option <?= $karyawan->status == 'Karyawan Tetap' ? 'selected' : '' ?> value="Karyawan Tetap">Karyawan Tetap</option>
									<option <?= $karyawan->status == 'Karyawan Kontrak' ? 'selected' : '' ?> value="Karyawan Kontrak">Karyawan Kontrak</option>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" name="submit" value="Submit" class="btn btn-success">
							</div>
						<?= form_close() ?>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>
	</div>
</div>