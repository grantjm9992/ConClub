@inject('translator', 'App\Providers\TranslationProvider')
<form action="Reservations.save">
    <div class="form-row">
        <input type="text" name="id" hidden value="{{ $reservation->id }}">
        <div class="form-group col-12 col-md-4">
            <label for="name">Name</label>
            <input type="text" class="form-control" value="{{ $reservation->name }}" name="name" required>
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="people">People</label>
            <input type="number" class="form-control" value="{{ $reservation->people }}" name="people" required>
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="email">Email</label>
            <input type="email" class="form-control" value="{{ $reservation->email }}" name="email" required>
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" value="{{ $reservation->phone }}" name="phone" required>
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="date">Date</label>
            <input type="text" id="date" class="form-control" value="{{ $reservation->date }}" name="date">
        </div>
        <div class="form-group col-12 col-md-4">
            <label for="confirmed">Confirmed</label>
            <label class="switch">
                <input type="checkbox" id="confirmed">
                <span class="slider round"></span>
            </label>
            <input type="text" value="{{ $reservation->confirmed }}" name="confirmed" hidden>
        </div>
    </div>
    <button type="submit" hidden id="submit"></button>
</form>

<script>

    $('#date').datetimepicker({
        step: 15,
        minDate: new Date(),
        vale: '{{ $reservation->date }}'
    });
    function submitForm()
    {
        $('#submit').click();
    }

    var conf = '{{ $reservation->confirmed }}';
    if ( conf == '1' )
    {
        $('#confirmed').click();
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
    
    function deleteReservation()
    {
        $.ajax({
            type: "POST",
            url: "Reservations.delete",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                id: '{{ $reservation->id }}'
            },
            success: function(data)
            {
                window.location = "Reservations.admin";
            }
        })
    }

    function sendMail(i)
    {
        $.ajax({
            type: "POST",
            url: "Reservations.sendMail",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                id: '{{ $reservation->id }}',
                response: i
            },
            success: function(data)
            {
                if ( data == "OK" )
                {
                    swal("Success", "Email sent successfully", "success");
                }
            }
        })
    }
</script>