/**
 * 
 */
$('.buddy_request').submit(function(e) {
			var obj = this;
        	$.ajax( {
                url: 'request_buddy.php',
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

$('.remove_form').submit(function(e) {
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

