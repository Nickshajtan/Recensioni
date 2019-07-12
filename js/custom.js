$(document).ready(function() { 
    //Red line
    $('#sidebar .right-widget-title').after("<hr align='left' class='red__line'>");
    //Context menu
    var count = 1;
    $('p.section-name').each(function(){
        var id = $(this).find('.name').attr('id');
        var name = $(this).find('.name').text();
        $('.menu-block>nav>ul').append('<li><span class="count">'+ count + '</span><a href="#'+id+'">' + name + '</a></li>');
        $(this).find('.number').html(count);
        count++;
    });
    //Links
    	$("#menu").on("click","a", function (event) {
		event.preventDefault();
		var id  = $(this).attr('href'),
			top = $(id).offset().top;
		$('body,html').animate({scrollTop: top}, 1500);
	});
    //Link for product
    $('.sale-wrapper').on('click', function(){
       var href = $(this).find('a.more-link').attr('href');
       window.location.href = href;
    });
});