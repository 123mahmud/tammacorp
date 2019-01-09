
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

	</tbody>
</table>



<script type="text/javascript">
	var tableNotaPlan = $('#tableNotaPlan').DataTable({
	      processing: true,
	      serverSide: true,
	      ajax: {
	          url : baseUrl + "/penjualan/monitoringorder/nota/tabel/"+ {{ $data->i_id }},
	      },
       columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
        {data: 's_note', name: 's_note'},
        {data: 'c_name', name: 'c_name'},
        {data: 's_date', name: 's_date'},
        {data: 'sd_qty', name: 'sd_qty'},
    	],
    	language: {
	      searchPlaceholder: "Cari Data",
	      emptyTable: "Tidak ada data",
	      sInfo: "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
	      sSearch: '<i class="fa fa-search"></i>',
	      sLengthMenu: "Menampilkan &nbsp; _MENU_ &nbsp; Data",
	      infoEmpty: "",
	      paginate: {
	            previous: "Sebelumnya",
	            next: "Selanjutnya",
	         }
    }
   });
</script>