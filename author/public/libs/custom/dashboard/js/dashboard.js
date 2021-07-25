$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
Dropzone.autoDiscover = false;
$(document).ready(function () {

const prevent = $('#app').hasClass('notVerified');
$('[id=startCampaign]').click(function(e){
  if(prevent == true){
    e.preventDefault();
    $("#modalKYC").modal("show");
  }
});


function descGallery(contentShow, contentHide, btnShow, btnHide)
{
  contentHide.hide();
  contentShow.show();
  btnShow.attr("class", "btn btn-success btn-block btn-sm")
  btnHide.attr("class", "btn btn-secondary btn-block btn-sm")
}

let gallery     = $("#gallery-proyek");
let deskripsi   = $("#desc-proyek");
let btnGallery  = $("#btnGallery"); 
let btnDesc     = $("#btnDesc"); 

gallery.hide();

btnDesc.on("click", function(){
    descGallery(deskripsi, gallery, btnDesc, btnGallery);
});

btnGallery.on("click", function(){
  descGallery(gallery, deskripsi, btnGallery, btnDesc);
});

// Gallery

$('.gallery-image').magnificPopup({
  type: 'image',
  // other options
  gallery:{enabled:true}
});

// End Gallery

// $("a").on('click', function(event) {

//   // Make sure this.hash has a value before overriding default behavior
//   if (this.hash !== "") {
//     // Prevent default anchor click behavior
//     event.preventDefault();

//     // Store hash
//     var hash = this.hash;

//     // Using jQuery's animate() method to add smooth page scroll
//     // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
//     $('html, body').animate({
//       scrollTop: $(hash).offset().top
//     }, 1000, function(){
 
//       // Add hash (#) to URL when done scrolling (default click behavior)
//       window.location.hash = hash;
//     });
//   } // End if
// });

  

  $("#sidebar").mCustomScrollbar({
      theme: "minimal"
  });

  $('#sidebarCollapse').on('click', function () {
      $('#sidebar, #content').toggleClass('active');
      $('.collapse.in').toggleClass('in');
      $('a[aria-expanded=true]').attr('aria-expanded', 'false');
  });

  var currentFile = null;
  $('#UploadKTP').dropzone({
    maxFiles:1,
    init: function()
    {
        this.on("maxfilesexceeded", function(file)
        {
          this.removeAllFiles();
          this.addFile(file);
        });
    }
  });

  

  $(".radioButton").on('click', function(){
    // $("input[type='radio'].custom-control-input").prop('checked',true);
    $(this).find('.custom-control-input').prop('checked', true);
    $(".radioButton").removeClass("active");
    $(this).addClass("active");
  });

/* -------------------------------------------------------------------------- */
/*                                Setup Profile                               */
/* -------------------------------------------------------------------------- */

function sform(param){
  let max = parseInt($('#'+param).attr('maxlength'));

  if($('#'+param).val().length >= max-1){
    $('#'+param).next().focus();
  }
}

function rform(param){
  let min = 0;

  if($('#'+param).val().length == min){
    $('#'+param).prev().focus();
  }
}

$('#bio_nomor_code').keypress(function(){
  sform($(this).attr('id'));
});

$('#bio_nomor').keyup(function(e){
  if(e.keyCode == 46 || e.keyCode==8){
    rform($(this).attr('id'));
  }
});


/* -------------------------------------------------------------------------- */
/*                          for Profile Step Section                          */
/* -------------------------------------------------------------------------- */

  let profileApp = $("#profile-app");

  let dateBirth = $('#bio_tanggal_lahir');

  dateBirth.bootstrapMaterialDatePicker({
    time : false,
    lang : 'id',
    format: 'DD/MM/YYYY'
  });

  $("select[required]").bind("invalid change", function(event){
    if(event.type== 'invalid'){
      this.setCustomValidity("Data tidak boleh kosong");
    }
    else{
      this.setCustomValidity('');
    }
  });

  $("#dokumen_ktp, #dokumen_npwp, #dokumen_selfie, #uploadSelfie, #uploadKTP, #uploadNPWP").bind("invalid input", function(event){
    if(event.type== 'invalid'){
      this.setCustomValidity("Data tidak boleh kosong.");
    }
    else{
      this.setCustomValidity('');
    }
  });

  $("#rekening_nomor, #rekening_pemilik").bind("invalid input", function(event){
    if(event.type== 'invalid'){
      this.setCustomValidity("Data tidak boleh kosong.");
    }
    else{
      this.setCustomValidity('');
    }
  });


/* ---------------------------- end Step Section ---------------------------- */


/* -------------------------------------------------------------------------- */
/*                                Form Section                                */
/* -------------------------------------------------------------------------- */

$("#bio_email").bind("invalid input", function(event){
  if(event.type== 'invalid'){
    this.setCustomValidity("Format Email tidak Valid");
  }
  else{
    this.setCustomValidity('');
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

let prefixLocation = "/lokasi";
let provinsi  = $("#bio_address_prov");
let kota      = $("#bio_address_kab");
let kecamatan = $("#bio_address_kec");
let kelurahan = $("#bio_address_desa");
let postal    = $("#bio_address_zip");

// postal.attr("disabled", true);


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

});

/* -------------------------------------------------------------------------- */
/*                                Akad Section                                */
/* -------------------------------------------------------------------------- */

const btnAkad = $('#persetujuan');

btnAkad.on('click', function(){
  $("#modalAkad").modal('show');
});
/* --------------------------- End of Akad Section -------------------------- */
 
function provinceOption(){
  let option = "";
  let DOM = provinsi;
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
     if(provinsi.attr('data-form') != 'reuse'){
       DOM.updateOption(option);
     }
    }
  });
}

