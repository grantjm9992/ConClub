@inject('translator', 'App\Providers\TranslationProvider')

    <section class="page-section cta">
      <div class="container">
        <div class="row">
          <div class="col-12 mx-auto">
            <div class="form-row">
                <div class="form-group col-12 col-md-4">
                    <label for="str_query">Query</label>
                    <input type="text" class="form-control" id="str_query">
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="when">When</label>
                    <select name="when" id="when" class="form-control">
                        <option value="fut">Future reservations</option>
                        <option value="pas">Past reservations</option>
                        <option value="all">All reservations</option>
                    </select>
                </div>
                <div class="form-group col-12 col-md-4">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="0">Pending</option>
                        <option value="1">Confirmed</option>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div onclick="filterResults()" class="btn btn-primary">
                    Filter
                </div>
            </div>
          </div>
        </div>
        <div class="row" style="padding: 20px 0;">
            <div id="grid" class="col-12 mx-auto">
                {!! $table !!}
            </div>
        </div>
      </div>
    </section>

    <script>
        function filterResults()
        {
            $.ajax({
                type: "POST",
                url: "Reservations.getListado",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    when: $('#when').val(),
                    str_query: $('#str_query').val(),
                    status: $('#status').val()
                },
                success: function(data)
                {
                    $('#grid').html(data);
                }
            })
        }
    </script>