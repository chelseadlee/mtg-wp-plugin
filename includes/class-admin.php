<?php
namespace MTGApp;

/**
 * Admin Pages Handler
 */
class Admin {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
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

        add_menu_page( __( 'Magic Cards', 'magiccards' ), __( 'Magic Cards', 'magiccards' ), $capability, $slug, array( $this, 'plugin_page' ), 'dashicons-text' );

        if ( current_user_can( $capability ) ) {
            $submenu[ $slug ][0] = array( __( 'App', 'magiccards' ), $capability, 'admin.php?page=' . $slug . '#/' );
        }
    }

    /**
     * Render our admin page
     *
     * @return void
     */
    public function plugin_page() {
        echo '<div class="wrap"><h1>Magic Cards</h1><br /><div id="magiccards-admin-app">Use [magic-cards] shortcode anywhere to render magic cards app.</div></div>';
    }
}
