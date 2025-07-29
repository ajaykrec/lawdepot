@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        {{--
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('document.index') }}">Document</a></li>
                @if($step_id)
                <li class="breadcrumb-item"><a href="{{ route('document.steps.index',$document_id) }}">Steps</a></li>
                @else
                <li class="breadcrumb-item"><a href="{{ route('document.options.index',$question_id) }}">...</a></li>
                @endif
                <li class="breadcrumb-item"><a href="{{ $url }}">Questions</a></li>
                <li class="breadcrumb-item active">Options</li>
            </ol>
        </nav>
        --}}
        <nav>
            <ol class="breadcrumb">
                @php 
                $i = 0;                   
                @endphp
                @foreach($breadcrumb as $val)
                    @php                     
                    $i++;
                    @endphp

                    @if( count($breadcrumb) > $i)
                    <li class="breadcrumb-item"><a href="{{ $val['url'] }}">{{ $val['name'] }}</a></li>  
                    @else 
                    <li class="breadcrumb-item active">{{ $val['name'] }}</li>  
                    @endif
                @endforeach            
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
                            <form id="filterForm" name="filterForm" method="get" action="{{ route('document.options.index',$question_id) }}"> 
                            <div class="row">                                

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="title" name="title" value="{{ $title ?? '' }}" placeholder="Title">                                
                                </div>  
                                </div>   

                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <input type="text" class="form-control" id="value" name="value" value="{{ $value ?? '' }}" placeholder="Value">                                
                                </div>  
                                </div>                                  
                                
                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <select class="form-select" id="is_sub_question" name="is_sub_question">
                                    <option value="">is sub question ?</option>
                                    <option value="0" {{ ($is_sub_question=='0') ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ ($is_sub_question=='1') ? 'selected' : '' }}>Yes</option>
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
                                <a href="{{ route('document.options.create',$question_id) }}" class="btn btn-secondary">+ Add new option</a>
                                </div>
                            </div>   
                            @endif                      
                        </div>                       
                        
                        <form id="applyForm" name="applyForm" method="post" action="{{ route('document.options.index',$question_id) }}" >  
                        @csrf
                        <div class="table-responsive">                          
                        <table class="table table-hover table-striped">                            
                            <thead>                                                         
                                <tr class="table-dark">
                                    <th style="width:5%;"><input class="form-check-input checkall" type="checkbox"></th>
                                    <th>#</th>
                                    <th>Image</th>                                     
                                    <th>Title</th>  
                                    <th>Value</th>                                            
                                    <th>is sub question?</th> 
                                    <th class="text-end px-5">Action</th>
                                </tr>                                         
                            </thead>                            
                            <tbody>
                                @if($results)
                                    @foreach($results as $val)
                                    <tr id="row-{{ $val['option_id'] }}">
                                        <td>
                                            @if( count($val['questions']) < 1)
                                            <input class="form-check-input selected-chk" type="checkbox" name="id[]" value="{{ $val['option_id'] }}">
                                            @endif        
                                        </td>
                                        <td>{{ $start_count }}</td>
                                        <td>
                                        @if($val['image'])  
                                            <img src="{{ url('/storage/uploads/document_option/'.$val['image']) }}" class="img-thumb" height="50">  
                                        @else
                                            <img src="{{ url('/admin-assets/assets/img/no-photos.png') }}" class="img-thumb" height="50">
                                        @endif        
                                        </td>                                          
                                        <td>{{ $val['title'] }}</td>  
                                        <td>{{ $val['value'] }}</td>  
                                        <td>
                                            @if($val['is_sub_question'] == '1')                                                
                                                <span class="badge rounded-pill bg-success">Yes</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">No</span>                                                
                                            @endif
                                        </td>
                                        <td class="text-end">                                           

                                            @if(has_permision(['document'=>'RW']))  
                                            
                                            @if($val['is_sub_question'] == 1)
                                            <a href="{{ route('questions.index').'?option_id='.$val['option_id'] }}" class="btn btn-md" title="Questions">
                                                Questions ({{ count($val['questions']) }}) 
                                            </a>
                                            @endif

                                            <a href="{{ route('options.edit',$val['option_id']) }}" class="btn btn-md" title="Edit"><i class="bi bi-pencil-square text-success"></i></a>
                                            
                                                
                                            <button type="button" class="btn btn-md delete"                                            
                                            onclick="delete_row({{ $val['option_id'] }})"                      
                                            title="Delete"><i class="bi bi-trash text-danger"></i></button>                                              


                                            @endif
                                        </td>
                                    </tr> 
                                    @php $start_count++; @endphp
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="7">No record found</td>
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

            var url = "{{ route('options.destroy','id') }}"
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