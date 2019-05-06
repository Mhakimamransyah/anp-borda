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
							<i class="fa fa-globe"></i> Data Perangkingan
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
			                             <a href="<?= base_url()?>admin/perangkingan?process=1">
										<button id="sample_editable_1_new" class="btn green">
										Lakukan Perangkingan 
										</button></a>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>NIK</th>
									<th>Nama</th>
									<th>Kecerdasan Umum</th>
									<th>Keterampilan Kerja</th>
									<th>Kepribadian</th>
									<th>Pengalaman Kerja</th>
									<th>Kemampuan Bersosialisasi</th>
									<th>Pengetahuan Mengenai Perusahaan</th>
									<th>Bobot Final</th>
									<th>Rank</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>60108009</td>
									<td>Iwed Alamso</td>
									<td>0.3616</td>
									<td>0.2868</td>
									<td>0.2754</td>
									<td>0.3555</td>
									<td>0.2974</td>
									<td>0.1111</td>
									<td>0.335</td>
									<td>1</td>
								</tr>
								<tr>
									<td>600417001</td>
									<td>Robbie</td>
									<td>0.1958</td>
									<td>0.2138</td>
									<td>0,3772</td>
									<td>0.0869</td>
									<td>0.2018</td>
									<td>0.2360</td>
									<td>0.2245</td>
									<td>2</td>
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