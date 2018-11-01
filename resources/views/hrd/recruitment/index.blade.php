<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tammafood | Recruitment</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/recruitment/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('assets/recruitment/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/recruitment/vendor/fontgoogle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/recruitment/vendor/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/recruitment/css/stylish-portfolio.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">
    <style type="text/css">
      .col-form-label {
        text-align: left;
      }
      .has-error {
        border: 1px solid #f00;
      }
    </style>

    <style type="text/css">
      .wizard {
          margin: 20px auto;
          background: transparent;
      }

      .wizard .nav-tabs {
          position: relative;
          margin: 40px auto;
          margin-bottom: 0;
          border-bottom-color: #e0e0e0;
          display: -webkit-box;
          display: -moz-box;
          display: -ms-flexbox;
          display: -webkit-flex;
          display: flex;
          -webkit-flex-flow: row wrap;
          justify-content: space-around;
          -webkit-justify-content: space-around;
          flex-wrap: nowrap;
          -webkit-flex-wrap: nowrap;
      }

      .wizard > div.wizard-inner {
          position: relative;
      }

      .nav-tabs .nav-link.disabled{
        cursor: not-allowed;
      }

      .nav-tabs > li .disabled span.round-tab {
          background-color: #e0e0e0;
      }

      .connecting-line {
          height: 2px;
          background: #e0e0e0;
          position: absolute;
          width: 80%;
          margin: 0 auto;
          left: 0;
          right: 0;
          top: 50%;
          z-index: 1;
      }

      .wizard .nav-tabs > li.active > a,
      .wizard .nav-tabs > li.active > a:hover,
      .wizard .nav-tabs > li.active > a:focus {
          color: #555555;
          cursor: default;
          border: 0;
          border-bottom-color: transparent;
      }

      span.round-tab {
          width: 70px;
          height: 70px;
          line-height: 70px;
          display: inline-block;
          border-radius: 100px;
          background: #fff;
          border: 2px solid #e0e0e0;
          z-index: 2;
          position: absolute;
          left: 0;
          text-align: center;
          font-size: 25px;
      }

      span.round-tab i {
          color: #555555;
      }

      .wizard li a.active span.round-tab {
          background: #fff;
          border: 2px solid #5bc0de;

      }

      .wizard li a.active span.round-tab i {
          color: #5bc0de;
      }

      span.round-tab:hover {
          color: #333;
          border: 2px solid #333;
      }

      

      .wizard li a:after {
          content: " ";
          position: relative;
          left: 46%;
          top: -20px;
          opacity: 0;
          margin: 0 auto;
          bottom: 0px;
          border: 5px solid transparent;
          border-bottom-color: #5bc0de;
          transition: 0.1s ease-in-out;
      }

      .wizard li.active.nav-item:after {
          content: " ";
          position: relative;
          left: 46%;
          top: -20px;
          opacity: 1;
          margin: 0 auto;
          bottom: 0px;
          border: 10px solid transparent;
          border-bottom-color: #5bc0de;
      }

      .wizard .nav-tabs > li a {
          width: 70px;
          height: 70px;
          margin: 20px auto;
          border-radius: 100%;
          padding: 0;
          position: relative;
      }

      .wizard .nav-tabs > li a:hover {
          background: transparent;
      }

      .wizard .tab-pane {
          position: relative;
          padding-top: 50px;
      }

      .wizard h3 {
          margin-top: 0;
      }

      @media( max-width: 585px) {

          .wizard {
              width: 90%;
              height: auto !important;
          }

          span.round-tab {
              font-size: 16px;
              width: 50px;
              height: 50px;
              line-height: 50px;
          }

          .wizard .nav-tabs > li a {
              width: 50px;
              height: 50px;
              line-height: 50px;
          }

          .wizard li.active:after {
              content: " ";
              position: absolute;
              left: 35%;
          }
      }
    </style>

    <style type="text/css">
      
      .file-upload{display:block;text-align:center;font-family: Helvetica, Arial, sans-serif;font-size: 12px;}
      .file-upload .file-select{display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
      .file-upload .file-select .file-select-button{background:#dce4ec;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
      .file-upload .file-select .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
      .file-upload .file-select:hover{border-color:#34495e;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
      .file-upload .file-select:hover .file-select-button{background:#34495e;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
      .file-upload.active .file-select{border-color:#3fa46a;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
      .file-upload.active .file-select .file-select-button{background:#3fa46a;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
      .file-upload .file-select input[type=file]{z-index:100;cursor:pointer;position:absolute;height:100%;width:100%;top:0;left:0;opacity:0;filter:alpha(opacity=0);}
      .file-upload .file-select.file-select-disabled{opacity:0.65;}
      .file-upload .file-select.file-select-disabled:hover{cursor:default;display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;margin-top:5px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
      .file-upload .file-select.file-select-disabled:hover .file-select-button{background:#dce4ec;color:#666666;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
      .file-upload .file-select.file-select-disabled:hover .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
    </style>

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <a class="menu-toggle rounded" href="#">
      <i class="fas fa-bars"></i>
    </a>
    <nav id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand">
          <a class="js-scroll-trigger" href="#page-top">Top</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger" href="#form_wizard">Apply</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger" href="#about">About</a>
        </li>
      </ul>
    </nav>

    <!-- Header -->
    <header class="masthead d-flex">
      <div class="container text-center my-auto">
        <a class="btn btn-danger btn-xl js-scroll-trigger" style="margin-top: 380px; margin-right: 30px;" href="#about">About Tammafood</a>
        <a class="btn btn-primary btn-xl js-scroll-trigger" style="margin-top: 380px; margin-left: 30px;" href="#form_wizard">Apply Now</a>
      </div>
      <div class="overlay"></div>
    </header>

    {{-- Wizard --}}
    <section class="content-section bg-light" >
      <div class="container text-center">
        <img src="{{url('/public/assets/gif/Loading_icon.gif')}}" id="gif" style="display: block; margin: 0 auto; width: 100px; visibility: hidden;">
        <form class="form cf" action="{{ url('recruitment/save') }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="wizard">
            <div class="wizard-inner">
              <div class="connecting-line"></div>
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="nav-item">
                  <a href="#apply" data-toggle="tab" aria-controls="apply" role="tab" title="Data Diri" class="nav-link active">
                    <span class="round-tab">
                      <i class="fa fa-user"></i>
                    </span>
                  </a>
                </li>
                
                <li role="presentation" class="nav-item">
                  <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Daftar Riwayat Hidup" class="nav-link disabled">
                    <span class="round-tab">
                      <i class="fa fa-history"></i>
                    </span>
                  </a>
                </li>
                
                <li role="presentation" class="nav-item">
                  <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Upload Berkas" class="nav-link disabled">
                    <span class="round-tab">
                      <i class="fa fa-file-archive"></i>
                    </span>
                  </a>
                </li>
                
                <li role="presentation" class="nav-item">
                  <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Finish" class="nav-link disabled">
                    <span class="round-tab">
                      <i class="fa fa-check"></i>
                    </span>
                  </a>
                </li>
              </ul>
            </div>

            <div class="tab-content" id="form_wizard">
              <!-- tab data diri -->
              @include('hrd.recruitment.tab-datadiri')
              <!-- tab cv -->
              @include('hrd.recruitment.tab-cv')
              <!-- tab berkas -->
              @include('hrd.recruitment.tab-berkas')
              <!-- tab finish step -->
              <div class="tab-pane" role="tabpanel" id="step4">
                <h1 class="text-md-center">Complete</h1>
                <div class="row"></div>
                <ul class="list-inline text-md-center">
                    <li><button type="submit" class="btn btn-lg btn-primary next-button" id="btn_apply_finish">Finish</button></li>
                    <li><a href="#form_wizard" class="btn btn-lg btn-common prev-step next-button js-scroll-trigger">Back</a></li>
                </ul>
              </div>

              <div class="clearfix"></div>
            </div>

          </div>
        </form>
      </div>
    </section>



    <!-- About -->
    <section class="content-section bg-primary text-white text-center" id="about">
      <div class="container">
        <div class="content-section-heading">
          <h3 class="text-secondary mb-0">About</h3>
          <h2 class="mb-5">Tammafood</h2>
        </div>
        <p class="lead mb-5">CV. Tamma Robbah Indonesia adalah salah satu produsen tortilla dan berbagai perlengkapan kebutuhan bahan baku kebab di indonesia. Berdiri sejak 2008 dan sudah memiliki ijin PIRT dan Halal MUI.</p>
        <p class="lead">Alamat kami Jalan Randu no. 74. Sidotopo Wetan. Surabaya.</p>
        <p class="lead">Butuh Konsultasi. Silahkan Hubungi Customer Service kami 0812-3456-1066</p>
      </div>
    </section>
    <section id="contact" class="map">
      <iframe width="100%" height="100%" frameborder="0" scrolling="true" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d989.5326478226659!2d112.76258721077522!3d-7.225942202698499!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f9aaab9b9ad5%3A0xb6f7039d2cc4db9c!2sTamma+Robah+Indonesia!5e0!3m2!1sen!2sid!4v1534411169797"></iframe>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
      <div class="container">
        <span><img src="{{ asset('assets/img/tammafood.png') }}" alt="" height="50"></span>
        </br>
        <p class="text-muted small mb-0" style="margin-top: 10px;">Copyright &copy; Alamraya Sebar Barokah</p>
      </div>
    </footer>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('assets/recruitment/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/recruitment/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{ asset('assets/recruitment/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ asset('assets/recruitment/js/stylish-portfolio.min.js') }}"></script>
    <script src="{{ asset('assets/recruitment/vendor/dobPicker.min.js') }}"></script>
    <script src="{{ asset('js/iziToast.min.js') }}"></script>
    <script type="text/javascript">
      var baseUrl = '{{url('/')}}';
      $('#foto').bind('change', function () {
        var filename = $("#foto").val();
        var fsize = $('#foto')[0].files[0].size;
        if(fsize>2048576) //do something if file size more than 1 mb (1048576)
        {
            return false;
        }
        if (/^\s*$/.test(filename)) {
          $(".file-upload").removeClass('active');
          $("#noFile").text("No file chosen..."); 
        }
        else {
          $(".file-upload").addClass('active');
          $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
        }
      });

        var loadFile = function(event) {
        var fsize = $('#foto')[0].files[0].size;
        if(fsize>1048576) //do something if file size more than 1 mb (1048576)
        {
            iziToast.warning({
              icon: 'fa fa-times',
              message: 'File Is To Big!',
            });
            return false;
        }
        var reader = new FileReader();
        reader.onload = function(){
          var output_foto = document.getElementById('output_foto');
          output_foto.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
      };
      
      $(document).ready(function(){
        $.dobPicker({
          // Selectopr IDs
          daySelector: '#dobday',
          monthSelector: '#dobmonth',
          yearSelector: '#dobyear',
         /* yearSelector: '#dob_cv_awal1',
          yearSelector: '#dob_cv_akhir1',
          yearSelector: '#dob_cv_awal2',
          yearSelector: '#dob_cv_akhir2',*/

          // Default option values
          dayDefault: 'Tangal',
          monthDefault: 'Bulan',
          yearDefault: 'Tahun',

          // Minimum age
          minimumAge: 10,

          // Maximum age
          maximumAge: 80
        });

        $.dobPicker({
          yearSelector: '#dob_pend_awal1',
          yearDefault: 'Tahun Masuk',
          minimumAge: 0,
          maximumAge: 20
        });

        $.dobPicker({
          yearSelector: '#dob_pend_akhir1',
          yearDefault: 'Tahun Lulus',
          minimumAge: 0,
          maximumAge: 20
        });

        $.dobPicker({
          yearSelector: '#dob_cv_awal1',
          yearDefault: 'Tahun Masuk',
          minimumAge: 0,
          maximumAge: 20
        });

        $.dobPicker({
          yearSelector: '#dob_cv_awal2',
          yearDefault: 'Tahun Keluar',
          minimumAge: 0,
          maximumAge: 20
        });

        $.dobPicker({
          yearSelector: '#dob_cv_akhir1',
          yearDefault: 'Tahun masuk',
          minimumAge: 0,
          maximumAge: 20
        });

        $.dobPicker({
          yearSelector: '#dob_cv_akhir2',
          yearDefault: 'Tahun Keluar',
          minimumAge: 0,
          maximumAge: 20
        });

        $('#btn_cekemail').click(function(event) {
          var email = $('#email').val();
          $.ajax({
            url : baseUrl + "/recruitment/cek-email",
            type: "get",
            dataType: "JSON",
            data: {email:email},
            success: function(response)
            {
              if(response.status == "sukses")
              {
                $('#notlp').attr('readonly', false);
                $('#btn_cekwa').attr('disabled', false);
              }
              else
              {
                iziToast.error({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#email').focus(); //change button text
                  }
                }); 
              }
            },
            error: function(){
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            },
            async: false
          });
        });

        $('#btn_cekwa').click(function(event) {
          var wa = $('#notlp').val();
          $.ajax({
            url : baseUrl + "/recruitment/cek-wa",
            type: "get",
            dataType: "JSON",
            data: {wa:wa},
            success: function(response)
            {
              if(response.status == "sukses")
              {
                $('#agama').attr('disabled', false);
                $('#status').attr('disabled', false);
                $('#partner_name').attr('readonly', false);
                $('#anak').attr('readonly', false);
                $('#promo').attr('readonly', false);
              }
              else
              {
                iziToast.error({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#notlp').focus(); //change button text
                  }
                }); 
              }
            },
            error: function(){
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            },
            async: false
          });
        });

        $('input.numberinput').bind('keypress', function (e) {
          return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });

        $('#email').focus(function(event) {
          $(this).val("");
          $('#notlp').attr('readonly', true);
          $('#btn_cekwa').attr('disabled', true);
          $('#agama').attr('disabled', true);
          $('#status').attr('disabled', true);
          $('#partner_name').attr('readonly', true);
          $('#anak').attr('readonly', true);
        });

        $('#notlp').focus(function(event) {
          $(this).val("");
          $('#agama').attr('disabled', true);
          $('#status').attr('disabled', true);
          $('#partner_name').attr('readonly', true);
          $('#anak').attr('readonly', true);
        });

        /*$('#btn_apply_finish').submit(function() {
            $('#gif').show(); 
            return true;
        });*/

      });//end jquery
    </script>
    <script type="text/javascript">
       //Initialize tooltips
       $('.nav-tabs > li a[title]').tooltip();

       //Wizard
       $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

           var $target = $(e.target);

           if ($target.hasClass('disabled')) {
               return false;
           }
       });

       $(".next-step").click(function (e) {
           var $active = $('.wizard .nav-tabs .nav-item .active');
           var $activeli = $active.parent("li");

           $($activeli).next().find('a[data-toggle="tab"]').removeClass("disabled");
           $($activeli).next().find('a[data-toggle="tab"]').click();
       });


       $(".prev-step").click(function (e) {

           var $active = $('.wizard .nav-tabs .nav-item .active');
           var $activeli = $active.parent("li");

           $($activeli).prev().find('a[data-toggle="tab"]').removeClass("disabled");
           $($activeli).prev().find('a[data-toggle="tab"]').click();

       });

    </script>

  </body>

</html>
