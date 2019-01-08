{{--       @foreach($monitoring as $id => $mon)
      <tr>
        <td>{{ date('d-m-Y', strtotime($mon->date)) }}</td>
        <td>{{ $mon->i_name }}</td>
        <td><button id="nota" class="btn btn-info btn-sm nota" 
                data-toggle="modal" 
                data-target="#nota"
                data-id="{{ $mon->sd_item }}">
                {{ $mon->nota }}</button>
        </td>
        <td>{{ $mon->jumlah }}</td>
        <td>{{ $mon->s_qty }}</td>
        <td>
          <?php 
            $j_kebutuhan = $mon->jumlah - $mon->s_qty < 0 ? 0 :  $mon->jumlah - $mon->s_qty;
            echo $j_kebutuhan;
          ?>
        </td>
        <td>{{ $mon->pp_qty }}</td>
        <td>{{ $j_kebutuhan - $mon->pp_qty < 0 ? 0 : $j_kebutuhan - $mon->pp_qty }}</td>
        <td>
          <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-info btn-sm plan" data-id="{{ $mon->sd_item }}">Plan</a>
        </td>
      </tr>
      @endforeach --}}