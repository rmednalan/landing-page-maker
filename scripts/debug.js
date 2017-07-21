/* jQuery(function($){
	//alert("this debug file is called");
	jQuery.ajax({
		url : "http://localhost/jwpb/wp-admin/admin-ajax.php",
		type : 'post',
		data : {
			action : 'upfront_data',
		},
		success : function( response ) {
			console.log(response);
			console.log("no error");
		},
		error:function(x){
			console.log(x);
			console.log(x.responseText);
			console.log("has error");
		}
	});
}) */