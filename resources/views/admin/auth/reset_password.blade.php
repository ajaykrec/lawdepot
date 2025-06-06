<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ $meta['title'] ?? '' }}</title>
  <meta name="description" content="{{ $meta['description'] ?? '' }}" >
  <meta name="keywords" content="{{ $meta['keywords'] ?? '' }}" >
  {{-- Favicons --}}
  <link rel="icon" href="{{ config('app.admin_asset_url') . '/assets/img/favicon.ico' }}" type="image/gif" sizes="16x16"> 
  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> 
  {{-- Vendor CSS Files --}}
  <link href="{{ config('app.admin_asset_url') . '/assets/vendor/bootstrap/css/bootstrap.min.css' }}" rel="stylesheet">
  <link href="{{ config('app.admin_asset_url') . '/assets/vendor/bootstrap-icons/bootstrap-icons.css' }}" rel="stylesheet">
  <link href="{{ config('app.admin_asset_url') . '/assets/vendor/boxicons/css/boxicons.min.css' }}" rel="stylesheet">
  <link href="{{ config('app.admin_asset_url') . '/assets/vendor/quill/quill.snow.css' }}" rel="stylesheet">
  <link href="{{ config('app.admin_asset_url') . '/assets/vendor/quill/quill.bubble.css' }}" rel="stylesheet">
  <link href="{{ config('app.admin_asset_url') . '/assets/vendor/remixicon/remixicon.css' }}" rel="stylesheet">
  <link href="{{ config('app.admin_asset_url') . '/assets/vendor/simple-datatables/style.css' }}" rel="stylesheet"> 
  {{-- Template Main CSS File --}}
  <link href="{{ config('app.admin_asset_url') . '/assets/css/style.css' }}" rel="stylesheet">
</head>
<body>
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center bgBox">

              <div class="d-flex justify-content-center py-4">
                <a class="logo d-flex align-items-center w-auto">
                  <img src="{{ $logo }}" class="img-thumb">   
                </a>
              </div>

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Reset password</h5>                         
                  </div>

                  @error('common_error')
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{$message}}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif                  

                  <form class="row g-3" name="resetpasswordFrm" id="resetpasswordFrm" method="post" action="{{ route('reset.password.post') }}" autocomplete="off" onsubmit="return validate_form()">
                    @csrf
                    
                    <input type="hidden" name="email" value="{{ $email ?? ''}}">               
                    <input type="hidden" name="token" value="{{ $token ?? ''}}">                                   

                    <div class="col-12">
                      <label class="form-label">New Password</label>
                      <input type="password" class="form-control"  name="password" id="password" value="" autocomplete="off">
                      <span class="err" id="error-password">
                      @error('password')
                      {{$message}}
                      @enderror 
                      </span>
                    </div>  

                    <div class="col-12">
                      <label class="form-label">Confirm Password</label>
                      <input type="password" class="form-control"  name="password_confirmation" id="password_confirmation" value="" autocomplete="off">
                      <span class="err" id="error-password_confirmation">
                      @error('confirmed')
                      {{$message}}
                      @enderror 
                      </span>
                    </div>  

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Submit</button>
                    </div>                   

                  </form>
                </div>
              </div>
              
              {{--
              <div class="credits">                
              Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>
              --}}

            </div>
          </div>
        </div>

      </section>

    </div>
  </main>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  {{-- Vendor JS Files --}}  
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/apexcharts/apexcharts.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/chart.js/chart.umd.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/echarts/echarts.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/quill/quill.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/simple-datatables/simple-datatables.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/tinymce/tinymce.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/php-email-form/validate.js' }}"></script>

  {{-- Template Main JS File --}}   
  <script src="{{ config('app.admin_asset_url') . '/assets/js/main.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/js/validation.js' }}"></script>
  <script>
  const form = document.getElementById('resetpasswordFrm');


  form.querySelector('[name="password"]')
  .addEventListener('keyup',(e)=>{
    validate_password('password')
  })

  const validate_password = (field_name)=>{	
    let input = form.elements[field_name]
    
    if (input.value.trim() === "") {
        input.classList.add("error")
        document.getElementById('error-'+field_name).innerHTML = 'This is required'
        return 1
    }
    else{
        input.classList.remove("error")
        document.getElementById('error-'+field_name).innerHTML = ''
        return 0
    }
  } 

  const validate_form = ()=>{
      var total_error = 0;      
      total_error = total_error + validate_password('password')      
      if( total_error == 0 ){ 
        return true;
      }
      else{
        return false;
      }
  }
  // form.addEventListener('submit', (event)=>{
  //   event.preventDefault()    
  //   if( validate_form() ){       
  //     return true
  //   }
  //   else{
  //     return false
  //   }
  // })
  </script>
</body>
</html>