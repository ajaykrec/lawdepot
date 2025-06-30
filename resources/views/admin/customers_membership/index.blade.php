@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                <li class="breadcrumb-item active">Membership</li>
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
                            <form id="filterForm" name="filterForm" method="get" action="{{ route('customers.membership.index',$customer_id) }}"> 
                            <div class="row">                                                                 
                                
                                <div class="col-lg-4 col-md-6 col-12">
                                <div class="mb-2">
                                <select class="form-select" id="status" name="status">
                                    <option value="">Status</option>
                                    <option value="0" {{ ($status=='0') ? 'selected' : '' }}>In-Active</option>
                                    <option value="1" {{ ($status=='1') ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ ($status=='2') ? 'selected' : '' }}>Up-Comming</option>
                                    <option value="3" {{ ($status=='3') ? 'selected' : '' }}>To Be Cancelled</option>
                                    <option value="4" {{ ($status=='4') ? 'selected' : '' }}>Cancelled</option>
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
                        
                        <form id="applyForm" name="applyForm" method="post" action="{{ route('customers.membership.index',$customer_id) }}" >  
                        @csrf
                        <div class="table-responsive">                          
                        <table class="table table-hover table-striped">                            
                            <thead>                                                         
                                <tr class="table-dark">
                                    <th style="width:5%;"><input class="form-check-input checkall" type="checkbox"></th>
                                    <th>#</th>
                                    <th>Subscription</th> 
                                    <th class="text-center">Price</th> 
                                    <th class="text-center">Renew Date</th>                                                              
                                    <th class="text-center">Status</th>                                    
                                    <th class="text-end px-5">Action</th>
                                </tr>                                         
                            </thead>                            
                            <tbody>
                                @if($results)
                                    @foreach($results as $val)
                                    <tr id="row-{{ $val['cus_membership_id'] }}">
                                        <td>
                                            <input class="form-check-input selected-chk" type="checkbox" name="id[]" value="{{ $val['cus_membership_id'] }}">
                                        </td>
                                        <td>{{ $start_count }}</td>
                                        <td>{{ $val['membership']['name'] }}</td>  
                                        <td class="text-center">
                                            {{ currency($val['membership']['price'], $val['membership']['currency_code']) }}
                                        </td> 
                                        <td class="text-center">{{ $val['end_date'] }}</td> 
                                        <td class="text-center">
                                            @if($val['status'] == '0')                                                
                                                <span class="badge rounded-pill bg-danger">In-Active</span>
                                            @elseif($val['status'] == '1')                                                
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @elseif($val['status'] == '2')                                                
                                                <span class="badge rounded-pill bg-secondary">Up-Comming</span>
                                            @elseif($val['status'] == '3')                                                
                                                <span class="badge rounded-pill bg-warning">To Be Cancelled</span>  
                                            @elseif($val['status'] == '4')                                                
                                                <span class="badge rounded-pill bg-danger">Cancelled</span>  
                                            @endif
                                        </td>
                                        <td class="text-end px-5">                                           

                                            @if(has_permision(['document'=>'RW']))                                             
                                                
                                            <button type="button" class="btn btn-md delete"                                            
                                            onclick="delete_row({{ $val['cus_membership_id'] }})"                      
                                            title="Delete"><i class="bi bi-trash text-danger"></i>
                                            </button>                                                

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

            var url = "{{ route('membership.destroy','id') }}"
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