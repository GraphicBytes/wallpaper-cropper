function mobilemenu(){
  $( '.hamburger' ).toggleClass("is-active");
  // Do something else, like open/close menu
  $( ".hamburger-box" ).toggleClass("active");
  $( ".hamburger-inner" ).toggleClass("active");
  $( "#mobile-menu" ).fadeToggle( "fast", function() {});
  $( ".full-site-container" ).fadeToggle( 100, function() {});
}
