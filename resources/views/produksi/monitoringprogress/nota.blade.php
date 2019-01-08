	<div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">    
		<div class="col-md-3 col-sm-2 col-xs-12" style="vertical-align: middle;">
		<label class="tebal">Tanggal Order :</label>
		</div>

		<div class="col-md-6 col-sm-7 col-xs-12">
		<div class="form-group" style="display: ">
		  <div class="input-daterange input-group">
		    <input id="tanggal1" class="form-control input-sm datepicker1" readonly  name="tanggal" type="text" value="{{date('d M Y', strtotime($tgl1))}}">
		    <span class="input-group-addon">-</span>
		    <input id="tanggal2" class="input-sm form-control datepicker2" readonly name="tanggal" type="text" value="{{date('d M Y', strtotime($tgl2))}}">
		  </div>
		</div>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-12" align="left">
        	<h4 id="judul-item" style="padding-bottom: 5px; margin-left: 10px">Tes</h4>
        </div>
        
      </div>
	<table class="table tabelan table-hover table-bordered" id="tableNotaPlan">
		<thead>
		  <tr>
		  	<th>No</th>
		    <th>No Nota</th>
		    <th>Nama</th>
		    <th>Tanggal</th>
		    <th style="width:13%;">Jumlah Order</th>
		  </tr>
		</thead>
		<tbody>
		@foreach ($detail as $index => $item)
			<tr>
				<td>{{ $index+1 }}</td>
				<td>{{ $item->s_note }}</td>
				<td>{{ $item->c_name }}</td>
				<td>{{ $item->s_date }}</td>
				<td>{{ (int)$item->sd_qty }}</td>
			</tr>
		@endforeach

		</tbody>
	</table>

<script type="text/javascript">
	$('#tableNotaPlan').DataTable();
	
</script>