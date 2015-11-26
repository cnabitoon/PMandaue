<?php

if (!function_exists('active_nav')) {

    function active_nav($segment_number, $subject, $active_text = 'active') {
        $CI = &get_instance();
        if($CI->uri->segment($segment_number) === $subject){
           return $active_text;
        }
    }

}