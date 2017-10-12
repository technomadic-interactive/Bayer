$("#tags").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    submitForm();
});

function submitForm(){
    // Initiate Variables With Form Content
    var formName = $("#formName").val();
    var tag_id = $("#tag_id").val();
    var activado = $('input[name=activado]:checked').val();
 
    $.ajax({
        type: "GET",
        url: "../php/getData.php",
        data: "formName=" + formName + "&tag_id=" + tag_id + "&activado=" + activado,
        success : function(text){
            if ($.trim(text)===$.trim("Registro Insertado!")){
            	$( "#msgSubmit").html("").removeClass("alert alert-success").removeClass("alert alert-danger").hide();
            	formSuccess(text);
            	 }
            else {
            	$( "#msgSubmit").html("").removeClass("alert alert-success").removeClass("alert alert-danger").hide();
            	formError(text);
            	}
            	
        }
    });
}
function formSuccess(text){
    	$( "#msgSubmit").html("").addClass("alert alert-success").append(text).fadeIn();
}
function formError(text){
    	$( "#msgSubmit").html("").addClass("alert alert-danger").append(text).fadeIn();
}