@inject('translator', 'App\Providers\TranslationProvider')
<div class="col-12" style="margin: 0 0 40px 0; padding: 30px; background-color: rgba(255, 255, 255, 0.7); border-radius: 4px;">
  <div class="row" style="padding: 0 10px 10px 10px;">
    {{ $event->date }}
  </div>
  <div class="row">
    <div class="col-12 col-md-6 col-lg-4">
      <img src="{{ $event->main_image }}" style="max-width: 100%;" alt="{{ $event->str_title }}">
    </div>
    <div class="col-12 col-md-6 col-lg-8">
      <h3 class="eventTitle">{{ $event->str_title }}</h3>
      <p class="eventDesc">
        {{ $event->str_description }}
      </p>
    </div>
  </div>
</div>