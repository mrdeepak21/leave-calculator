<?php
/**
 * @version: 1.0
 * @package: leave-calculator
 * 
 * Plugin name: FMLA Calculator by Heigh10
 * Plugin URI: #
 * Author: Heigh10
 * Author URI: https://heigh10.com/
 * Description: A Simple JavaScript & JQuery Based lightweight plugin to calculate Family and Medical Leave Act Hours. To use this plugin in front-end use shortcode <code>[fmla_calculator]</code>. Please note that this plugin will only work <b>/fmla-calculator/</b> page.
 */

if(!defined('ABSPATH')) exit('Silence is golden');

 if($_SERVER['REQUEST_URI']=='/devplugin/leave-calculator/'){
//  if($_SERVER['REQUEST_URI']=='/leave-calculator/'){
add_action('wp_head',function(){
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="'.plugin_dir_url( __FILE__ ).'/front-end/assets/style.css">
    ';
});

add_action('wp_footer', function(){
    echo '
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="'.plugin_dir_url( __FILE__ ).'/front-end/assets/script.js"></script>';
});
}

add_shortcode('fmla_calculator', function(){
require_once('front-end/layout.php');
});

