<?php
/*
 * Plugin Name: Magic Cards
 * Description: Displays Magic Cards on WordPress website
 * Version: 0.1
 * Author: Chelsea Lee
 * Author URI: chelsealee.net
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: magiccards
 */

/**
 * Copyright (c) 2018 Chelsea Lee (email: chelsea.lee@chelsealee.net). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// Don't call the file directly
if ( !defined('ABSPATH' ) ) exit;

/**
 * Magic_Cards class
 *
 * @class Magic_Cards The class that holds the entire Magic Cards plugin
 */

final class Magic_Cards {
    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '0.1.0';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = array();

    /**
     * Constructor for the Magic_Cards class
     *
     * Sets up all the hooks and actions within the plugin
     */
    public function __construct() {
        $this->define_constants();

        register_activation_hook(__FILE__, array( $this, 'activate' ) );
        register_deactivation_hook(__FILE__, array( $this, 'deactivate' ) );

        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
    }

    /**
     * Initializes the Magic_Cards class
     *
     * Checks for an existing Magic_Cards() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Magic_Cards();
        }

        return $instance;
    }

    /**
     * Getter to bypass referencing plugin
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * isset to bypass referencing plugin
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'MAGICCARDS_VERSION', $this->version );
        define( 'MAGICCARDS_FILE', __FILE__ );
        define( 'MAGICCARDS_PATH', dirname(MAGICCARDS_FILE) );
        define( 'MAGICCARDS_INCLUDES', MAGICCARDS_PATH . '/includes' );
        define( 'MAGICCARDS_URL', plugins_url( '', MAGICCARDS_FILE ) );
        define('MAGICCARDS_ASSETS', MAGICCARDS_URL . '/assets' );
    }

    /**
     * Load the plugin after all plugins are loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {
        $installed = get_option( 'magiccards_installed' );

        if ( !$installed ) {
            update_option( 'magiccards_installed', time() );
        }

        update_option( 'magiccards_version', MAGICCARDS_VERSION );
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {

    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {
        require_once MAGICCARDS_INCLUDES . '/class-assets.php';

        if ( $this->is_request( 'admin' ) ) {
            require_once MAGICCARDS_INCLUDES . '/class-admin.php';
        }

        if ( $this->is_request( 'frontend' ) ) {
            require_once MAGICCARDS_INCLUDES . '/class-frontend.php';
        }

        if ( $this->is_request( 'ajax' ) ) {
            // require_once MAGICCARDS_INCLUDES . '/class-ajax.php';
        }

        if ( $this->is_request( 'rest' ) ) {
//            require_once MAGICCARDS_INCLUDES . '/class-rest-api.php';
        }
    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks() {

        add_action( 'init', array( $this, 'init_classes' ) );

        // Localize plugin
//        add_action( 'init', array( $this, 'localization_setup' ) );
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes() {

        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin'] = new MTGApp\Admin();
        }

        if ( $this->is_request( 'frontend' ) ) {
            $this->container['frontend'] = new MTGApp\Frontend();
        }

        if ( $this->is_request( 'ajax' ) ) {
            // $this->container['ajax'] =  new MTGApp\Ajax();
        }

        if ( $this->is_request( 'rest' ) ) {
//            $this->container['rest'] = new MTGApp\REST_API();
        }

        $this->container['assets'] = new MTGApp\Assets();
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
//    public function localization_setup() {
//        load_plugin_textdomain( 'magiccards', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
//    }

    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     *
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();

            case 'ajax' :
                return defined( 'DOING_AJAX' );

            case 'rest' :
                return defined( 'REST_REQUEST' );

            case 'cron' :
                return defined( 'DOING_CRON' );

            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

} // Magic_Cards

$magiccards = Magic_Cards::init();
