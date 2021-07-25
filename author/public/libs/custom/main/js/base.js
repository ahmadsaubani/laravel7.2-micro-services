$(document).ready(function(){
  
/* -------------------------------------------------------------------------- */
/*                              Custom Validation                             */
/* -------------------------------------------------------------------------- */
$("#pengguna_username").bind("invalid input", function(event){
  if(event.type== 'invalid'){
    this.setCustomValidity("Format Email tidak Valid");
  }
  else{
    this.setCustomValidity('');
  }
});

// $('.form-control').bind("input", function() {
//   $(this).removeClass('is-invalid');
//   $(this).parent().find(".text-danger").hide();
// });

/* -------------------------- End Custom Validation ------------------------- */



});