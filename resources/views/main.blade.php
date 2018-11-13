<!DOCTYPE html>
<html>
   <head>
    
      @include('layouts._head')
      @yield('extra_styles')
   </head>
   <body class="no-skin">

    <div style="background: white; box-shadow: 0px 0px 10px #aaa; width: 70%; position: fixed; z-index: 1999; left: 24em; bottom: 5em; border-radius: 5px; display: none;">
      <div class="col-md-10" style="background: none; padding: 20px 20px; font-weight: 600;">
        Tampaknya Periode Keuangan Sudah Memasuki Bulan Baru, Jangan Lupa Untuk Membuat Periode Baru Untuk Bulan Ini.
      </div>

      <div class="col-md-2" style="padding: 10px;">
        <button class="btn btn-primary">Buat Sekarang</button>
      </div>
    </div>

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
      @include('layouts._scripts')
      @yield('extra_scripts')
  </body>
</html>
