<?php
/*
Plugin Name: WP Instagram Wall
Plugin URI: http://github.com/cubledesarrollo/wp-instagram-wall
Description: Creates a page with your Instagram photos.
Version: 1.0
Author: Cuble Desarrollo S.L.
Author URI: http://cuble.es
License: GPL2
*/
/*
 Copyright 2013  Cuble Desarrollo S.L.  (email : info@cuble.es)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class WP_API_Instagram
{
    private $access_token = "240976113.4d307df.e0a133edcba44ec885c5c17ce4215b1f";

    private $end_point = "https://api.instagram.com/v1/";

    public function feed()
    {
        require_once plugin_dir_path(__FILE__)."library/Requests.php";
        Requests::register_autoloader();
        /*$request = Requests::get($this->end_point .
                'users/self/feed?access_token='.$this->access_token);*/
        var_dump($this->end_point .
                'users/self/feed?access_token='.$this->access_token);
    }
}

if(!class_exists('WP_Instagram_Wall'))
{
    class WP_Instagram_Wall
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // register actions
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'add_menu'));
            add_action('parse_request', array(&$this, 'wall'));
        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        } // END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            // Do nothing
        } // END public static function deactivate
        
        
        /**
         * Analiza la petición, si el nombre con que se accede se corresponde 
         * con la URL del wall, se carga el template.
         *  
         * @param unknown_type $foo
         */
        public function wall(&$wp)
        {
            if (isset($wp->query_vars['name']) && $wp->query_vars['name'] == 'live')
            {
                include 'templates/wall.php';
                exit();
            }
        }
        
        /**
         * Initialize some custom settings
         */
        public function init_settings()
        {
            // register the settings for this plugin
            register_setting('wp_instagram_wall-group', 'setting_a');
            register_setting('wp_instagram_wall-group', 'setting_b');
        } // END public function init_custom_settings()
        
    } // END class WP_Plugin_Template
} // END if(!class_exists('WP_Plugin_Template'))

if(class_exists('WP_Instagram_Wall'))
{
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('WP_Instagram_Wall', 'activate'));
    register_deactivation_hook(__FILE__, array('WP_Instagram_Wall', 'deactivate'));

    // instantiate the plugin class
    $wp_instagram_wall = new WP_Instagram_Wall();
}



