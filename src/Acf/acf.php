<?php

namespace DevDesigns\AcfHeroSection;



/**
 * Render ACF hero section after Genesis header.
 *
 * @since 1.0.0
 */
add_action( 'genesis_after_header', function (): void {
	if ( ! is_page_template( 'template-sales.php' ) ) {
		return;
	}

	$hero = get_field( 'hero' );

	$bgType = $hero['background_type'];

	$heroImageUrl = $hero['image']['url'];
	$heroImageHeight = sprintf( '%spx', $hero['image']['height'] / 2 );

	$heroPadding = $hero['padding'] ? "padding: {$hero['padding']};" : '';
	$heroHeight = $bgType === 'image' ? "min-height: {$heroImageHeight};" : $heroPadding;

	$bg = $bgType === 'image' ? "url('{$heroImageUrl}') center/cover no-repeat" : $hero['background_color'];

	$addOverlay = $hero['add_overlay'];

	$heading = $hero['heading'] ?? '';
	$subheading = $hero['subheading'] ?? '';

	$description = $hero['description'] ?? '';

	$addCta = $hero['add_cta'];

	$buttonLabel = $hero['cta_group']['link']['title'] ?? __( 'Learn More', 'acf-hero-section' );
	$buttonLink = $hero['cta_group']['link']['url'] ?? '';
	$buttonTarget = $hero['cta_group']['link']['target'] ?: '_self';
	$buttonColor = $hero['cta_group']['color'] ?? '';
	$button = sprintf( "<a href='%s' target='%s'>%s</a>",
		esc_url( $buttonLink ),
		esc_attr( $buttonTarget ),
		esc_html( $buttonLabel )
	);

	$headingColor = $hero['heading_color'] ?? '';
	$headingFontSize = $hero['heading_font_size'] ?? '';

	$subheadingColor = $hero['subheading_color'] ?? '';
	$subheadingFontSize = $hero['subheading_font_size'] ?? '';

	$addOverlayBg = $hero['add_background_color_to_overlay'];
	$overlayBg = $hero['overlay_background_color'];
	$overlayOpacity = $hero['overlay_opacity'];
	$overlayBorderRadius = $hero['overlay_border_radius'];

	$overlayAlignment = $hero['overlay_alignment'] ? : 'center';
	$textAlignment = $hero['text_alignment'] ? : 'center';

	$overlayCss = <<<CSS
		.acf-hero .overlay {
			background-color: {$overlayBg};
			border-radius: {$overlayBorderRadius};
			opacity: {$overlayOpacity}
		}
CSS;

	$includeOverlayCss = $addOverlayBg ? $overlayCss : '';

	$inlineCss = <<<CSS
		.acf-hero {
			background: {$bg};
			{$heroHeight}
		}
		
		{$includeOverlayCss}
		
		.acf-hero header h2 {
			color: {$headingColor};
		}
				
		.acf-hero header h3 {
			color: {$subheadingColor};
		}
		
		.acf-hero .button-wrap a {
			background-color: {$buttonColor};
		}
		
		@media screen and (min-width: 60em) {
			.acf-hero .wrap {
			    align-items: {$overlayAlignment};
			    text-align: {$textAlignment};
			}
			
			.acf-hero header h2 {
			    font-size: {$headingFontSize};
			}
						
			.acf-hero header h3 {
			    font-size: {$subheadingFontSize};
			}
		}
CSS;

	wp_enqueue_style( 'acf-hero-section/main.css' );
	wp_add_inline_style( 'acf-hero-section/main.css', $inlineCss );

	if ( $bgType === 'image' ) {
		$js = "jQuery(document).ready(function() { jQuery('.acf-hero').backstretch() });";
		wp_enqueue_script( 'acf-hero-section/backstretch.js' );
		wp_add_inline_script( 'acf-hero-section/backstretch.js', $js );
	} ?>

	<section class="acf-hero">
		<div class="wrap">
			<?php if ( $addOverlay ) : ?>
				<div class="overlay <?php echo $overlayAlignment ?>">
					<header>
						<?php if ( $heading ): ?>
							<h2><?php echo $heading ?></h2>
						<?php endif; ?>
						<?php if ( $subheading ): ?>
							<h3><?php echo $subheading ?></h3>
						<?php endif; ?>
					</header>
					<div class="description">
						<?php if ( $description ): ?>
							<?php echo $description ?>
						<?php endif; ?>
					</div>
					<?php if ( $addCta && $button ): ?>
						<div class="entry-footer">
							<p class="button-wrap">
								<?php echo $button ?>
							</p>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php
}, 1 );


/**
 * Set ACF local JSON save directory.
 *
 * @since  1.0.0
 *
 * @param  string $path ACF local JSON save directory.
 */
add_filter( 'acf/settings/save_json', function ( string $path ): string {
	return ACF_HERO_SECTION_PATH . 'acf-json';
} );


/**
 * Set ACF local JSON load directory.
 *
 * @since  1.0.0
 *
 * @param  array $paths ACF local JSON open directory.
 */
add_filter( 'acf/settings/load_json', function ( array $paths ): array {
	$paths[] = ACF_HERO_SECTION_PATH . 'acf-json';

	return $paths;
} );


/**
 * Adds support for ACF Local JSON Manager.
 *
 * @link   https://github.com/khromov/acf-local-json-manager
 *
 * @since  1.0.0
 *
 * @param  array $folders ACF local JSON open directory.
 */
add_filter( 'aljm_save_json', function ( array $folders ): array {
	$folders['ACF Hero Section'] = ACF_HERO_SECTION_PATH . 'acf-json';

	return $folders;
} );
