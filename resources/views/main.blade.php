<!DOCTYPE html>
<html>
   <head>
    
      @include('layouts._head')
      @yield('extra_styles')
   </head>
   <body class="no-skin">

    <div class="overlay main">
      <div class="content-loader" style="background: none; width:60%; margin: 17em auto; text-align: center; color: #eee;">
        <h3><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h3>
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
