@inject('translator', 'App\Providers\TranslationProvider')
<div class="col-12 col-md-9 mx-auto">
    <div class="container-fluid" style="padding: 30px 0 0 0;">
        <div class="row">
            <div class="col-12 col-md-6">
                <a href="Events" style="color: black;">
                    <div style="width: 90%; margin: 10px 5%; text-align: center;">
                        <img src="images/calendar.png" style="height: 64px; width: 64px;" />
                        <h3>Events</h3>
                        <h5>This week: {{ $events->week }}</h5>
                        <h5>This month: {{ $events->month }}</h5>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="Reservations" style="color: black;">
                    <div style="width: 90%; margin: 10px 5%; text-align: center;">
                        <img src="images/dinning-table.png" style="height: 64px; width: 64px;" />
                        <h3>Reservations</h3>
                        <h5>Today: {{ $reservations->today }}</h5>
                        <h5>This week: {{ $reservations->week }}</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<style>
a:hover {
    text-decoration: none;
}
</style>