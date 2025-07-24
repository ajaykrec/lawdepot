</main> 
  <footer id="footer" class="footer">
    <div class="copyright" id="copyrights"></div>
    <div class="credits" id="designed_by"></div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  {{-- Vendor JS Files --}}  
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/apexcharts/apexcharts.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/chart.js/chart.umd.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/echarts/echarts.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/quill/quill.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/simple-datatables/simple-datatables.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/tinymce/tinymce.min.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/vendor/php-email-form/validate.js' }}"></script>
  {{-- sweetalert2 File --}}  
  <link rel="stylesheet" href="{{ config('app.admin_asset_url') . '/assets/sweetalert/sweetalert2.min.css' }}"  media="all" />
  <script type="text/javascript" src="{{ config('app.admin_asset_url') . '/assets/sweetalert/sweetalert2.min.js' }}"></script>
  {{-- Template Main JS File --}}   
  <script src="{{ config('app.admin_asset_url') . '/assets/js/main.js' }}"></script>
  <script src="{{ config('app.admin_asset_url') . '/assets/js/validation.js' }}"></script>
  <script>
  $(".checkall").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
  });
  </script>
  @if( session()->has('message') )
  <script>
  $( document ).ready(function() {
    swal("Success!", "{{ session()->get('message') }}", "success") 
  });  
  </script>
  @endif  

  <script>
  $(window).on("load", ()=>{
      $.ajax({
          type:"GET",
          headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          url : "{{ route('common') }}",
          dataType: "json",
          success : function(response) {
              $("#designed_by").html(response.message.settings.designed_by);
              $("#copyrights").html(response.message.settings.copyrights);  
          }
      });
  });
  </script>

@include('admin.layout.modal')  
</body>
</html>