@extends('admin.layout.main')

@section('page-content')

<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>            
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    @if($user['profile_image'])  
                    <img src="{{ url('/storage/uploads/profile/'.$user['profile_image']) }}" alt="" class="rounded-circle">
                    @else
                    <img src="{{ config('app.admin_asset_url') }}/assets/img/default-profile.png" alt="" class="rounded-circle">
                    @endif      
                    <h2>{{ $user['name'] ?? '' }}</h2>
                    <h3>{{ $user['users_types']['user_type'] ?? '' }}</h3>

                    @if($user['social_media'])
                    <div class="social-links mt-2">
                        @foreach( $user['social_media'] as $val)
                        <a href="{{ $val['url'] ?? '' }}" target="_blank" class="twitter"><i class="{{ $val['icon'] ?? '' }}"></i></a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-2">

                    <div class="row my-3">                   
                    <div class="col-lg-12 col-md-12 col-12">
                    <div class="text-start">
                    <a href="{{ route('profile.update') }}" class="btn btn-sm btn-secondary">Edit Profile</a>
                    <a href="{{ route('profile.change.password') }}" class="btn btn-sm btn-secondary">Change Password</a>
                    </div>
                    </div>                         
                    </div>  
                    
                    <div class="tab-content">
                        <div class="tab-pane fade show active profile-overview">

                            @if($user['about'])
                            <h5 class="card-title">About</h5>
                            <p class="small fst-italic">{{ $user['about'] ?? '' }}</p>
                            @endif

                            <h5 class="card-title">Profile Details</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                <div class="col-lg-9 col-md-8">{{ $user['name'] ?? '' }}</div>
                            </div>

                            @if($user['company'])
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Company</div>
                                <div class="col-lg-9 col-md-8">{{ $user['company'] ?? '' }}</div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Role</div>
                                <div class="col-lg-9 col-md-8">{{ $user['users_types']['user_type'] ?? '' }}</div>
                            </div>
                            
                            @if($user['country'])
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Country</div>
                                <div class="col-lg-9 col-md-8">{{ $user['country'] ?? '' }}</div>
                            </div>
                            @endif

                            @if($user['address'])
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Address</div>
                                <div class="col-lg-9 col-md-8">{{ $user['address'] ?? '' }}</div>
                            </div>
                            @endif

                            @if($user['phone_number'])
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Phone</div>
                                <div class="col-lg-9 col-md-8">{{ $user['phone_number'] ?? '' }}</div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ $user['email'] ?? '' }}</div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
    
@endsection