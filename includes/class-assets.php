<?php
namespace MTGApp;

/**
 * Scripts and Styles Class
 */
class Assets {

    function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register' ), 5 );
    }

    /**
     * Register our app scripts and styles
     *
     * @return void
     */
    public function register() {
        $this->register_scripts( $this->get_scripts() );
        $this->register_styles( $this->get_styles() );
    }

    /**
     * Register scripts
     *
     * @param  array $scripts
     *
     * @return void
     */
    private function register_scripts( $scripts ) {
        foreach ( $scripts as $handle => $script ) {
            $deps      = isset( $script['deps'] ) ? $script['deps'] : false;
            $in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
            $version   = isset( $script['version'] ) ? $script['version'] : MAGICCARDS_VERSION;

            wp_register_script( $handle, $script['src'], $deps, $version, $in_footer );
        }
    }

    /**
     * Register styles
     *
     * @param  array $styles
     *
     * @return void
     */
    public function register_styles( $styles ) {
        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, MAGICCARDS_VERSION );
        }
    }

    /**
     * Get all registered scripts
     *
     * @return array
     */
    public function get_scripts() {

        $scripts = [
            'vue' => [
                'src'       => '//cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js',
                'version'   => '2.5.17',
            ],
            'axios' => [
                'src'       => '//unpkg.com/axios/dist/axios.min.js',
                'version'   => '0.18.0',
            ],
            'magiccards-frontend' => [
                'src'       => MAGICCARDS_ASSETS . '/js/app.js',
                'deps'      => [ 'vue', 'axios' ],
                'in_footer' => true
            ]
        ];

        return $scripts;
    }

    /**
     * Get registered styles
     *
     * @return array
     */
    public function get_styles() {

        $styles = [
            'bootstrap' => [
                'src' =>  '//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'
            ],
            'magiccards-frontend' => [
                'src' =>  MAGICCARDS_ASSETS . '/css/style.css'
            ]
        ];

        return $styles;
    }

}
