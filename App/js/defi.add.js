$(document).ready(function(){
	$(".hide").hide();
	$('#Save').on('shown.bs.modal', function () {
  $('#confirmationDefi').show('focus')
	});
//prompt un message de confirmation que les conditions de la victime sont réalisés
});
(function() {
  var favDialog = document.getElementById('confirmAddDefi');
  <repeat group="{{ @datas }}" key="{{ @jour }}" value="{{ @infos }}">
  var accessFormAdd{{@jour}} = document.getElementById('addDefi{{@jour+1}}');
  //var accessFormUpdate{{@jour}} = document.getElementById('updateDefi{{@jour+1}}');
  accessFormAdd{{@jour}}.addEventListener('click', function() {
    document.getElementById('addDefi_{{ @jour+1 }}').display="block";
  });
  </repeat>
})();
