@include('admin.layout.header')
@include('admin.layout.sidebar')

<div class="my-main-content"> 
@yield('page-content')
</div>

@include('admin.layout.footer')