<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the generic site menu.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Main">
    <button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false"><span><?php esc_html_e( 'Menu', 'ipress' ); ?></span></button>
    <?php 
        wp_nav_menu( [
            'theme_location'    => 'primary', 
            'container_class'	=> 'primary-navigation'
        ] ); 
    ?>
</nav>