provinsi.change(function(){
  if ((event && event.type != 'change') || typeof event == 'undefined') {
    return;
  }
  let option = "";
  let DOM = kota;
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

kota.change(function(){
  if ((event && event.type != 'change') || typeof event == 'undefined') {
    return;
  }
  let option = "";
  let DOM = kecamatan;
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

kecamatan.change(function(){
  if ((event && event.type != 'change') || typeof event == 'undefined') {
    return;
  }
  let option = "";
  let DOM = kelurahan;
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


kelurahan.change(function(){
  if ((event && event.type != 'change') || typeof event == 'undefined') {
    return;
  }

  let option = "";
  let DOM = postal;
  let valDom = $(this).val();

  $(document).ajaxOption("Kelurahan", "postal", valDom).done(function(response){
     DOM.val(response.PostalCode);
  });

});

provinceOption();

// for Upload
/*  ==========================================
    SHOW UPLOADED IMAGE
* ========================================== */

function readURL(input) {
  if (input.files && input.files[0]) {
    const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
    const file = input.files[0];
    const fileType = file['type'];
    if(!validImageTypes.includes(fileType)){
      $(input).parent().parent().find('#imageResult')
                .attr('src', "");
      $(input).parent().find('#upload-label').text("Gagal Unggah");
      $(input).parent().parent().find('.image-area').css("--content", "'Tipe data tidak sesuai'");
      $(input).parent().parent().find('.image-area').css("--color", "#dc3545");
    }
    else{
      var reader = new FileReader();
      reader.onload = function(e) {
        $(input).parent().parent().find('#imageResult')
                .attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
      $(input).parent().parent().find('.image-area').css("--content", "''");
      $(input).parent().find('#upload-label').text(input.files[0].name);
    }

  }
}

$("#uploadKTP, #uploadNPWP, #uploadSelfie").on('change', function() {
  readURL(this);
});

/* -------------------------------- End Form -------------------------------- */

/* -------------------------------------------------------------------------- */
/*                                  Akad Sign                                 */
/* -------------------------------------------------------------------------- */

let cd = 0;
function f_a(se,ca, text, btn, cb){
  se.on('click', function(e){
      cd = 1;
      if(!ca.is(":checked") && changed == 1){
        location.reload();
      }
      const k = $('#persetujuan');
      const m = $('#modalAkad');
      const c = $('.c-text');
      const d = $('.d_a');
      c.empty();
      d.empty();
      c.append(text);
      d.append(btn);
      btn.show();
      k.remove();
      m.modal('hide');
      btn.on('click', function(){
        m.modal('show');
      });
      cb(ca, se, text);
    });
}

function cb(i, b){
  i.attr('disabled', "");
  i.attr('id', "");
  b.text('Tutup Kembali');
  b.attr('class', 'btn btn-block btn-secondary');
  b.attr('id', '');
}

const ca    = $("#ca");
const se    = $("#se");
const call  = $(".call");
const con   = $('#confirm_akad');
const a_a   = $('#a_after');
const tcon  = con.text();
const save  = se.clone();
const s_a   = a_a.clone();
se.remove();
con.remove();
a_a.remove();
ca.on('change', function(e){
  if($(this).is(':checked')){
    call.prepend(save.text('Setuju'));
    const newCall = $('#se');
    f_a(newCall,ca,tcon, s_a, cb);
  }
  else{
    if(cd == 1){
      location.reload();
    }
    $("#se").remove();
  }
});

/* ------------------------------------   ----------------------------------- */
  

/* -------------------------------------------------------------------------- */
/*                            Simulation Class Akad                           */
/* -------------------------------------------------------------------------- */



/* ------------------------------- Class Akad ------------------------------- */

});

