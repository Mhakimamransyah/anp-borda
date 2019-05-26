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
							<i class="fa fa-globe"></i> Form Penilaian Karyawan
						</div>
					</div>
					<div class="portlet-body">
						<?= form_open_multipart('decision-maker/penilaian-karyawan/' . $id_karyawan) ?>
							<div class="form-group">
								<label for="nik">NIK</label>
								<input type="text" name="nik" value="<?= $karyawan->nik ?>" readonly class="form-control">
							</div>
							<div class="form-group">
								<label for="nama">Nama</label>
								<input type="text" name="nama" value="<?= $karyawan->nama ?>" readonly class="form-control">
							</div>
							<div class="form-group">
								<label for="divisi">Divisi</label>
								<input type="text" name="divisi" value="<?= $karyawan->divisi->divisi ?>" readonly class="form-control">
							</div>
							<?php foreach ($subkriteria as $i => $row): ?>
								<div class="form-group">
									<label for="subkriteria">Subkriteria <?= $row->subkriteria ?></label>
									<select id="nilai_<?= $i ?>" name="nilai[]" class="form-control" required>
										<?php for ($j = 0; $j < 5; $j++): ?>
											<option <?= isset($karyawan->penilaian[$i]) && $karyawan->penilaian[$i]->nilai == $j + 1 ? 'selected' : '' ?> value="<?= $j + 1 ?>"><?= $j + 1 ?></option>
										<?php endfor; ?>
									</select>
									<!-- <input placeholder="Masukkan nilai" max="5" type="number" value="<?= isset($karyawan->penilaian[$i]) ? $karyawan->penilaian[$i]->nilai : '' ?>" id="nilai_<?= $i ?>" name="nilai[]" class="form-control" required> -->
									<input type="hidden" name="id_subkriteria[]" value="<?= $row->id ?>">
								</div>
							<?php endforeach; ?>
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