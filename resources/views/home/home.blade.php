@inject('translator', 'App\Providers\TranslationProvider')
<div class="flexslider">
	<ul class="slides">
		<li class="slide" style="background-image: url('img/bg1.jpg');">
			<div class="overlay"></div>
			<div class="slide-desc">
					<h4>The Condado Club</h4>
					<h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</h6>
			</div>
		</li>
		<li class="slide" style="background-image: url('images/cocktail.jpg');">
			<div class="overlay"></div>
			<div class="slide-desc">
					<h4>Lovely Cocktails</h4>
					<h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</h6>
			</div>
		</li>
	</ul>
</div>
<script>

	$(document).ready( function() {
		
	var burgerMenu = function() {

$('.js-colorlib-nav-toggle').on('click', function(event) {
	event.preventDefault();
	var $this = $(this);
	if( $('body').hasClass('menu-show') ) {
		$('body').removeClass('menu-show');
		$('#colorlib-main-nav > .js-colorlib-nav-toggle').removeClass('show');
	} else {
		$('body').addClass('menu-show');
		setTimeout(function(){
			$('#colorlib-main-nav > .js-colorlib-nav-toggle').addClass('show');
		}, 900);
	}
})
};

	})
</script>