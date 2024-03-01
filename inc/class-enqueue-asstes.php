<?php

class Enqueue_Assets {
    public function __construct() {
        $this->setup_hooks();
    }

    public function setup_hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_font_awesome' ] );
    }

    public function enqueue_font_awesome() {
        // enqueue font awesome
        wp_enqueue_style( "donot-font-awesome", IDONATE_DIR_URL . "/css/font-awesome.min.css", [], false, "all" );
    }
}

new Enqueue_Assets();