<table>
			<thead>
				<tr>
					<th>Nama Pembeli</th>
					<th>Nota</th>
					<th>Tanggal</th>
					<th>Nama Barang</th>
					<th>Qty</th>
					<th>Harga</th>
					<th colspan="2">Diskon %</th>
					<th>Diskon Value</th>
					<th>PPN</th>
					<th>Total</th>
				</tr>
			</thead>

			<tbody>

				@for($i=0;$i<count($penjualan);$i++)
					@for($j=0;$j<count($penjualan[$i]);$j++)
						<tr>
							@if($j == 0)
							<td class="border-none" rowspan="{{count($penjualan[$i]) + 1}}">{{$penjualan[$i][$j]->c_name}}</td>
							@endif
							<td class="text-center">{{$penjualan[$i][$j]->s_note}}</td>
							<td class="text-center">{{date('d M Y', strtotime($penjualan[$i][$j]->s_date))}}</td>
							<td>{{$penjualan[$i][$j]->i_name}}</td>
							<td class="text-center">{{$penjualan[$i][$j]->sd_qty}}</td>
							<td>
								<div class="float-right"> 
									{{number_format($penjualan[$i][$j]->sd_price,2,',','.')}}
								</div>
							</td>
							<td class="text-right">{{$penjualan[$i][$j]->sd_disc_percent}} %</td>
							<td class="text-right">{{number_format($penjualan[$i][$j]->sd_disc_vpercent,2,',','.')}} </td>
							<td class="text-right">{{$penjualan[$i][$j]->sd_disc_value}}</td>
							<td class="text-right">{{number_format(0,2,',','.')}}</td>
							<td class="text-right">{{number_format($penjualan[$i][$j]->sd_total,2,',','.')}}</td>
						</tr>

						@if($j == count($penjualan[$i]) - 1)
							<tr>
								<td class="text-right bold" colspan="3">Total</td>
								<td class="text-center bold">{{$data_sum[$i]->total_qty}}</td>
								<td class="text-right bold"></td>
								<td class="text-right bold" colspan="2">{{number_format($data_sum[$i]->sd_disc_vpercent,2,',','.')}}</td>
								<td class="text-right bold">{{number_format($data_sum[$i]->sd_disc_value,2,',','.')}}</td>
								<td class="text-right bold"></td>
								<td class="text-right bold" colspan="2">{{number_format($data_sum[$i]->total_penjualan,2,',','.')}}</td>
							</tr>
						@endif
						
					@endfor
				@endfor

			</tbody>
</table>
		

			<table>
				<tr>
					<td>Diskon %</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]->allsd_disc_vpercent,2,',','.')}}</td>
				</tr>
				<tr>
					<td>Diskon Value</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]->allsd_disc_value,2,',','.')}}</td>
				</tr>
				<tr>
					<td>DPP</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]->total_semua_penjualan,2,',','.')}}</td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td>:</td>
					<td>{{number_format($data_sum_all[0]->total_semua_penjualan,2,',','.')}}</td>
				</tr>
			</table>
