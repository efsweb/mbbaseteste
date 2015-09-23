$(document).on('pageshow', 'div', function (event, ui) {
    $('#listcontent').sortable({
    	cancel: '.not-dragg',
    	stop: function(){
    		$('.content').find('.row-cont-ficha').each(function(){
    			nlinha = $(this).attr('data-linha');
    			/*console.log(nlinha);*/
		    });
    	}
    });
});