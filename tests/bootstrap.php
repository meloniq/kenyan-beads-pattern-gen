<?php

if ( ! defined( 'KBPG_TD' ) ) {
	define( 'KBPG_TD', 'kenyan-beads' );
}

// Load the composer autoloader to use WP Mock
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Bootstrap WP_Mock to initialize built-in features
WP_Mock::bootstrap();
