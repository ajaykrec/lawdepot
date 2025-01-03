@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profile') }}">Profile</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body my-3">

                <form id="profileFrm" name="profileFrm" method="post" 
                action="{{ route('profile.update')}}" enctype="multipart/form-data" onsubmit="return validate_form()">
                @csrf
                <input type="hidden" name="apply_action" value="ok">
                    
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <div id="imgdiv-outer">
                            @if($user['profile_image'])  
                                @php
                                    $array = [
                                        'table'=>'users',
                                        'table_id'=>'user_id',
                                        'table_id_value'=>$user['user_id'] ?? '',
                                        'table_field'=>'profile_image',
                                        'file_name'=>old('profile_image', $user['profile_image'] ?? ''),
                                        'file_path'=>'uploads/profile',
                                    ];
                                    $json_string = json_encode($array);
                                @endphp
                                <div class="imgdiv">
                                <span title="Remove" class="delete_image" data-content="{{ $json_string }}">X</span>
                                <img src="{{ url('/storage/uploads/profile/'.$user['profile_image']) }}" class="img-thumb" width="100">                    
                                </div>      
                                <input type="hidden" name="profile_image" value="{{ old('profile_image', $user['profile_image'] ?? '') }}">        
                            @else
                            <input class="form-control" type="file" name="profile_image"> 
                            @endif
                        </div>                       
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ old('name', $user['name'] ?? '') }}">
                        <span class="err" id="error-name">
                        @error('name')
                        {{$message}}
                        @enderror 
                        </span>                        
                    </div>

                    <div class="mb-3">
                        <label class="form-label">About</label>
                        <textarea name="about" class="form-control" id="about" style="height: 100px">{{ old('about', $user['about'] ?? '') }}</textarea>
                        <span class="err" id="error-about">
                        @error('about')
                        {{$message}}
                        @enderror 
                        </span>                        
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company</label>
                        <input name="company" type="text" class="form-control" id="company" value="{{ old('company', $user['company'] ?? '') }}">
                        <span class="err" id="error-company">
                        @error('company')
                        {{$message}}
                        @enderror 
                        </span>                         
                    </div>    

                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <input name="country" type="text" class="form-control" id="country" value="{{ old('country', $user['country'] ?? '') }}">
                        <span class="err" id="error-country">
                        @error('country')
                        {{$message}}
                        @enderror 
                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input name="address" type="text" class="form-control" id="address" value="{{ old('address', $user['address'] ?? '') }}">
                        <span class="err" id="error-address">
                        @error('address')
                        {{$message}}
                        @enderror 
                        </span>                        
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input name="phone_number" type="text" class="form-control" id="phone_number" value="{{ old('phone_number', $user['phone_number'] ?? '') }}">
                        <span class="err" id="error-phone_number">
                        @error('phone_number')
                        {{$message}}
                        @enderror 
                        </span>                        
                    </div>

                    @if($social_media)
                        @foreach($social_media as $key=>$val)
                        <div class="mb-3">
                            <input name="social_media[{{ $val['name'] }}]" type="text" class="form-control" value="{{ old('social_media.'.$val['name'], $user['social_media'][$val['name']]['url'] ?? '') }}" placeholder="{{ ucfirst($val['name'] ?? '') }} Profile">
                        </div>
                        @endforeach
                    @endif    

                    <div class="mb-3">
                        <label class="form-label"></label>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>

                </form>
                </div>
                </div>

            </div>
        </div>
    </section> 

    <script>
    const form = document.getElementById('profileFrm');

    form.querySelector('[name="name"]')
    .addEventListener('keyup',(e)=>{
        validate_name('name')
    })  
    form.querySelector('[name="about"]')
    .addEventListener('keyup',(e)=>{
        validate_about('about')
    })  
    form.querySelector('[name="phone_number"]')
    .addEventListener('keyup',(e)=>{
        validate_phone_number('phone_number')
    })  

    const validate_name = (field_name)=>{	
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
    const validate_about = (field_name)=>{	
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

    const validate_phone_number = (field_name)=>{	
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
        total_error = total_error + validate_name('name')  
        total_error = total_error + validate_about('about')
        total_error = total_error + validate_phone_number('phone_number')    
        if( total_error == 0 ){ 
            return true;
        }
        else{
            return false;
        }
    }    

    $('.delete_image').on('click', (e)=>{

        let json_string = e.target.getAttribute('data-content')    
        let obj = JSON.parse(json_string)

        swal({		  
            title				: 'Are you sure?',
            text				: 'You want to delete this image',
            type				: 'warning',
            showCancelButton	: true,
            confirmButtonColor  : '#3085d6',
            cancelButtonColor	: '#d33',
            confirmButtonText	: 'Yes, delete it!',
            cancelButtonText	: 'No, cancel!',
            confirmButtonClass  : 'btn btn-success',
            cancelButtonClass	: 'btn btn-danger',
            buttonsStyling	    : false,
            closeOnConfirm	    : false	
        }).then(function () {

            $.ajax({
                type: "delete",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                dataType: "json",
                url: "{{ route('delete.file') }}",   
                data: obj, 
                success: function(response){          
                    $('#imgdiv-outer').html(response.message)  
                    swal('Deleted!','Your file has been deleted.', 'success' )   
                }
            });  
        
        })	
        
    })
    </script>
    
@endsection