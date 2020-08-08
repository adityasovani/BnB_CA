function sendContact() {
    if($("#name").val()) {
        $("#nameErr").html("");
		valid = false;
	}
    if(validate()) {
		$("#feedBtn").html('loading...')
		$("#feedBtn").attr("disabled", true)
		jQuery.ajax({
		url: "test.php",
		data:'name='+$("#name").val()+'&email='+$("#email").val()+'&mobile='+$("#mobile").val()+'&message='+$("#message").val(),
		type: "POST",
		success:function(data){
			$("#form").html("<p class='lead text-center' style='padding-top: 1rem'> <i class='fa fa-paper-plane-o'></i> Thanks !</p>")
		},
		error:function (){}
        });
		$("#nameErr").html("");
		$("#mobErr").html("")
		$("#mailErr").html("");
		$("#message").html("");
    }
}
function validate() {
	var valid = true;	
    
    if(!$("#name").val()) {
        $("#nameErr").html("required");
		valid = false;
	}
	if(!$("#mobile").val()) {
		$("#mobErr").html("required");
		valid = false;
	}
	if(!$("#email").val()) {
		$("#mailErr").html("invalid");
		valid = false;
	}
	if(!$("#message").val()) {
		$("#subErr").html("required");
		valid = false;
	}
	
	return valid;
}