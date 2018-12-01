$(document).ready(function(){
	$("#Save").click(function() {
		//$("#formulaire").validate();
		//Vérifier qu'il y a au moins un amis de sélectionner si amis il y a
		//$(//trouver selecteur sur le nom ou voir si jquery n'a pas un truc spécial checkbox 
		if($("#Prenom").val() == undefined || $("#Prenom").val().trim() == "")
		{
			alert('Le prénom est obligatoire');
		}
	});
	$("#Nom").focusout(function(){
		if($("#Nom").val() == undefined || $("#Nom").val().trim() == "")
		{
			$("#NomErreur").text('Le nom est obligatoire');
			$("#NomErreur").show();
			$("#Nom").addClass('form-control-success');
			$("#Nom").removeClass('form-control-danger');
		} else {
			$("#NomErreur").text(''); 
			$("#NomErreur").hide();
			$("#Nom").removeClass('form-control-danger');
			$("#Nom").addClass('form-control-success');
		}
	});
	$("#Email").focusout(function(){
		var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		if($("#Email").val() == undefined || $("#Email").val().trim() == "")
		{
			$("#EmailErreur").text('Le mail est obligatoire');
			$("#EmailErreur").show();
		}else if (!testEmail.test($("#Email").val()))
		{
			$("#EmailErreur").text('Le format de l\'adresse mail n\'est pas valide');
			$("#EmailErreur").show();
		} else {
			$("#EmailErreur").text(''); 
			$("#EmailErreur").hide();
		}
	});
	$("#Prenom").focusout(function(){
		if($("#Prenom").val() == undefined || $("#Prenom").val().trim() == "")
		{
			$("#PrenomErreur").text('Le prénom est obligatoire');
			$("#PrenomErreur").show();
		} else {
			$("#PrenomErreur").text(''); 
			$("#PrenomErreur").hide();
		}		
	});
});