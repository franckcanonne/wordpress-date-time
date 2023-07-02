jQuery(document).ready(function($) {
    $.ajax({
        url: ajax_date_time_object.ajax_url,
        type: 'POST',
        data: {
            action: 'get_date_time',
            nonce: ajax_date_time_object.nonce
        },
        success: function(response) {
            $('#date-time-container').text(response);
        }
    });
});
