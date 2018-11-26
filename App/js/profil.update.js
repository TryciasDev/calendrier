$(document).ready(function(){
	$("#Save").hide();
	$("#staticPseudo").click(function() {
	  $("#staticPseudo").removeClass="form-control-plaintext";
	  $('#staticPseudo').prop('readonly', false);
	  $('#staticPseudo').prop('reduired', true);
	  $("#Save").show();
	});
	$("#Nom").click(function() {
	  $("#Nom").removeClass="form-control-plaintext";
	  $('#Nom').prop('readonly', false);
	  $('#Nom').prop('reduired', true);
	  $("#Save").show();
	});
	$("#Prenom").click(function() {
	  $("#Prenom").removeClass="form-control-plaintext";
	  $('#Prenom').prop('readonly', false);
	  $('#Prenom').prop('reduired', true);
	  $("#Save").show();
	});
	$("#conditions").click(function() {
	  $("#conditions").removeClass="form-control-plaintext";
	  $('#conditions').prop('readonly', false);
	  $("#Save").show();
	});
	$("#Email").click(function() {
	  $("#Email").removeClass="form-control-plaintext";
	  $('#Email').prop('readonly', false);
	  $('#Email').prop('reduired', true);
	  $("#Save").show();
	});
});