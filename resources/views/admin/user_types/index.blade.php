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
                        <form id="filterForm" name="filterForm" method="get" action="{{ route('user-types.index') }}"> 
                        <div class="row">

                            <div class="col-lg-4 col-md-6 col-12">
                            <div class="mb-2">
                            <input type="text" class="form-control" id="user_type" name="user_type" value="{{ $user_type ?? '' }}" placeholder="User type">                                
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
                        <div class="col-lg-2 col-md-12 col-12">
                            <div class="text-end">
                            {{--<a href="/" class="btn btn-secondary">+ Add New</a>--}}
                            </div>
                        </div>                         
                        </div>
                        
                       
                        <div class="table-responsive">                          
                        <table class="table table-hover table-striped">                            
                            <thead>                                                         
                                <tr class="table-dark">                                    
                                    <th>#</th>
                                    <th>User type</th>                                                                   
                                    <th class="text-end px-5">Action</th>
                                </tr>                                         
                            </thead>                            
                            <tbody>
                                @if($results)
                                    @foreach($results as $val)
                                    <tr id="usertype-{{ $val['usertype_id'] }}">                                        
                                        <td>{{ $start_count }}</td>
                                        <td>{{ $val['user_type'] }}</td> 
                                        <td class="text-end">   
                                            @if($start_count > 1)                                         
                                            <a href="{{ route('user-types.edit',$val['usertype_id']) }}" class="btn btn-md" title="Edit"><i class="bi bi-pencil-square text-success"></i></a> 
                                            @endif
                                        </td>
                                    </tr> 
                                    @php $start_count++; @endphp
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="3">No record found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>                        
                        </div>                      
                        
                        
                        <div class="d-flex justify-content-end py-2">                         
                         {!! $paginate !!}
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection