$(document).ready(function () {
  $(window).on('scroll load', function () {
    let scroll = $(window).scrollTop();
    if (scroll > 0)
      $('body').addClass('scrolled');
    else
      $('body').removeClass('scrolled');
  });

  $('#terms').click(function () {
    //check if checkbox is checked
    if ($(this).is(':checked')) {
      $('#addToCart').removeAttr('disabled'); //enable input
    } else {
      $('#addToCart').attr('disabled', true); //disable input
    }
  });

  if ($('#payment_method_check').is(':checked')) {
    $('#check-form').show();
  }
  if ($('#payment_method_paypal').is(':checked')) {
    $('#paypal-form').show();
  }
  if ($('#payment_method_zelle').is(':checked')) {
    $('#zelle-form').show();
  }
  if ($('#payment_method_cash').is(':checked')) {
    $('#cash-form').show();
  } 

  $('#payment_method_check').click(function () {
    if ($(this).is(':checked')) {
      $('#check-form').show();
    } else {
      $('#check-form').hide(); 
    }
    $('#paypal-form').hide(); 
    $('#zelle-form').hide();
    $('#cash-form').hide(); 
  });
  $('#payment_method_paypal').click(function () {
    if ($(this).is(':checked')) {
      $('#paypal-form').show();
    } else {
      $('#paypal-form').hide();
    }
    $('#check-form').hide(); 
    $('#zelle-form').hide();
    $('#cash-form').hide(); 
  });
  $('#payment_method_zelle').click(function () {
    if ($(this).is(':checked')) {
      $('#zelle-form').show();
    } else {
      $('#zelle-form').hide();
    }
    $('#paypal-form').hide(); 
    $('#check-form').hide();
    $('#cash-form').hide(); 
  });
  $('#payment_method_cash').click(function () {
    if ($(this).is(':checked')) {
      $('#cash-form').show();
    } else {
      $('#cash-form').hide(); 
    }
    $('#paypal-form').hide(); 
    $('#check-form').hide();
    $('#zelle-form').hide(); 
  });
/*
  $("#prevBtn").hide();
  $("#getOfferBtn").hide();
  $(".phone-details:first").show();
  $("#nextBtn").click(function () {
    var next_step = $(".phone-details:visible").next(".phone-details");
    var id = $(next_step).attr("id");
    if(id == 'get-offer' ){
      $('.step-navigation').hide();
    }
    if(id == 'accessories' ){
      $('#getOfferBtn').show();
      $('#nextBtn').hide();
    }
    if (next_step.length != 0) {
      $(".phone-details").hide();
      next_step.show();
    }
    $("#prevBtn").show();
    $("#step-dada").show();
  });

  $("#getOfferBtn").click(function () {
    var next_step = $(".phone-details:visible").next(".phone-details");
    var id = $(next_step).attr("id");
    if (next_step.length != 0) {
      $(".phone-details").hide();
      next_step.show();
    }
    if(id == 'get-offer' ){
      $('.step-navigation').hide();
    }
  });

  $("#prevBtn").click(function () {
    var prev_step = $(".phone-details:visible").prev(".phone-details");
    var id = $(prev_step).attr("id");
    if (prev_step.length != 0) {
      $(".phone-details").hide();
      prev_step.show();
    }
    if(id == 'network' ){
      $("#prevBtn").hide();
      $("#step-dada").hide();
    }
  });*/
});