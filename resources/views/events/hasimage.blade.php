@inject('translator', 'App\Providers\TranslationProvider')
<div class="btn btn-outline-primary" onclick="getUploadSection('imageSection')">
    Change image
</div>
<div class="col-12 text-center">
    <img class="blog-img" data-id="{{ $event->id }}" style="height: 300px;" src="{!! $event->image !!}" alt="">
</div>