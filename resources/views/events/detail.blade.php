@inject('translator', 'App\Providers\TranslationProvider')
<div class="container-fluid">
	
	@if ( $event->id != "" )
	<div class="row" style="padding: 20px 0;">
		<div class="col-12">
			<div class="buttons">
				<div onclick="publishToFB({{ $event->id }})" class="btn btn-outline-success">
					<i class="fab fa-facebook"></i> Publish to FaceBook
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class="row">
		<div class="col-12">
			<form action="Events.updateEvent" method="POST" enctype="multipart/form-data">
			<input type="text" name="id" value="{{ $event->id }}" hidden>
			@csrf()
			<div class="row" style="border: 2px solid #e1e1e1; border-radius: 4px; padding: 15px;">
				<div class="form-group col-12 col-md-6">
					<label for="str_title">Title</label>
					<input type="text" class="form-control" name="str_title" value="{{ $event->str_title }}">
				</div>
				<div class="form-group col-12 col-md-6">
					<label for="date">Date</label>
					<input type="text" autocomplete="off" class="form-control" name="date" id="date">
				</div>
				<div class="form-group col-12">
					<label for="str_title">Description</label>
					<textarea rows="7" class="form-control" name="str_description">{{ $event->str_description }}</textarea>
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
	$(document).ready(
		function() {
			jQuery.datetimepicker.setLocale('en');
			$('#date').datetimepicker({
				value: "{{ $event->date }}"
			});
		}
	)

	function save()
	{
		$('#submit').click();
	}

	function deleteElement()
	{
		$.ajax({
			type: "POST",
			url: "Events.delete",
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			data: {
				id: '{{ $event->id }}'
			},
			success: function(data)
			{
				window.location = "Events";
			}
		});
	}

	function goBack()
	{
		window.location = "Events";
	}

	function publishToFB()
	{
		$.ajax({
			type: "POST",
			url: "Events.post",
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			data: {
				id: '{{ $event->id }}'
			},
			success: function(data)
			{
				var options = Array();
				var s = jQuery.parseJSON(data);
				if ( s.success === 1 )
				{
					options.iconClass = "success";
					options.title = "Success";
					options.text = "Post to FaceBook was successul";
				}
				else
				{
					options.iconClass = "error";
					options.title = "Error";
					options.text = "Oops. Something went wrong there";
				}
				swal(options);
			}
		})
	}
</script>