@extends('admin.layout.main')

@section('page-content')

    <div class="pagetitle">
        <h1>{{ $meta['title'] ?? '' }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active">{{ $meta['title'] ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">               
                <div class="card">
                <div class="card-body mb-3">

                <form id="dataForm" name="dataForm" method="post" action="{{ route('orders.update', $id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf   

                <div class="my-3">
                <label class="form-label">Order Status</label>
                @php
                $order_status = old('order_status', $data['order_status'] ?? '');
                @endphp
                <select class="form-select" name="order_status"> 
                <option value=""></option>   
                <option value="0" {{ ($order_status=='0') ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ ($order_status=='1') ? 'selected' : '' }}>Completed</option>
                <option value="2" {{ ($order_status=='2') ? 'selected' : '' }}>Cancelled</option>
                </select>
                <span class="err" id="error-order_status">
                @error('order_status')
                {{$message}}
                @enderror 
                </span>      
                </div>
                
                <div class="mb-3">  
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                </form>

                </div>
                </div>

            </div>
        </div>
    </section> 
    
@endsection