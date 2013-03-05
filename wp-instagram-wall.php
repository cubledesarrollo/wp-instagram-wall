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

if(!class_exists('WP_Instagram_Wall'))
{
    class WP_Instagram_Wall
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // Register settings
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'add_menu'));
            // Register actions
            add_action('parse_request', array(&$this, 'wall'));
            
            
        }

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        }
        
        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            // Do nothing
        }
        
        
        /**
         * Analiza la petición, si el nombre con que se accede se corresponde 
         * con la URL del wall, se carga el template.
         *  
         * @param WP $wp
         */
        public function wall(&$wp)
        {
            $slug = get_option('slug');
            if (!$slug)
            {
                $slug = 'live';
            }
            if (isset($wp->query_vars['name']) && $wp->query_vars['name'] == $slug)
            {
                include 'templates/wall.php';
                exit();
            }
        }
        
        /**
         * Initialize settings.
         */
        public function admin_init()
        {
            $this->init_settings();
        }
        
        /**
         * Initialize some custom settings
         */
        public function init_settings()
        {
            // register the settings for this plugin
            register_setting('wp_instagram_wall-group', 'title');
            register_setting('wp_instagram_wall-group', 'slug');
            register_setting('wp_instagram_wall-group', 'access_token');
            
        }
        
        /**
         * Add menu page
         */
        public function add_menu()
        {
            add_options_page('Instagram Wall Settings', 'Instagram Wall', 
                    'manage_options', 'wp_instagram_wall', 
                    array(&$this, 'plugin_settings_page'));
        }
        
        /**
         * Menu Callback
         */
        public function plugin_settings_page()
        {
            if(!current_user_can('manage_options'))
            {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }
        
            // Render the settings template
            include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
            
        }
        
        
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

// Add a link to the settings page onto the plugin page
if(isset($wp_instagram_wall))
{
    // Add the settings link to the plugins page
    function plugin_settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=wp_instagram_wall">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
}
