jQuery(document).ready(function($) {
  var depois = new Date();
  depois.setDate(depois.getDate() + 30);

  $('#countdown').countdown(depois, function(event) {
    $(this).html(event.strftime(''+
        '<div class="row">'+
        '<div class="countdown-columns"><span>%D</span><strong>Dias</strong></div>'+
        '<div class="countdown-columns"><span>%H</span><strong>Horas</strong></div>'+
        '<div class="countdown-columns"><span>%M</span><strong>Minutos</strong></div>'+
        '<div class="countdown-columns"><span>%S</span><strong>Segundos</strong></div>'+
        '</div>'));
  });
  $('#slides').superslides({
    play:'9000',
    animation:'fade',
    animation_easing: 'swing',
    animation_speed: 900,
    hashchange: false,
    pagination: false
  });
});

$('[data-toggle=popover]').popover({
    trigger:'hover'
});
