@inject('translator', 'App\Providers\TranslationProvider')
<form action="Reservations.save">
    <div class="form-row">
        <div class="form-group col-12 col-md-4">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="people">People</label>
            <input type="number" class="form-control" name="people" required>
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" name="phone" required>
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="date">Date</label>
            <input type="text" id="date" class="form-control" name="date">
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="confirmed">Confirmed</label>
            <label class="switch">
                <input type="checkbox" id="confirmed">
                <span class="slider round"></span>
            </label>
            <input type="text" name="confirmed" hidden>
        </div>
    </div>
    <button type="submit" hidden id="submit"></button>
</form>

<script>

    $('#date').datetimepicker();
    function submitForm()
    {
        $('#submit').click();
    }

    $('#confirmed').on('change', function() {
        if ( $(this).is(':checked') ){
            $('[name="confirmed"]').val(1);
        }
        else
        {
            $('[name="confirmed"]').val(0);
        }
    })
</script>