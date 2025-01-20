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
                            <form id="filterForm" name="filterForm" method="get" action="{{ route('document.index') }}"> 
                            <div class="row">

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="Name" name="name" value="{{ $name ?? '' }}" placeholder="Name">                                
                                </div>  
                                </div>  

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ $slug ?? '' }}" placeholder="Slug">                                
                                </div>  
                                </div> 

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <select class="form-select" 
                                id="country_id" 
                                name="country_id" 
                                onchange=get_get_categories(this.value)>                                    
                                    @foreach($countries as $val)
                                    <option value="{{ $val['country_id'] }}" {{ ($country_id==$val['country_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option>
                                    @endforeach 
                                </select>                             
                                </div>  
                                </div>   
                                
                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <select class="form-select" id="category_id" name="category_id"> 
                                    <option value="">Category</option>                                   
                                    @foreach($categories as $val)
                                    <option value="{{ $val['category_id'] }}" {{ ($category_id==$val['category_id']) ? 'selected' : '' }}>{{ $val['name'] }}</option>
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
                            @if(has_permision(['document'=>'RW']))
                            <div class="col-lg-2 col-md-12 col-12">
                                <div class="text-end">
                                <a href="{{ route('document.create') }}" class="btn btn-secondary">+ Add new document</a>
                                </div>
                            </div>   
                            @endif                      
                        </div>                       
                        
                        <form id="applyForm" name="applyForm" method="post" action="{{ route('document.index') }}" >  
                        @csrf
                        <div class="table-responsive">                          
                        <table class="table table-hover table-striped">                            
                            <thead>                                                         
                                <tr class="table-dark">
                                    <th style="width:5%;"><input class="form-check-input checkall" type="checkbox"></th>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Country</th>
                                    <th>Category</th>
                                    <th>Status</th>                                    
                                    <th class="text-end px-5">Action</th>
                                </tr>                                         
                            </thead>                            
                            <tbody>
                                @if($results)
                                    @foreach($results as $val)
                                    <tr id="row-{{ $val['document_id'] }}">
                                        <td>
                                            @if( count($val['steps']) < 1)
                                            <input class="form-check-input selected-chk" type="checkbox" name="id[]" value="{{ $val['document_id'] }}">
                                            @endif
                                        </td>
                                        <td>{{ $start_count }}</td>
                                        <td>
                                        @if($val['image'])  
                                            <img src="{{ url('/storage/uploads/document/'.$val['image']) }}" class="img-thumb" height="50">  
                                        @else
                                            <img src="{{ url('/admin-assets/assets/img/no-photos.png') }}" class="img-thumb" height="50">
                                        @endif                  
                                        </td>   
                                        <td>{{ $val['name'] }}</td>   
                                        <td>{{ $val['slug'] }}</td>    
                                        <td>{{ $val['country']['name'] ?? '' }}</td>   
                                        <td>{{ $val['category']['name'] ?? '' }}</td>                                                  
                                        <td>
                                            @if($val['status'] == '1')                                                
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">In-Active</span>                                                
                                            @endif
                                        </td>
                                        <td class="text-end">   

                                            @if(has_permision(['document'=>'RW'])) 

                                            <a href="{{ route('document.steps.index',$val['document_id']) }}" class="btn btn-md" title="Steps">Steps ({{ count($val['steps']) }})</a>

                                            <a href="{{ route('document.edit',$val['document_id']) }}" class="btn btn-md" title="Edit"><i class="bi bi-pencil-square text-success"></i></a>

                                            @if( count($val['steps']) < 1)
                                            <button type="button" class="btn btn-md delete"                                           
                                            onclick="delete_row({{ $val['document_id'] }})"                
                                            title="Delete"><i class="bi bi-trash text-danger"></i></button>
                                            @endif

                                            @endif
                                        </td>
                                    </tr> 
                                    @php $start_count++; @endphp
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="9">No record found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>                        
                        </div>
                        @if(has_permision(['document'=>'RW']))
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

            var url = "{{ route('document.destroy','id') }}"
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
    
    const get_get_categories = (country_id) =>{ 

        var url = "{{ route('doc.categories','country_id') }}"
        url = url.replace('country_id',country_id); 

        $.ajax({
            type: "get",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            dataType: "json",
            url: url, 
            success: function(response){  
                let options = '<option value="">Category</option>';
                if(response){
                    response.map((val,i)=>{                    
                        options += '<option value="'+val.category_id+'">'+val.name+'</option>';
                    })
                    console.log(options)
                }
                $('#category_id').html(options)                 
                
            }
        });  
    }
    
    </script>
    
@endsection