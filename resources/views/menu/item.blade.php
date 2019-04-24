@inject('translator', 'App\Providers\TranslationProvider')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<form action="Menu.saveItem" method="POST" enctype="multipart/form-data">
			<input type="text" name="id" value="{{ $item->id }}" hidden>
			@csrf()
			<div class="row" style="border: 2px solid #e1e1e1; border-radius: 4px; padding: 15px;">
				<div class="form-group col-12 col-md-6">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" value="{{ $item->name }}">
				</div>
				<div class="form-group col-12 col-md-6">
					<label for="price">Price</label>                    
                    <div inputid="{{ $item->id }}" class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-euro-sign"></i></span>
                        </div>
                        <input type="text" class="form-control" name="price" value="{{ $item->price }}">
                    </div>
				</div>
				<div class="form-group col-12">
					<label for="str_title">Description</label>
                    <input type="text" class="form-control" name="description" value="{{ $item->description }}">
				</div>
				<div id="imageSection" style="width: 100%;">
					{!! $image !!}
				</div>
			</div>
			<input type="submit" id="submit" hidden>
			</form>
		</div>
	</div>
</div>

<script>
    function getUploadSection()
    {
        $.ajax({
            type: "POST",
            url: "Menu.makeImageSection",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                id: '{{ $item->id }}'
            },
            success: function(data)
            {
                $('#imageSection').html(data);
            }
        })
    }

    function submitForm()
    {
        $('#submit').click();
    }

    $(document).ready( function() {
        $('.img').on('click', function() {
            
			$.ajax({
				type: "POST",
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				url: "Menu.returnImage",

				data: {
					id: $(this).attr('data-id')
				},
				success: function(data)
				{
					$('#imgViewer').remove();
					$('body').append(data);
				}
			})
        })
    })
</script>