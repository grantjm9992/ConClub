@inject('translator', 'App\Providers\TranslationProvider')

    <section class="page-section cta">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-9 mx-auto">
            <h2 style="color: #fff; font-weight: bold; width: 100%; text-align: center;">Upcoming events at the Condado Club</h2>
              {!! $events !!}
          </div>
        </div>
      </div>
    </section>