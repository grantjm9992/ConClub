@inject('translator', 'App\Providers\TranslationProvider')

    <section class="page-section cta">
      <div class="container">
        <div class="row">
          <div class="col-12 mx-auto">
            <h2 style="color: #fff; font-weight: bold; width: 100%; text-align: center;">Reservations</h2>
              
            <div id="schedule"></div>

<script type="text/javascript">
$(function() {
    var dataManager = new ej.DataManager("Reservations.data");
    $("#schedule").ejSchedule({
        width: "100%",
        height: "600px",
        currentDate: new Date(),
        currentView: ej.Schedule.CurrentView.Agenda,
        appointmentSettings: {
            dataSource: dataManager,
            id: "id",
            subject: "subject",
            startTime: "startTime",
            endTime: "endTime"
        }
    });
});	
</script>
          </div>
        </div>
      </div>
    </section>