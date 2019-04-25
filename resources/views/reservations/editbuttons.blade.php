@inject('translator', 'App\Providers\TranslationProvider')
<div class="btn btn-primary" onclick="submitForm()">
    <i class="fas fa-save"></i> Save
</div>
<div class="btn btn-outline-success" onclick="sendMail(1)">
    <i class="fas fa-envelope"></i> Send confirmation email
</div>
<div class="btn btn-outline-warning" onclick="sendMail(0)">
    <i class="fas fa-envelope"></i> Send rejection email
</div>
<div class="btn btn-danger" onclick="deleteReservation()">
    <i class="fas fa-minus-circle"></i> Delete
</div>
<a href="Reservations.admin" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Back
</a>