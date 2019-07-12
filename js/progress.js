$(document).ready(function() { 
    //Progress bar
    var isEvent = false;
                  $(window).on('scroll', function(){
                      if ( !isEvent ) {
                        scroll_pos = $(window).scrollTop() + $(window).height();
                        element_pos = $('.progress-wrapper').offset().top;
                        var i = 1;
                        $('.progress').one().each(function() {
                            num = $('.progress-bar.bar-'+i).attr('aria-valuenow');
                                                                if (scroll_pos > element_pos){
                                                                    $('.progress-bar.bar-'+i).one().animate({
                                                                        width: num + '0%'
                                                                    }, 30, function(){});
                                                                    $('.progress-bar.bar-'+i).one().css({
                                                                       width: num + '0%' 
                                                                    });
                                                                };
                                                                i++;
                        });
                        isEvent = true;
                        setTimeout( function() {
                            isEvent = false;
                        }, 1000 );
                    }
                  });
});