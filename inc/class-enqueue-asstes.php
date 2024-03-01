<?php

class Enqueue_Assets {
    public function __construct() {
        $this->setup_hooks();
    }

    public function setup_hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_font_awesome' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_js' ] );
    }

    public function enqueue_font_awesome() {
        // enqueue font awesome
        wp_enqueue_style( "donot-font-awesome", IDONATE_DIR_URL . "/css/all.min.css", [], false, "all" );
    }

    public function enqueue_js(  ) {
        // enqueue js
        wp_enqueue_script( "font-awesome", IDONATE_DIR_URL . "/js/all.min.js", [], false, true );
    }
}

new Enqueue_Assets();