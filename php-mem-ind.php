<?php
/*
Plugin Name: PHP memory indicator
Plugin URI: http://terra-byte.org/wordpress/php-mem-ind
Description: Shows PHP memory consuption in footer. Based on WP-Overview (Lite)
Version: 0.1
Author: Matt
Author URI: http://terra-byte.org
License: GPLv2 or later
*/
if(!function_exists('add_action')){header('Status 403 Forbidden');header('HTTP/1.0 403 Forbidden');header('HTTP/1.1 403 Forbidden');exit();}?><?php
function wpo_footer_log(){echo"\n<!--Plugin WP Overview (lite) 2011.0101.1111 Active-->\n";}add_action('wp_head','wpo_footer_log');add_action('wp_footer','wpo_footer_log')?><?php
if(is_admin()){class wp_overview_lite{var$memory=false;function wpo(){return$this->__construct();}function __construct(){add_action('init',array(&$this,'wpo_limit'));add_filter('admin_footer_text',array(&$this,'wpo_footer'));$this->memory=array();}function wpo_limit(){$this->memory['wpo-limit']=(int)ini_get('memory_limit');}function wpo_load(){$this->memory['wpo-load']=function_exists('memory_get_usage')?round(memory_get_usage()/1024/1024,2):0;}function wpo_consumption(){$this->memory['wpo-consumption']=round($this->memory['wpo-load']/$this->memory['wpo-limit']*100,0);}function wpo_output(){$this->wpo_load();$this->wpo_consumption();$this->memory['wpo-load']=empty($this->memory['wpo-load'])?__('0'):$this->memory['wpo-load'].__('M')?>
<?php
}function wpo_footer($content){$this->wpo_load();$content.=' | Load '.$this->memory['wpo-load'].' of '.$this->memory['wpo-limit'].'M';return$content;}}add_action('plugins_loaded',create_function('','$memory=new wp_overview_lite();'));}?>