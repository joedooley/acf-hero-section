<?php

namespace DevDesigns\AcfHeroSection;



/**
 * Define constants for plugins version, path, and URL.
 *
 * @since 1.0.0
 *
 * @param string $version
 * @param string $filepath
 */
function defineConstants( string $version, string $filepath ): void {
	if ( ! defined( 'ACF_HERO_SECTION_VERSION' ) ) {
		define( 'ACF_HERO_SECTION_VERSION', $version );
	}

	if ( ! defined( 'ACF_HERO_SECTION_URL' ) ) {
		define( 'ACF_HERO_SECTION_URL', plugin_dir_url( $filepath ) );
	}

	if ( ! defined( 'ACF_HERO_SECTION_PATH' ) ) {
		define( 'ACF_HERO_SECTION_PATH', plugin_dir_path( $filepath ) );
	}
}
