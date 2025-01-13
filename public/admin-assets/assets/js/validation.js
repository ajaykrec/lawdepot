function validateEmail(Text){
	var regexp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if(Text.match(regexp)){	
		return true;	
	}
	else{
		return false;
	}
}
function validateMobile(Text){
	var regexp = /^([0-9]{10})+$/;
	if(Text.match(regexp)){	
		return true;	
	}
	else{
		return false;
	}
}
function validateURL(Text){	
	var regexp = /\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i;
	if(Text.match(regexp)){	
		return true;	
	}
	else{
		return false;
	}
}
function validateDOB(Text){	
	var regexp = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
	if(Text.match(regexp)){	
		return true;	
	}
	else{
		return false;
	}
}
function validatePassword(Text){
	var regexp = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,}$/;
	if(Text.match(regexp)){	
		return true;	
	}
	else{
		return false;
	}
}
function passwordHint(){	
	var html = '';
	html += '<div class="text-left">';
	html += '<strong>Password Hint : Password should contain</strong><br />';
	html += '-  at least one lower case<br />';
	html += '-  at least one upper case<br />';
	html += '-  at least one numeric digit<br />';
	html += '-  at least one special character<br />';
	html += '- and minimum 6 characters in length<br />';
	html += '</div>';		
	swal("Password Hint", html, "info");
}