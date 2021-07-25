
$(document).ready(function(){

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

/* -------------------------------------------------------------------------- */
/*                              Test Sample Data                              */
/* -------------------------------------------------------------------------- */

function valUpdate(){
  $.ajax({
    type: "POST",
    url: "url",
    data: "data",
    dataType: "dataType",
    success: function (response) {
      
    }
  });
}

/* ------------------------------- Sample Data ------------------------------ */

  let prefixLocation = "/lokasi"


  $.fn.extend({
    updateOption : function(param){
      this.find('option').remove();
      this.append(param);
      this.selectpicker('refresh');
      this.val('').change();
    },
    ajaxOption : function(param, next, id){
      return $.ajax({
        type: "POST",
        url: prefixLocation+"/"+next+"/"+id,
        data: "",
        dataType: "JSON"
      });
    }

    // ajaxPostal : function(param, next, id){
    //   return $.ajax({
    //     type: "POST",
    //     url: prefixLocation+"/"+next+"/"+id,
    //     data: "",
    //     dataType: "JSON"
    //   });
    // }
  });
   
  function provinceOption(){
    let option = "";
    let DOM = $("#Provinsi");
    $.ajax({
      type: "POST",
      url: prefixLocation,
      data: "",
      dataType: "JSON",
      success: function (response) {
        // console.log(option);
       for(let log in response)
       {
         let Code = response[log].Code;
         let Name = response[log].Name;
         option += '<option value='+Code+'>'+Name+'</option>';
       }
       DOM.updateOption(option);
      }
    });
  }

  $("#Provinsi").change(function(){
    if ((event && event.type != 'change') || typeof event == 'undefined') {
      return;
    }
    let option = "";
    let DOM = $("#Kota");
    let valDom = $(this).val();
    $(document).ajaxOption("Provinsi", "kota", valDom).done(function(response){
      for(let log in response)
       {
        //  NameArray.push(response[log].Name);
         let Code = response[log].Code;
         let Name = response[log].Name;
        //  if(!NameArray.includes(Name)){
           option += '<option value='+Code+'>'+Name+'</option>';
          // }
        }
      // console.log(NameArray);
       DOM.updateOption(option);
    });
  });

  $("#Kota").change(function(){
    if ((event && event.type != 'change') || typeof event == 'undefined') {
      return;
    }
    let option = "";
    let DOM = $("#Kecamatan");
    let valDom = $(this).val();
    $(document).ajaxOption("Kota", "kecamatan", valDom).done(function(response){
      for(let log in response)
       {
        //  NameArray.push(response[log].Name);
         let Code = response[log].Code;
         let Name = response[log].Name;
        //  if(!NameArray.includes(Name)){
           option += '<option value='+Code+'>'+Name+'</option>';
          // }
        }
      // console.log(NameArray);
       DOM.updateOption(option);
    });
  });

  $("#Kecamatan").change(function(){
    if ((event && event.type != 'change') || typeof event == 'undefined') {
      return;
    }
    let option = "";
    let DOM = $("#Kelurahan");
    let valDom = $(this).val();
    $(document).ajaxOption("Kecamatan", "kelurahan", valDom).done(function(response){
      for(let log in response)
       {
        //  NameArray.push(response[log].Name);
         let Code = response[log].Code;
         let Name = response[log].Name;
        //  if(!NameArray.includes(Name)){
           option += '<option value='+Code+'>'+Name+'</option>';
          // }
        }
      // console.log(NameArray);
       DOM.updateOption(option);
    });
  });


  $("#Kelurahan").change(function(){
    if ((event && event.type != 'change') || typeof event == 'undefined') {
      return;
    }

    let option = "";
    let DOM = $("#postal");
    let valDom = $(this).val();

    $(document).ajaxOption("Kelurahan", "postal", valDom).done(function(response){
       DOM.val(response.PostalCode);
    });

  });



  provinceOption();


});