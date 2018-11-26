$(document).ready(function(){
	$("#Save").click(function() {
		$("#formulaire").validate();
		var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		if (!testEmail.test($("#Email").val()))
		{
			alert('Le format de l\'adresse mail n\'est pas valide');
		}
	});
});