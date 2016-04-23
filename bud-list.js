/**
 * 
 */
$('#close').click(function( e ) {
	$obj2 = this;
	
	$($obj2).closest('table').remove();
	
});

$('#close_req').click(function( e ) {
	$obj2 = this;
	
	$($obj2).closest('form').remove();
	
});

$('.workout_form').submit(function(e) {
	$obj = this;
	$.ajax( {
        url: 'send_workout.php',
        type: 'POST',
        data: new FormData( this ),
        processData: false,
        contentType: false
	 } ).done(function(result){
		 
		 $($obj).closest('form').remove();
		 $('#profile').html(result);
		 
      }); 
      e.preventDefault();
    });