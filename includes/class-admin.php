<?php
namespace MTGApp;

/**
 * Admin Pages Handler
 */
class Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register our menu page
     *
     * @return void
     */
    public function admin_menu() {
        global $submenu;

        $capability = 'manage_options';
        $slug       = 'magic-cards';

        $hook = add_menu_page( __( 'Magic Cards', 'magiccards' ), __( 'Magic Cards', 'magiccards' ), $capability, $slug, [ $this, 'plugin_page' ], 'dashicons-text' );

        if ( current_user_can( $capability ) ) {
            $submenu[ $slug ][] = array( __( 'App', 'textdomain' ), $capability, 'admin.php?page=' . $slug . '#/' );
        }

//        add_action( 'load-' . $hook, [ $this, 'init_hooks'] );
    }

    /**
     * Initialize our hooks for the admin page
     *
     * @return void
     */
//    public function init_hooks() {
//        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
//    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
//    public function enqueue_scripts() {
//        wp_enqueue_style( 'magiccards-admin' );
//        wp_enqueue_script( 'magiccards-admin' );
//    }

    /**
     * Render our admin page
     *
     * @return void
     */
    public function plugin_page() {
        echo '<div class="wrap"><div id="magiccards-admin-app">Use [magic-cards] shortcode anywhere to render magic cards app.</div></div>';
    }
}
