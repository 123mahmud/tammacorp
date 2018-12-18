<!DOCTYPE html>
<html>
   <head>
    
      @include('layouts._head')
      @yield('extra_styles')
   </head>
   <body class="no-skin">

    {{-- @if(!periodeExist())
      <div style="background: #ff4444; box-shadow: 0px 0px 10px #aaa; width: 70%; position: fixed; z-index: 1999; left: 24em; bottom: 5em; border-radius: 5px; color: white;">
        <div class="col-md-10" style="background: none; padding: 20px 20px; font-weight: 600;">
          @if(nullperiode())
            Periode Bulan Finansial Belum Ada..
          @else
            Tampaknya Periode Keuangan Sudah Memasuki Bulan Baru, Jangan Lupa Untuk Membuat Periode Baru Untuk Bulan Ini.
          @endif
        </div>

        <div class="col-md-2" style="padding: 10px;">
          <a href="{{ url('system/periode_keuangan') }}"><button class="btn btn-primary">Buat Sekarang</button></a>
        </div>
      </div>
    @endif --}}

    <div class="overlay main">
      <div class="content-loader" style="background: none; width:60%; margin: 17em auto; text-align: center; color: #eee;">
        <div class="lds-hourglass" style="margin-bottom: 20px;"></div><br>
        <span id="load-status-text"></span>
      </div>
    </div>
    
   @include('layouts._sidebar')


     <div class="main-content">
          <div class="main-content-inner">  
             @yield('content')
          </div>
     </div>

     @include('layouts._modal')

      @include('layouts._scripts')
      @yield('extra_scripts')
  </body>
</html>
