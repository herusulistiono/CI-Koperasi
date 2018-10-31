$(function() {
	var extra = 0;
    var $input = $('#rp1, #rp2, #rp3');
    $input.on("keyup", function(event) {
      // When user select text in the document, also abort.
      var selection = window.getSelection().toString();
      if (selection !== '') {
        return;
      }
      // When the arrow keys are pressed, abort.
      if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
        if (event.keyCode == 38) {
          extra = 1000;
        } else if (event.keyCode == 40) {
          extra = -1000;
        } else {
          return;
        }
      }
      var $this = $(this);
      // Get the value.
      var input = $this.val();
      var input = input.replace(/[\D\s\._\-]+/g, "");
      input = input ? parseInt(input, 10) : 0;
      input += extra;
      extra = 0;
      $this.val(function() {
        return (input === 0) ? "" : input.toLocaleString("en-US");
      });
    });
	$('[data-toggle="tooltip"]').tooltip();
	//$('#datepicker').inputmask('dd-mm-yyyy',{'placeholder':'dd-mm-yyyy'});
  $('#datepicker').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    orientation: "bottom auto",
    todayBtn: true,
    todayHighlight: true,
  });
});
/*function rupiah(angka){
	var rupiah = '';
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) 
  	if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}*/
//TO RUPIAH
function rupiah(angka){
  var rev = parseInt(angka, 10).toString().split('').reverse().join('');
  var rp  = '';
  for(var i = 0; i < rev.length; i++){
    rp  += rev[i];
    if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
      rp += ',';
    }
  }
  return rp.split('').reverse().join('');
}
function blockNonNumbers(obj, e, allowDecimal, allowNegative)
{
  var key;
  var isCtrl = false;
  var keychar;
  var reg; 
  if(window.event) {
    key = e.keyCode;
    isCtrl = window.event.ctrlKey
  }
  else if(e.which) {
    key = e.which;
    isCtrl = e.ctrlKey;
  }
  if (isNaN(key)) return true;
  keychar = String.fromCharCode(key);
  // check for backspace or delete, or if Ctrl was pressed
  if (key == 8 || isCtrl)
  {
    return true;
  }
  reg = /\d/;
  var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
  var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
  
  return isFirstN || isFirstD || reg.test(keychar);
}