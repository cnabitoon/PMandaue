<?php


if (!function_exists('active_nav_home')) {

    function active_nav_home($active_text = 'active') {
        $CI = &get_instance();
        if(!$CI->uri->segment(1) || $CI->uri->segment(1) === 'home'){
           return $active_text;
        }
        
    }

}

if (!function_exists('active_nav_1')) {

    function active_nav_1($subject, $active_text = 'active') {
        $CI = &get_instance();
        if($CI->uri->segment(1) === $subject && !$CI->uri->segment(2)){
           return $active_text;
        }
    }

}


if (!function_exists('active_nav_2')) {

    function active_nav_2( $subject1, $subject2, $active_text = 'active') {
        $CI = &get_instance();
        if($CI->uri->segment(1) === $subject1 && $CI->uri->segment(2) === $subject2
                && !$CI->uri->segment(3)){
           return $active_text;
        }
        
    }

}