<?php
/*
Plugin Name: Liste des articles
Plugin URI: https://factotum.bzh/boutique-wordpress/
Description: Plugin WordPress pour afficher les titres de tous les articles du blog.
Version: 1.0
Author: Franck Canonne
Author Email: franck.canonne@gmail.com
Author URI: https://factotum.bzh
License: GPL2
*/

function shortcode_date_time()
{
    ob_start();
?>
    <div id="date-time-container"></div>

    <script>
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
    </script>
<?php

    return ob_get_clean();
}

add_shortcode('date_time', 'shortcode_date_time');


function ajouter_scripts_ajax()
{
    wp_enqueue_script('ajax-date-time-script', plugins_url('ajax-date-time-script.js', __FILE__), array('jquery'), '1.0', true);
    wp_localize_script('ajax-date-time-script', 'ajax_date_time_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-date-time-nonce')
    ));
}

add_action('wp_enqueue_scripts', 'ajouter_scripts_ajax');


function get_date_time()
{
    check_ajax_referer('ajax-date-time-nonce', 'nonce');

    $date_time = date('Y-m-d H:i:s');

    wp_send_json($date_time);
}

add_action('wp_ajax_get_date_time', 'get_date_time');
add_action('wp_ajax_nopriv_get_date_time', 'get_date_time');
