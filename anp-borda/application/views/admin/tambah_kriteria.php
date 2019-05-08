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
							<i class="fa fa-globe"></i> Form Tambah Kriteria
						</div>
					</div>
					<div class="portlet-body">
						<?= form_open_multipart('admin/tambah-kriteria') ?>
							<div class="form-group">
								<label for="kriteria">Nama Kriteria</label>
								<input type="text" name="kriteria" class="form-control">
							</div>
							<div class="form-group">
								<label for="bobot">Bobot</label>
								<input type="number" name="bobot" class="form-control">
							</div>
							<div class="form-group">
								<label for="deskripsi">Deskripsi</label>
								<textarea name="deskripsi" class="form-control"></textarea>
							</div>
							<div>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th class="text-center">Subkriteria</th>
											<th class="text-center">-</th>
										</tr>
									</thead>
									<tbody id="subkriteria-container">
										<tr>
											<td class="text-center tbl-number">1</td>
											<td>
												<input type="text" class="form-control" name="subkriteria[]" required>
											</td>
											<td class="text-center" style="vertical-align: middle !important;">
					                          <button style="width: 38px;" class="btn red btn-xs" onclick="delete_row(this);" type="button">
					                            <i class="fa fa-close"></i>
					                          </button>
					                        </td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="form-group">
								<button type="button" class="btn yellow-gold btn-xs" onclick="add_subkriteria()">Add Row</button>
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

<script type="text/javascript">
	let subkriteriaCount = 1;

	function add_subkriteria() {
		$('#subkriteria-container').append('<tr>' +
				'<td class="text-center tbl-number">' + (++subkriteriaCount) + '</td>' +
				'<td>' +
					'<input type="text" class="form-control" name="subkriteria[]" required>' +
				'</td>' +
				'<td class="text-center" style="vertical-align: middle !important;">' +
                  '<button style="width: 38px;" class="btn red btn-xs" onclick="delete_row(this);" type="button">' +
                    '<i class="fa fa-close"></i>' +
                  '</button>' +
                '</td>' +
			'</tr>');
	}

	function delete_row(obj) {
		$(obj).parent()
			.parent()
			.remove();

		subkriteriaCount--;
		re_numbering();
	}

	function re_numbering() {
		$('.tbl-number').each(function(index, row) {
			$(row).text((Number)(index + 1));
		});
	}
</script>