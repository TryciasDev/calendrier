$(document).ready(function(){
	$(".hide").hide();
	$('#Save').on('shown.bs.modal', function () {
  $('#confirmationDefi').show('focus')
	});
//prompt un message de confirmation que les conditions de la victime sont réalisés
});
 /*(function() {
  var accessForm = document.getElementsByClassName('addDefi');
  var favDialog = document.getElementById('confirmAddDefi');
 // var outputBox = document.getElementById("output");
for(var i = 0; i < accessForm.length; i++)
{
//   Distribute(slides.item(i));
   accessForm.item(i).addEventListener('click', function() {
   	accessForm[i-1].dataset.jour;
   	alert(accessForm.item(i-1).dataset.jour);
   //	console.log(accessForm.item(i));
   	// var idSelected = accessForm.item(i).id;
   	// document.getElementById('addDefi_'+isSelected).show();
//    favDialog.showModal();
    //output.innerHTML += "<div>" + favDialog.returnValue + " button clicked!</div>";
  });
}
  // “Update details” button opens the <dialog> modally
 
  accessForm.addEventListener('click', function() {
    favDialog.showModal();
    //output.innerHTML += "<div>" + favDialog.returnValue + " button clicked!</div>";
  });
})();*/
(function() {
  var favDialog = document.getElementById('confirmAddDefi');
  <repeat group="{{ @datas }}" key="{{ @jour }}" value="{{ @infos }}">
  var accessFormAdd{{@jour}} = document.getElementById('addDefi{{@jour+1}}');
  //var accessFormUpdate{{@jour}} = document.getElementById('updateDefi{{@jour+1}}');
  accessFormAdd{{@jour}}.addEventListener('click', function() {
    document.getElementById('addDefi_{{ @jour+1 }}').display="block";
  });
  /*
  accessFormUpdate{{@jour}}.addEventListener('click', function() {
    document.getElementById("idEvent_{{ @jour+1 }}").value = accessFormUpdate{{@jour}}.dataset.idEvent;
    document.getElementById('addDefi_{{ @jour+1 }}').show();
  });*/
  </repeat>
})();
