<?php

if (!function_exists('active_nav')) {

    function active_nav($subject, $active_text = 'active') {
        $CI = &get_instance();
        if($CI->uri->segment(1) === $subject && !$CI->uri->segment(2)){
           return $active_text;
        }
    }

}


if (!function_exists('active_nav2')) {

    function active_nav2($segment_number1, $subject1, $segment_number2, $subject2, $active_text = 'active') {
        $CI = &get_instance();
        if($CI->uri->segment($segment_number1) === $subject1 && $CI->uri->segment($segment_number2) === $subject2){
           return $active_text;
        }
        
    }

}