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
							<i class="fa fa-globe"></i> Form Tambah Divisi
						</div>
					</div>
					<div class="portlet-body">
						<?= form_open_multipart('admin/tambah-divisi') ?>
							<div class="form-group">
								<label for="divisi">Nama Divisi</label>
								<input type="text" name="divisi" class="form-control">
							</div>
							<div class="form-group">
								<label for="deskripsi">Deskripsi</label>
								<textarea name="deskripsi" class="form-control"></textarea>
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