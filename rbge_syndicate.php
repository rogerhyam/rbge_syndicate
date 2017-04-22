<?php

/*
Plugin Name: RBGE Syndication Plugin
Description: Generates a Javascript code to embed story in another site.
Version: 0.1
Author: Roger Hyam
License: GPL2
*/


if(is_admin()){
    // we are loading the admin panel
    require_once plugin_dir_path( __FILE__ ) . 'classes/RbgeSyndicateAdmin.php';
    add_action('add_meta_boxes', array('RbgeSyndicateAdmin','init') );
    add_action('in_admin_header', array('RbgeSyndicateAdmin', 'help'));
    
    add_action('admin_enqueue_scripts', function(){
        wp_enqueue_script('rbge_syndicate_admin_js', plugins_url('plugin.js', __FILE__));
        wp_enqueue_style( 'rbge_syndicate_admin_css', plugins_url('plugin_style.css', __FILE__));
    });
    
    
}else{
    
    add_action('wp_enqueue_scripts', function(){
        wp_register_style( 'rbge_syndicate_css', plugins_url('style.css', __FILE__));
    });
    
    // we are loading a regular page
    require_once plugin_dir_path( __FILE__ ) . 'classes/RbgeSyndicateFront.php';
    $front = new RbgeSyndicateFront();    
    add_shortcode( 'rbge_post_list', array($front, 'get_tag_content') );
    
}


?>