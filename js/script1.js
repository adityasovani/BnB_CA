var filestat = false

function apply() {
    $("#err").html("")
    $("#err1").html("")
    $("#err2").html("")

    if (validate()) {
        $("#btnSb").html("loading...")
        $("#btnSb").attr("disabled", true)
        var response = grecaptcha.getResponse();

        if (!response) {
            $("#err").html("<br>Check recaptcha and try again.")
            valid = false
            return
        }
        
        var fd = new FormData
        fd.append('resume',$("#resume")[0].files[0])
        fd.append('fname',$("#fname").val())
        fd.append('lname',$("#lname").val())
        fd.append('email',$("#email").val())
        fd.append('mobile',$("#mobile").val())
        fd.append('address',$("#address").val())
        fd.append('xii',$("#xii").val())
        fd.append('cpt',$("#cpt").val())
        fd.append('icaireg',$("#icaireg").val())
        fd.append('grp1',$("#grp1").val())
        fd.append('grp2',$("#grp2").val())
        fd.append('dir',$("#dir").val())
        fd.append('recaptcha',response)

        jQuery.ajax({
            url: "submitter.php",
            data: fd,
            type: "POST",
            contentType: false,
            processData: false,
            success:function(data){
                $("#form").html("<div class='jumbotron text-center'> <p class='lead'><i class='fa fa-paper-plane-o'></i><br> <br>Thank You for applying! Your application is under review. We will get back to you with an update shortly.</p> </div>")               
            },
            error:function (){
                $("#form").html("<div class='jumbotron text-center'> <p class='lead'><i class='fa fa-exclamation-triangle '></i><br> <br>Something went wrong. Please refresh this page and try again. If problem persists, check back after some time.</p> </div>")
            }
            });
    }
}

function validate() {
    
    var valid = true

    if (grecaptcha == undefined) {
        $("#err").html("<br>ReCAPTCHA error, please try again")
        valid = false 
		return
	}
    
    if (!$("#fname").val() || !$("#lname").val() || !$("#email").val() || !$("#mobile").val() || !$("#address").val() || !$("#xii").val() || !$("#cpt").val() || !$("#icaireg").val()) {
        $("#err").html("<br>All Fields are Compulsary.")
        valid = false
        return
    }

    if (!filestat) {
        $("#err1").html("<br> Please attach resume")
        valid = false
        return
    }

    if ($("#resume")[0].files[0].size > 2097152) {
        $("#err1").html("<br> Resume must be less than 2MB")
        valid = false
        return 
    }

   if(document.getElementById("groups1").checked == true){
        document.getElementById("groups2").checked = false
        document.getElementById("groups4").checked = false
        if (!$("#grp1").val()) {
            $("#err").html("<br>All Fields are Compulsary.")
            valid = false 
            return
        }
        if ($("#grp1").val() < 200) {
            $("#err2").html("<br>Check your score.")
            valid = false
            return
        }
    }
    else if(document.getElementById("groups2").checked == true){
        document.getElementById("groups1").checked = false
        document.getElementById("groups4").checked = false
        if (!$("#grp2").val()) {
            $("#err").html("<br>All Fields are Compulsary.")
            valid = false
            return
        }
        if ($("#grp2").val() < 150) {
            $("#err2").html("<br>Check your score.")
            valid = false
            return
        }
    }
    else if(document.getElementById("groups3").checked == true){
        document.getElementById("groups1").checked = false
        document.getElementById("groups2").checked = false
        document.getElementById("groups4").checked = false
        if (!$("#grp1").val() || !$("#grp2").val()) {
            $("#err").html("<br>All Fields are Compulsary.")
            valid = false 
            return
        }
    }
    else if(document.getElementById("groups4").checked == true){
        document.getElementById("groups1").checked = false
        document.getElementById("groups2").checked = false
        document.getElementById("groups3").checked = false
        if (!$("#dir").val()) {
            $("#err").html("<br>All Fields are Compulsary.")
            valid = false 
            return
        }
    }
    if ($("#email").val().indexOf("@") <= -1 || $("#email").val().indexOf(".") <= -1 || $("#email").val().indexOf(".") <= $("#email").val().indexOf("@")) {
        $("#err1").html("Check you email syntax.")
        valid = false
        return
    }
    if ($("#mobile").val().length != 10) {
        $("#err1").html("<br>Enter 10 digit mobile. DO NOT use +91 or other symbols")
        valid = false
        return
    }
    if (document.getElementById("icaireg").value.indexOf("NRO") !=0 && document.getElementById("icaireg").value.indexOf("ERO") !=0 && document.getElementById("icaireg").value.indexOf("WRO") !=0 && document.getElementById("icaireg").value.indexOf("SRO") !=0 && document.getElementById("icaireg").value.indexOf("CRO") !=0 ) {
        $("#err1").html("<br>Check your ICAI reg no.")
        valid = false
        return
    }
    if ($("#icaireg").val().length != 10) {
        $("#err1").html("<br>Check your registration number.")
        valid = false
        return
    }
    return valid
}

function fileup() {
    filestat = true
    return filestat
}