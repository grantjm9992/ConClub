@inject('translator', 'App\Providers\TranslationProvider')
<div style="position: fixed; top: 0; left: 0; height: 100vh; width: 100vw; background: rgba(0,0,0,0.7); padding: 30px;" id="imgViewer">
  <div style="float: right; font-size: 20px; color: #fff; cursor: pointer; ">
    <i onclick="closeViewer()" class="fas fa-times"></i>
  </div>
  <div style="width: 100%; height: 100%; text-align: center;">
    <img src="{{ $event->image }}" style="max-width: 100%; max-height: 100%;" alt="">
  </div>
<script>
  
	function closeViewer()
	{
		$('#imgViewer').remove();		
	}
</script>
</div>
