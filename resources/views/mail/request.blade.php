@inject('translator', 'App\Providers\TranslationProvider')

<div style="width: 100%; text-align: center;">
  <div style="margin: 20px auto;">
    <h2>You have a new reservation request</h2>
    <p>
      Who: {!! $name !!} 
    </p>
    <p>
      When: {!! $date !!} at {!! $time !!}
    </p>
    <p>
      For: {!! $people !!}
    </p>
    <p>
      Telephone: {!! $tel !!}
    </p>
    <p>
      <a href="{{ $acceptURL }}" style="color: green;">
      Click here to accept the reservation 
      </a>
    </p>
    <p>
      <a href="{{ $rejectURL }}" style="color: red;">
      Click here to reject the reservation
      </a>
    </p>
  </div>
</div>