define(function(require) {
	$(document).on('submit','form',function(){
		var username = $.trim($('input[name=username]').val());
 		var password = $.trim($('input[name=password]').val());
 		if(username == '' || password == '' ){
 			return false;
 		}
		
 	    $.post(url,{username:username,password:password},function(data,status){
 	        if(data.status === 1){
 		        window.location.href = indexUrl;
 	        };
 	    },'json');
 	});
});
