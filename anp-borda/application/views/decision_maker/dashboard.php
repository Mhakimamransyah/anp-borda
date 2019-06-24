<div class="page-content">
	<!-- BEGIN PAGE CONTENT INNER -->
	<div class="row margin-top-10">
		<div class="col-md-12">
			<h2>Selamat Datang</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?= form_open('decision-maker') ?>
				<div class="row">
					<div class="col-md-6 text-center">
						<h3>Manager</h3>
					</div>
					<div class="col-md-6 text-center">
						<h3>Kepala Cabang</h3>
					</div>
					
							<div class="col-md-6">
								<div class="row">
									<?php for ($i = 0; $i < count($kriteria); $i++): ?>
										<?php if (!in_array($kriteria[$i]->id, $excluded['l'])): ?>
										<div class="col-md-12">
											<div class="form-group">
												<label for="kriteria_l_<?= $kriteria[$i]->id ?>"><?= $kriteria[$i]->kriteria ?></label>
												<input type="number" value="<?= $kriteria[$i]->bobot ?>" placeholder="Masukkan bobot" required name="kriteria_l_<?= $kriteria[$i]->id ?>" class="form-control">
											</div>
										</div>
										<?php endif; ?>
									<?php endfor; ?>
								</div>
							</div>
						
						
							<div class="col-md-6">
								<div class="row">
									<?php for ($i = 0; $i < count($kriteria); $i++): ?>
										<?php if (!in_array($kriteria[$i]->id, $excluded['r'])): ?>
										<div class="col-md-12">
											<div class="form-group">
												<label for="kriteria_r_<?= $kriteria[$i]->id ?>"><?= $kriteria[$i]->kriteria ?></label>
												<input type="number" value="<?= $kriteria[$i]->bobot ?>" placeholder="Masukkan bobot" required name="kriteria_r_<?= $kriteria[$i]->id ?>" class="form-control">
											</div>
										</div>
										<?php endif; ?>
									<?php endfor; ?>
								</div>
							</div>
						
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<input type="submit" name="submit" value="Lakukan Perangkingan" class="btn blue">
						</div>
					</div>
				</div>
			<?= form_close() ?>
		</div>
	</div>
	<?php if (isset($result)): ?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box grey-cascade">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-globe"></i> Hasil Perangkingan
						</div>
					</div>
					<div class="portlet-body" style="overflow-x: scroll;">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th class="text-center" rowspan="2" style="vertical-align: middle;">Karyawan</th>
									<th class="text-center" colspan="<?= count($result[0]['votes']) ?>">Peringkat</th>
									<th class="text-center" rowspan="2" style="vertical-align: middle;">Skor Akhir</th>
									<th class="text-center" rowspan="2" style="vertical-align: middle;">Bobot Setelah Normalisasi</th>
									<th class="text-center" rowspan="2" style="vertical-align: middle;">Rangking</th>
								</tr>
								<tr>
									<?php for ($i = 0; $i < count($result[0]['votes']); $i++): ?>
										<th class="text-center"><?= $i + 1 ?></th>
									<?php endfor; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($result as $i => $row): ?>
									<tr>
										<td><?= $row['nama'] ?></td>
										<?php foreach ($row['votes'] as $vote): ?>
											<td><?= $vote ?></td>
										<?php endforeach; ?>
										<td><?= $row['final_score'] ?></td>
										<td><?= $row['normalized_score'] ?></td>
										<td><?= $rank[$row['id'] . '-' . $row['nama']] ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="portlet box grey-cascade">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-globe"></i> Peringkat 3 Teratas Berdasarkan Divisi
						</div>
					</div>
					<div class="portlet-body" style="overflow-x: scroll;">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th class="text-center" rowspan="2" style="vertical-align: middle;">Karyawan</th>
									<th class="text-center" colspan="<?= count($result[0]['votes']) ?>">Peringkat</th>
									<th class="text-center" rowspan="2" style="vertical-align: middle;">Skor Akhir</th>
									<th class="text-center" rowspan="2" style="vertical-align: middle;">Bobot Setelah Normalisasi</th>
									<th class="text-center" rowspan="2" style="vertical-align: middle;">Rangking</th>
								</tr>
								<tr>
									<?php for ($i = 0; $i < count($result[0]['votes']); $i++): ?>
										<th class="text-center"><?= $i + 1 ?></th>
									<?php endfor; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($top_ranks as $i => $row): ?>
									<tr>
										<td><?= $row['nama'] ?></td>
										<?php foreach ($row['votes'] as $vote): ?>
											<td><?= $vote ?></td>
										<?php endforeach; ?>
										<td><?= $row['final_score'] ?></td>
										<td><?= $row['normalized_score'] ?></td>
										<td><?= $rank[$row['id'] . '-' . $row['nama']] ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<!-- END PAGE CONTENT INNER -->
</div>