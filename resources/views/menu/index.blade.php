@inject('translator', 'App\Providers\TranslationProvider')
<div class="row">
    <div id="categories" style="margin: 20px auto;" class="col-10">
        {!! $cats !!}
    </div>
</div>

<script>
    function addCategory()
    {
        $.ajax({
            type: "POST",
            url: "Menu.makeSection",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(data)
            {
                $('#categories').append(data);
                var elements = $('.cc-sortable');
                var id = $( elements[elements.length - 1] ).attr('data-id')
                
                $('[divid='+id+']').hide();
                $('[inputid='+id+']').show();
                $('[data-id='+id+']').focus();
            }
        });
    }

    $('body').delegate('[divid]', 'click', function() {
        $(this).hide();
        var val = $(this).attr('divid');
        $('[inputid='+val+']').show();
        $('[data-id='+val+']').focus();
    });
    $('body').delegate('[hideinputid]', 'click', function() {
        showDiv(this);
    });

    $('body').delegate('input[data-id]', 'keydown', function(e) {
        if ( event.which == 13 ) {
            var id = $(this).attr('data-id');
            var input = $('[hideinputid="'+id+'"]');
            showDiv(input[0]);
        }
    });
    function showDiv($this)
    {
        var val = $($this).attr('hideinputid');
        $('[inputid='+val+']').hide();
        $('[divid='+val+']').show();
        var inputs = $('input[data-id="'+val+'"]');
        var name = $(inputs[0]).val();
        $('[divid='+val+']').html(name);
        $.ajax({
            type: "POST",
            url: "Menu.updateCategory",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                id: val,
                name: name
            },
            success: function(data)
            {
                var s = jQuery.parseJSON(data);
                if ( s.success === 1 )
                {                    
                    $.notify( "Name updated successfully", {
                        position: "bottom-left",
                        className: "success"
                    } );
                }
            }
        })
    }
    

    $(document).ready( function() {
        $('#categories').sortable({
            update: function() {
                updateOrder();
            }
        });
    })

    function updateOrder()
    {        
        var elements = $('.cc-sortable');
        var ids = "";
        for ( var i = 0; i < elements.length; i++ ) {
            ids += $(elements[i]).attr('data-id')+"@#";
        }
        $.ajax({
            type: "POST",
            url: "Menu.updateOrder",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                ids: ids,
                type: "C"
            },
            success: function(data)
            {
                var s = jQuery.parseJSON(data);
                if ( s.success === 1 )
                {                    
                    $.notify( "Order updated successfully", {
                        position: "bottom-left",
                        className: "success"
                    } );
                }
            }
        })
    }

    function deleteCategory(id)
    {
        $.ajax({
            type: "POST",
            url: "Menu.deleteCategory",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                id: id
            },
            success: function(data)
            {
                var s = jQuery.parseJSON(data);
                if ( s.success === 1 )
                {
                    $('div[data-id="'+id+'"]').remove();
                    $.notify( "Category deleted successfully", {
                        position: "bottom-left",
                        className: "success"
                    } );
                }
            }
        })
    }
</script>