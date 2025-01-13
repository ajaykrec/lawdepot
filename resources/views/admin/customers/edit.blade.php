@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
    <form id="dataForm" name="dataForm" method="post" action="{{ route('customers.update',$id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf   
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">  
                    
                <div class="my-3">
                <label class="form-label">Profile Photo ({{ $width }}X{{ $height }} Pixel)</label>
                <div id="imgdiv-outer">
                    @php  
                    $profile_photo = old('profile_photo', $data['profile_photo'] ?? '');
                    @endphp
                    @if($profile_photo)  
                        @php
                            $array = [
                                'table'=>'customers',
                                'table_id'=>'customer_id',
                                'table_id_value'=>$id ?? '',
                                'table_field'=>'profile_photo',
                                'file_name'=>$profile_photo,
                                'file_path'=>'uploads/customers',
                            ];
                            $json_string = json_encode($array);
                        @endphp
                        <div class="imgdiv">
                        <span title="Remove" class="delete_image" data-content="{{ $json_string }}">X</span>
                        <img src="{{ url('/storage/uploads/customers/'.$profile_photo) }}" class="img-thumb" width="100">                    
                        </div>      
                        <input type="hidden" name="profile_photo" value="{{ $profile_photo }}"> 
                               
                    @else
                        <input class="form-control" type="file" name="profile_photo"> 
                        <span class="err" id="error-profile_photo">
                        @error('profile_photo')
                        {{$message}}
                        @enderror 
                        </span>               
                    @endif
                </div>                      
                </div>

                <div class="my-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" id="page_name" name="name" value="{{ old('name', $data['name'] ?? '') }}"> 
                <span class="err" id="error-name">
                @error('name')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $data['email'] ?? '') }}"> 
                <span class="err" id="error-email">
                @error('email')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $data['phone'] ?? '') }}"> 
                <span class="err" id="error-phone">
                @error('phone')
                {{$message}}
                @enderror 
                </span>                 
                </div>
                

                <div class="my-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob',$data['dob'] ?? '') }}" > 
                <span class="err" id="error-dob">
                @error('dob')
                {{$message}}
                @enderror 
                </span>                 
                </div>

                <div class="my-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}"> 
                <span class="err" id="error-password">
                @error('password')
                {{$message}}
                @enderror 
                </span>                 
                </div>  

                <div class="my-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="{{ old('confirm_password') }}"> 
                <span class="err" id="error-confirm_password">
                @error('confirm_password')
                {{$message}}
                @enderror 
                </span>                 
                </div>          

                <div class="my-3">
                <label class="form-label">Status</label>
                @php
                $status = old('status', $data['status'] ?? '');
                @endphp
                <select class="form-select" name="status"> 
                <option value=""></option>   
                <option value="1" {{ ($status=='1') ? 'selected' : '' }}>Active</option>   
                <option value="0" {{ ($status=='0') ? 'selected' : '' }}>In-Active</option>  
                </select>
                <span class="err" id="error-status">
                @error('status')
                {{$message}}
                @enderror 
                </span>      
                </div>                

                </div>
                </div>

            </div>
           
            <div class="col-lg-12 ">
                <div class="mb-3 text-start">  
                <button type="submit" class="btn btn-primary text-right">Submit</button>
                </div>
            </div> 
        </div>
    </form>
    </section> 
   
    <script>  
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