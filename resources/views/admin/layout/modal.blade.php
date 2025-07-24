<div class="modal" id="normal_modal" data-bs-backdrop="static"> 
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content" style=display:flex;justify-content:center; margin: 0 auto">
			<div class="text-center p-5"><img src="{!! url('admin-assets/assets/ajax-loader/loader.gif') !!}" /></div>
		</div>
	</div>
</div>

<div class="modal" id="large_modal" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content" style=display:flex;justify-content:center; margin: 0 auto">
			<div class="text-center p-5"><img src="{!! url('admin-assets/assets/ajax-loader/loader.gif') !!}" /></div>
		</div>
	</div>
</div>

<div class="modal fade" id="msgModal" style="z-index: 5055">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">      
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<div class="modal" id="largeMsgModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">  
    <div class="modal-content">      
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<script>
$('#normal_modal').on('show.bs.modal', function(e) {
  $(this).find('.modal-content').load(e.relatedTarget.href);
});
$('#large_modal').on('show.bs.modal', function(e) {
  $(this).find('.modal-content').load(e.relatedTarget.href);
});
</script>