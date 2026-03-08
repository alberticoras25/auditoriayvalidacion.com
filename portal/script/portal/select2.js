$(function() {

  // Default
  $('#basic, #multiple').select2({
    containerCssClass: 'tpx-select2-container',
    dropdownCssClass: 'tpx-select2-drop'
  });

  //Large
  $('#large, #large_multi').select2({
    containerCssClass: 'tpx-select2-container select2-container-lg',
    dropdownCssClass: 'tpx-select2-drop'
  });

  //Small
  $('#small, #small_multi').select2({
    containerCssClass: 'tpx-select2-container select2-container-sm',
    dropdownCssClass: 'tpx-select2-drop select2-drop-sm'
  });

  //Error States
  $('#error_state').select2({
    containerCssClass: 'tpx-select2-container select2-error',
    dropdownCssClass: 'tpx-select2-drop'
  });

  //Success States
  $('#success_state').select2({
    containerCssClass: 'tpx-select2-container select2-success',
    dropdownCssClass: 'tpx-select2-drop'
  });

  //Warning States
  $('#warning_state').select2({
    containerCssClass: 'tpx-select2-container select2-warning select2-container-sm',
    dropdownCssClass: 'tpx-select2-drop'
  });

  $('.grey').select2({
    containerCssClass: 'tpx-select2-container select2-grey select2-container-sm',
    dropdownCssClass: 'tpx-select2-drop select2-drop-sm'
  });

  $('.darkgrey').select2({
    containerCssClass: 'tpx-select2-container select2-darkgrey',
    dropdownCssClass: 'tpx-select2-drop select2-drop-sm'
  });

  $('.lightblue').select2({
    containerCssClass: 'tpx-select2-container select2-lightblue select2-container-sm',
    dropdownCssClass: 'tpx-select2-drop select2-drop-sm'
  });

  $('.blue').select2({
    containerCssClass: 'tpx-select2-container select2-blue select2-container-sm',
    dropdownCssClass: 'tpx-select2-drop select2-drop-sm'
  });

  $('.lime').select2({
    containerCssClass: 'tpx-select2-container select2-lime select2-container-sm',
    dropdownCssClass: 'tpx-select2-drop select2-drop-sm'
  });

  $('.pomelo').select2({
    containerCssClass: 'tpx-select2-container select2-pomelo select2-container-sm',
    dropdownCssClass: 'tpx-select2-drop select2-drop-sm'
  });

  $('.orange').select2({
    containerCssClass: 'tpx-select2-container select2-orange select2-container-sm',
    dropdownCssClass: 'tpx-select2-drop select2-drop-sm'
  });

  $('.bluegreen, #bluegreen2').select2({
    containerCssClass: 'tpx-select2-container select2-bluegreen select2-container-sm',
    dropdownCssClass: 'tpx-select2-drop select2-drop-sm'
  });

  $('.bluedrop').select2({
    containerCssClass: 'tpx-select2-container',
    dropdownCssClass: 'tpx-select2-drop select2-blue select2-drop-sm'
  });

  $('.darkblue').select2({
    containerCssClass: 'tpx-select2-container select2-darkgrey',
    dropdownCssClass: 'tpx-select2-drop select2-blue select2-drop-sm'
  });

});