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

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="row my-3">
                            <div class="col-lg-10 col-md-12 col-12">
                            <form id="filterForm" name="filterForm" method="get" action="{{ route('country.index') }}"> 
                            <div class="row">

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $name ?? '' }}" placeholder="Name">                                
                                </div>  
                                </div>  

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="code" name="code" value="{{ $code ?? '' }}" placeholder="Code">                                
                                </div>  
                                </div> 

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <select class="form-select" id="language_id" name="language_id">
                                    <option value="">Language</option>
                                    @foreach($languages as $val)
                                    <option value="{{ $val['language_id'] }}" {{ ($language_id==$val['language_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option>
                                    @endforeach 
                                </select>                             
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
                            @if(has_permision(['country'=>'RW']))
                            <div class="col-lg-2 col-md-12 col-12">
                                <div class="text-end">
                                <a href="{{ route('country.create') }}" class="btn btn-secondary">+ Add New</a>
                                </div>
                            </div>    
                            @endif                     
                        </div>                       
                        
                        <form id="applyForm" name="applyForm" method="post" action="{{ route('country.index') }}" >  
                        @csrf
                        <div class="table-responsive">                          
                        <table class="table table-hover table-striped">                            
                            <thead>                                                         
                                <tr class="table-dark">
                                    <th style="width:5%;"><input class="form-check-input checkall" type="checkbox"></th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Status</th>   
                                    <th>Default</th> 
                                    <th>Language</th>
                                    <th class="text-end px-3">Action</th>
                                </tr>                                         
                            </thead>                            
                            <tbody>
                                @if($results)
                                    @foreach($results as $val)
                                    <tr id="row-{{ $val['country_id'] }}">
                                        <td>
                                            @if($val['default'] != 1)
                                            <input class="form-check-input selected-chk" type="checkbox" name="id[]" value="{{ $val['country_id'] }}">
                                            @endif
                                        </td>
                                        <td>
                                        @if($val['image'])  
                                            <img src="{{ url('/storage/uploads/country/'.$val['image']) }}" class="img-thumb" height="25">  
                                        @else
                                            <img src="{{ url('/admin_assets/assets/img/no-photos.png') }}" class="img-thumb" height="25">
                                        @endif      
                                        </td>
                                        <td>{{ $val['name'] }}</td>   
                                        <td>{{ $val['code'] }}</td>                                     
                                        <td>
                                            @if($val['status'] == '1')                                                
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">In-Active</span>                                                
                                            @endif
                                        </td>
                                        <td>
                                            @if($val['default'] == '1')                                                
                                                <span class="badge rounded-pill bg-success">Yes</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">No</span>                                                
                                            @endif
                                        </td>
                                        <td>{{ $val['language']['name'] ?? '' }}</td>           
                                        <td class="text-end">
                                            @if(has_permision(['country'=>'RW']))
                                            <a href="{{ route('country.edit',$val['country_id']) }}" class="btn btn-md" title="Edit"><i class="bi bi-pencil-square text-success"></i></a>

                                                @if($val['default'] != 1)
                                                <button type="button" class="btn btn-md delete"                                             
                                                onclick="delete_row({{ $val['country_id'] }})"         
                                                title="Delete"><i class="bi bi-trash text-danger"></i></button>
                                                @endif
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
                        @if(has_permision(['country'=>'RW']))
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
                        @endif
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

            var url = "{{ route('country.destroy','id') }}"
            url = url.replace('id',id);       

            $.ajax({
                type: "delete",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                dataType: "json",
                url: url, 
                success: function(response){  
                    $('#row-'+id).hide() 
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