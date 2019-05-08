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
							<i class="fa fa-globe"></i> Data Karyawan
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-5">
									<div class="btn-group">
			                             <a href="<?= base_url()?>admin/tambah-karyawan">
										<button id="sample_editable_1_new" class="btn green">
										Tambah Data Karyawan <i class="fa fa-plus"></i>
										</button></a>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Divisi</th>
									<th>Lama Bekerja</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($karyawan as $i => $row): ?>
									<tr>
										<td><?= $i + 1 ?></td>
										<td><?= $row->nik ?></td>
										<td><?= $row->nama ?></td>
										<td><?= $row->divisi->divisi ?></td>
										<td><?= $row->lama_bekerja ?> Tahun</td>
										<td><?= $row->status ?></td>
										<td>
											<a href="<?= base_url('admin/penilaian-karyawan/' . $row->id) ?>" class="btn btn-success btn-xs">Penilaian Karyawan</a>
											<a href="<?= base_url('admin/edit-karyawan/' . $row->id) ?>" class="btn btn-primary btn-xs">
												<i class="fa fa-edit"></i>
											</a>
											<a href="<?= base_url('admin/data-karyawan?id=' . $row->id) ?>" class="btn btn-danger btn-xs">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
	                       </tbody>
	                   </table>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>
	</div>
</div>