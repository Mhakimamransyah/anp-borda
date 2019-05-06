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
							<i class="fa fa-globe"></i> Data Kriteria
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
							<a href="#portlet-config" data-toggle="modal" class="config">
							</a>
							<a href="javascript:;" class="reload">
							</a>
							<a href="javascript:;" class="remove">
							</a>
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-5">
									<div class="btn-group">
			                             <a href="<?= base_url()?>admin/tambah-kriteria">
										<button id="sample_editable_1_new" class="btn green">
										Tambah Data Kriteria <i class="fa fa-plus"></i>
										</button></a>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Kriteria</th>
									<th>Bobot</th>
									<th>Deskripsi</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($kriteria as $i => $row): ?>
									<tr>
										<td><?= $i + 1 ?></td>
										<td><?= $row->kriteria ?></td>
										<td><?= $row->bobot ?></td>
										<td><?= $row->deskripsi ?></td>
										<td>
											<a href="<?= base_url('admin/edit-kriteria/' . $row->id) ?>" class="btn btn-primary">
												<i class="fa fa-edit"></i>
											</a>
											<a href="<?= base_url('admin/data-kriteria/' . $row->id) ?>" class="btn btn-danger">
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