@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    @if($data['profile_image'])  
                    <img src="{{ url('/storage/uploads/profile/'.$data['profile_image']) }}" alt="" class="rounded-circle">
                    @else
                    <img src="{{ config('app.admin_asset_url') }}/assets/img/default-profile.png" alt="" class="rounded-circle">
                    @endif                    
                    <h2>{{ $data['name'] ?? '' }}</h2>
                    <h3>{{ $data['users_types']['user_type'] ?? '' }}</h3>
                    @if($data['social_media'])
                    <div class="social-links mt-2">
                        @foreach( $data['social_media'] as $val)
                        <a href="{{ $val['url'] ?? '' }}" target="_blank" class="twitter"><i class="{{ $val['icon'] ?? '' }}"></i></a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">                  

                    @if($data['about'])
                    <h5 class="card-title">About</h5>
                    <p class="small fst-italic">{{ $data['about'] ?? '' }}</p>
                    @endif

                    <h5 class="card-title">Profile Details</h5>

                    <div class="row pb-1">
                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                        <div class="col-lg-9 col-md-8">{{ $data['name'] ?? '' }}</div>
                    </div>

                    @if($data['company'])
                    <div class="row pb-1">
                        <div class="col-lg-3 col-md-4 label">Company</div>
                        <div class="col-lg-9 col-md-8">{{ $data['company'] ?? '' }}</div>
                    </div>
                    @endif

                    <div class="row pb-1">
                        <div class="col-lg-3 col-md-4 label">Role</div>
                        <div class="col-lg-9 col-md-8">{{ $data['users_types']['user_type'] ?? '' }}</div>
                    </div>

                    @if($data['country'])
                    <div class="row pb-1">
                        <div class="col-lg-3 col-md-4 label">Country</div>
                        <div class="col-lg-9 col-md-8">{{ $data['country'] ?? '' }}</div>
                    </div>
                    @endif

                    @if($data['address'])
                    <div class="row pb-1">
                        <div class="col-lg-3 col-md-4 label">Address</div>
                        <div class="col-lg-9 col-md-8">{{ $data['address'] ?? '' }}</div>
                    </div>
                    @endif

                    @if($data['phone_number'])
                    <div class="row pb-1">
                        <div class="col-lg-3 col-md-4 label">Phone</div>
                        <div class="col-lg-9 col-md-8">{{ $data['phone_number'] ?? '' }}</div>
                    </div>
                    @endif

                    <div class="row pb-1">
                        <div class="col-lg-3 col-md-4 label">Email</div>
                        <div class="col-lg-9 col-md-8">{{ $data['email'] ?? '' }}</div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
    </section>   
    
@endsection