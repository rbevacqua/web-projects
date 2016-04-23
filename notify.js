/**
 * 
 */
$('.request').submit(function(e) {
			var obj = this;
        	$.ajax( {
                url: 'add_buddy.php',
                type: 'POST',
                data: new FormData( this ),
                processData: false,
                contentType: false
        	 } ).done(function(result){
        		 
        		 $(obj).closest('tr').remove();
        		 $('#message').html(result);
              }); 
              e.preventDefault();
        });

$('.workout').submit(function(e) {
	var obj = this;
	$.ajax( {
        url: 'accept_task.php',
        type: 'POST',
        data: new FormData( this ),
        processData: false,
        contentType: false
	 } ).done(function(result){
		 
		 $(obj).closest('tr').remove();
		 $('#message').html(result);
      }); 
      e.preventDefault();
});

$('.close_task').submit(function(e) {
	var obj = this;
	$.ajax( {
        url: 'remove_task.php',
        type: 'POST',
        data: new FormData( this ),
        processData: false,
        contentType: false
	 } ).done(function(result){
		 
		 $(obj).closest('tr').remove();
		 $('#message').html(result);
      }); 
      e.preventDefault();
});