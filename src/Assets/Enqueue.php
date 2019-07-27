<?php
/**
 * Enqueue webpack compiled js and css.
 *
 * @package     DevDesigns\AcfHeroSection
 * @author      Developing Designs
 * @since       1.0.0
 */

namespace DevDesigns\AcfHeroSection\Assets;



class Enqueue {
	public static function enqueue (): void {
		self::scripts();
		self::styles();
	}


	private static function styles (): void {
		wp_register_style(
			'acf-hero-section/main.css',
			ACF_HERO_SECTION_URL . 'dist/styles/main.css',
			[],
			ACF_HERO_SECTION_VERSION
		);
	}


	private static function scripts (): void {
		wp_register_script(
			'acf-hero-section/backstretch.js',
			ACF_HERO_SECTION_URL . 'dist/scripts/vendor/jquery.backstretch.min.js',
			[ 'jquery' ],
			'2.1.17',
			true
		);
	}
}
