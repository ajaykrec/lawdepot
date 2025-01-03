@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">              
           

                <div class="card">
                    <div class="card-body">



                        <div class="accordion py-2 filter" id="accordionExample">
                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="background:#ccc">
                                Filter Data
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="background:#ccc">
                                <div class="accordion-body">

                                <form id="filterForm" name="filterForm" method="get" action="{{ route('users.index') }}">    
                                <div class="row py-3 ">
                                
                                    <div class="col-lg-4 col-md-6 col-12">
                                    <div class="mb-2">                        
                                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $name ?? '' }}">                      
                                    </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                    <div class="mb-2">                        
                                        <input type="text" class="form-control" placeholder="Email" name="email" value="{{ $email ?? '' }}">              
                                    </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                    <div class="mb-2">                        
                                        <select class="form-select" id="usertype_id" name="usertype_id">
                                        <option value="">User Type</option>
                                        @if($user_types)
                                            @foreach($user_types as $val) 
                                            <option value="{{ $val['usertype_id'] }}" {{ ($usertype_id==$val['usertype_id']) ? 'selected' : '' }}>
                                            {{ $val['user_type'] }}
                                            </option>
                                            @endforeach
                                        @endif
                                        </select>             
                                    </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                    <div class="mb-2">                        
                                        <input type="date" class="form-control" placeholder="Create Date" id="created_at" name="created_at" value="{{ $created_at ?? '' }}">     
                                    </div>
                                    </div>


                                    <div class="col-lg-4 col-md-6 col-12">
                                    <div class="mb-2">
                                        <select class="form-select" id="status" name="status">
                                            <option value="">Status</option>
                                            <option value="1" {{ ($status=='1') ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ ($status=='0') ? 'selected' : '' }}>In-Active</option>
                                        </select>    
                                    </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                    <div class="mb-2">                        
                                        <button type="submit" class="btn btn-primary">Filter</button>                       
                                    </div>
                                    </div>
                                
                                </div>
                                </form>
                                </div>
                            </div>
                            </div>               
                        </div>


                        <div class="d-flex justify-content-end py-3">                        
                        
                        <div>                 
                        <a href="{{ route('users.create') }}" class="btn btn-secondary">+ Add new</a>
                        </div>
                        </div>
                        
                        <form id="applyForm" name="applyForm" method="post" action="{{ route('users.index') }}" >  
                        @csrf
                        <div class="table-responsive">                          
                        <table class="table table-hover table-striped">                            
                            <thead>                                                         
                                <tr class="table-dark">
                                    <th style="width:5%;"><input class="form-check-input checkall" type="checkbox"></th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Type</th>                                    
                                    <th>Create Date</th>
                                    <th>Status</th>                                    
                                    <th class="text-end px-5">Action</th>
                                </tr>                                         
                            </thead>                            
                            <tbody>
                                @if($results)
                                    @foreach($results as $val)
                                    <tr id="row-{{ $val['user_id'] }}">
                                        <td>
                                            @if($val['usertype_id']!='1')
                                            <input class="form-check-input selected-chk" type="checkbox" name="id[]" value="{{ $val['user_id'] }}">
                                            @endif
                                        </td>
                                        <td>{{ $start_count }}</td>
                                        <td>{{ $val['name'] }}</td>  
                                        <td>{{ $val['email'] }}</td>   
                                        <td>{{ $val['users_types']['user_type'] }}</td>        
                                        <td>{{ date('j F, Y, g:i a',strtotime($val['created_at'])) }}</td>                                          
                                        <td>
                                            @if($val['status'] == '1')                                                
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">In-Active</span>                                                
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('users.show',$val['user_id']) }}" class="btn btn-md" title="View"><i class="bi bi-columns-gap text-secondary"></i></a> 
                                            <a href="{{ route('users.edit',$val['user_id']) }}" class="btn btn-md" title="Edit"><i class="bi bi-pencil-square text-success"></i></a>                                            
                                            @if($val['usertype_id']!='1')
                                            <button type="button" class="btn btn-md delete" 
                                            onclick="delete_row({{ $val['user_id'] }})"                             
                                            title="Delete"><i class="bi bi-trash text-danger"></i></button>
                                            @endif
                                        </td>
                                    </tr> 
                                    @php $start_count++; @endphp
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="8">No record found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>                        
                        </div>
                        <div class="d-flex justify-content-start py-0">
                            <div>
                            <select class="form-select" name="apply_action">
                                <option value="">Choose an action...</option>
                                <option value="active">Set as [Active]</option>
                                <option value="in_active">Set as [In-Active]</option>   
                                <option value="delete">Delete</option>                                         
                            </select> 
                            </div>
                            <div>
                            <button type="button" class="btn btn-primary mx-2" onclick="validate_applyForm()">Apply to selected</button>
                            </div>
                        </div>
                        </form>                        
                        
                        <div class="d-flex justify-content-end py-2">                         
                         {!! $paginate !!}
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <script>    
    const delete_row = (id) =>{        

        swal({		  
            title				: 'Are you sure?',
            text				: 'You want to delete this item',
            type				: 'warning',
            showCancelButton	: true,
            confirmButtonColor  : '#3085d6',
            cancelButtonColor	: '#d33',
            confirmButtonText	: 'Yes, delete it!',
            cancelButtonText	: 'No, cancel!',
            confirmButtonClass  : 'btn btn-success',
            cancelButtonClass	: 'btn btn-danger',
            buttonsStyling	: false,
            closeOnConfirm	: false	
        }).then(function () {

            var url = "{{ route('users.destroy','id') }}"
            url = url.replace('id',id);       

            $.ajax({
                type: "delete",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                dataType: "json",
                url: url, 
                success: function(response){  
                    $('#row-'+id).hide()                    
                    setTimeout(()=>{
                        location.href = response.url
                    }, 1000)
                }
            });  
    
	    })	
    
    }

    const validate_applyForm = ()=>{
        let count_ckbox  = document.querySelectorAll('.selected-chk:checked').length;
        let apply_action = document.querySelector('[name="apply_action"]').value;

        if( count_ckbox > 0 && apply_action){   
            swal({		  
                title				: 'Are you sure?',
                text				: 'You want to apply this action',
                type				: 'warning',
                showCancelButton	: true,
                confirmButtonColor  : '#3085d6',
                cancelButtonColor	: '#d33',
                confirmButtonText	: 'Yes, do it!',
                cancelButtonText	: 'No, cancel!',
                confirmButtonClass  : 'btn btn-success',
                cancelButtonClass	: 'btn btn-danger',
                buttonsStyling	    : false,
                closeOnConfirm	    : false	
            }).then(function () { 
                document.getElementById('applyForm').submit() 
            })                
        }        
        return false;
    }    
    </script>
    
@endsection