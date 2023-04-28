$(document).ready(function() {
   
    $('select').select2({
        minimumResultsForSearch: Infinity,
        placeholder: function(){
            $(this).data('placeholder');
        }
    });
   
    $('.btn-outline-primary, .btn-outline-danger')
    .on('mouseenter', function(e) {
			var parentOffset = $(this).offset(),
      		relX = e.pageX - parentOffset.left,
      		relY = e.pageY - parentOffset.top;
			$(this).find('span').css({top:relY, left:relX})
    })
    .on('mouseout', function(e) {
			var parentOffset = $(this).offset(),
      		relX = e.pageX - parentOffset.left,
      		relY = e.pageY - parentOffset.top;
    	$(this).find('span').css({top:relY, left:relX})
    });

    // $("#notificationModal").modal('show');

    $('.filter-menu .dropdown-item').on('click', function () {
        $('.filter-menu .dropdown-item').removeClass('active');
        $(this).addClass('active');
    });

    $('.alarmon-btn').on('click', function(e){
        e.preventDefault();
        $('#setPointModal').modal('open');
        return false;
    });

    $('.eye-btn').on('click', function () {
        if ($(this).parent('.password-wrap').hasClass('active')) {
            $(this).parent('.password-wrap').find('.form-control').attr("type", "password");
            $(this).parent('.password-wrap').removeClass('active');
        } else {
            $(this).parent('.password-wrap').find('.form-control').attr("type", "text");
            $(this).parent('.password-wrap').addClass('active');
        }
    })

});