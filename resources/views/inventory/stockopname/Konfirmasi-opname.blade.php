<div id="label-badge-tab" class="tab-pane fade">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12"  style="padding-bottom: 10px;">
			<div style="margin-left:-5px;">
				<div class="col-md-1" style="padding: 3px">
					<label class="tebal">Tanggal :</label>
				</div>
				<div class="col-md-4" style="padding: 3px">
					<div class="form-group">
						<div class="input-daterange input-group">
							<input id="tanggal1" class="form-control input-sm datepicker1 " name="tanggal" type="text">
							<span class="input-group-addon">-</span>
							<input id="tanggal2" class="input-sm form-control datepicker2" name="tanggal" type="text"
							value="{{ date('d-m-Y') }}">
						</div>
					</div>
				</div>
				<div class="col-md-2" style="padding: 3px">
					<button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="getConfirm()">
					<strong>
					<i class="fa fa-search" aria-hidden="true"></i>
					</strong>
					</button>
				</div>
				<div class="col-md-1" style="padding: 3px">
					<label class="tebal">Pemilik :</label>
				</div>
				<div class="col-md-4" style="padding: 3px">
					<select name="pemilik-gudang" id="pemilik-gudangc" class="form-control input-sm" onchange="getConfirm()">
						<option value="0">- Pilih gudang</option>
						@foreach ($data as $a)
						<option value="{{ $a->cg_id }}">- {{ $a->cg_cabang }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table tabelan table-hover  table-bordered" width="100%" cellspacing="0" id="table-konfirmasi">
					<thead>
						<tr>
							<th class="wd-15p">Tanggal - Waktu</th>
							<th class="wd-15p">Staff</th>
							<th class="wd-15p">Nota</th>
							<th class="wd-15p">Pemilik</th>
							<th class="wd-15p">Status</th>
							<th class="wd-15p">Aksi</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>