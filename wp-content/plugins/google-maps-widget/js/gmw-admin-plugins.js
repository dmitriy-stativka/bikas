/*
 * Maps Widget for Google Maps
 * (c) Web factory Ltd, 2012 - 2021
 */


jQuery(function($) {
  // ask users to confirm plugin deactivation
  $('#the-list tr[data-slug="google-maps-widget"] span.deactivate a').on('click', function(e) {
    if (confirm(gmw.deactivate_confirmation)) {
      
      return true;
    } else {
      e.preventDefault();
      return false;      
    }
  }); // confirm plugin deactivation
}); // onload
