<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Template for displaying the front page hero. Retrieve the theme hero settings, display if available
 *
 * @see     https://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Is the hero area active?
$ip_hero = get_theme_mod( 'ipress_hero', false );
if ( ! $ip_hero ) {	return; }

// Basic details
$ip_hero_title = ipress_get_option( 'hero_title', '' );
$ip_hero_description = ipress_get_option( 'hero_description', '' );

// Button link
$ip_hero_button_link = ipress_get_option( 'hero_button_link', '' );
$ip_hero_button_text = ipress_get_option( 'hero_button_text', __( 'Learn More', 'ipress-standalone' ) );

// Background image
$ip_hero_image = IPR_Hero::HeroImage();
$ip_hero_image = ( false !== $ip_hero_image ) ? $ip_hero_image : sprintf( '<img src="%s" alt="%s" />', esc_url( IPRESS_CHILD_ASSETS_URL . '/images/hero.svg' ), esc_attr( $ip_hero_title ) );

// Image overlay
$ip_hero_overlay = ipress_get_option( 'hero_overlay', false );
?>

<section class="hero hero-banner">

	<div class="hero-content">
		<?php if ( $ip_hero_title ) : ?>
		<h1 class="hero-title"><?php echo esc_html( $ip_hero_title ); ?></h1>
		<?php endif; ?>

		<?php if ( $ip_hero_description ) : ?>
		<p class="hero-description"><?php echo esc_html( $ip_hero_description ); ?></p>
		<?php endif; ?>

		<?php if ( $ip_hero_button_link && $ip_hero_button_text ) : ?>
		<button class="btn-link">
			<a href="<?php echo esc_url( get_permalink( $ip_hero_button_link ) ); ?>"><?php echo esc_html( $ip_hero_button_text ); ?></a>
		</button>
		<?php endif; ?>
	</div>

	<div class="hero-image"><?php echo $ip_hero_image; ?></div>

	<?php if ( $ip_hero_overlay ) : ?>
	<div class="hero-overlay"></div>
	<?php endif; ?>

</section>
