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
								<tr>
									<td>1</td>
									<td>60108009</td>
									<td>Iwed Alamso</td>
									<td>Marketing</td>
									<td>3 Tahun</td>
									<td>Karyawan Tetap</td>
									<td>
										<a href="#" class="btn btn-primary">
											<i class="fa fa-edit"></i>
										</a>
										<a href="#" class="btn btn-danger">
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
								<tr>
									<td>2</td>
									<td>600417001</td>
									<td>Robbie</td>
									<td>Collection</td>
									<td>2 Tahun</td>
									<td>Karyawan Tetap</td>
									<td>
										<a href="#" class="btn btn-primary">
											<i class="fa fa-edit"></i>
										</a>
										<a href="#" class="btn btn-danger">
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
	                       </tbody>
	                   </table>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>
	</div>
</div>