@php
$user_id     = Auth::id();
$user        = Auth::user()->toArray();
$user['short_name'] = first_letter($user['name']);
$users_types = Auth::user()->users_types->toArray();
/*
p($user_id);
p($user);
p($users_types);
die;
*/
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ $meta['title'] ?? '' }}</title>
  <meta name="description" content="{{ $meta['description'] ?? '' }}">
  <meta name="keywords" content="{{ $meta['keywords'] ?? '' }}">
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
  <script src="{{ config('app.admin_asset_url') . '/assets/js/jquery-3.2.1.min.js' }}"></script>
</head>
<body>   
  <header id="header" class="header fixed-top d-flex align-items-center">
    
    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard')}}" class="logo d-flex align-items-center">
        <img src="{{ config('app.admin_asset_url') }}/assets/img/logo.png" alt="" class="py-2">
        <!-- <span class="d-none d-lg-block">NiceAdmin</span> -->
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    {{--
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div>
    --}}

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        
        {{-- 
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        --}}
        
        {{-- 
        @include('admin.layout.notifications') 
        --}}

        {{-- 
        @include('admin.layout.messages') 
        --}}        

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            @if($user['profile_image'])  
            <img src="{{ url('/storage/uploads/profile/'.$user['profile_image']) }}" alt="" class="rounded-circle">
            @else
            <img src="{{ config('app.admin_asset_url') }}/assets/img/default-profile.png" alt="" class="rounded-circle">
            @endif    
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ $user['short_name']?? '' }}</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ $user['name']?? '' }}</h6>
              <span>{{ $users_types['user_type']?? '' }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            
            {{--
            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            --}}


            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout')}}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul>
        </li>

      </ul>
    </nav>

  </header>
  @include('admin.layout.sidebar') 
  <main id="main" class="main">