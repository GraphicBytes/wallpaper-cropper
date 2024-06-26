function moveScroller() {
    var anchor = $("#menu_anchor");
    var menu = $('nav');
    var logo = $('#logo');
    var burger = $('#burger');

    var move = function() {
        var st = $(window).scrollTop();
        var ot = anchor.offset().top;
          if(st > ot) {
            $( menu ).addClass( "stick" );
            $( logo ).addClass( "shrink" );
            $( burger ).addClass( "shrink" );
          } else {
          if(st <= ot) {
            $( menu ).removeClass( "stick" );
            $( logo ).removeClass( "shrink" );
            $( burger ).removeClass( "shrink" );
          }
        }
    };
    $(window).scroll(move);
    move();
}

  $(function() {
    moveScroller();
  });
