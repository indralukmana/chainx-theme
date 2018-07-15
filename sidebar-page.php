<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Chainx
 */

if ( ! is_active_sidebar( 'page-1' ) ) {
	return;
}
?>

<aside id="page-widget-area" class="widget-area page-widgets">
	<?php dynamic_sidebar( 'page-1' ); ?>
</aside><!-- #secondary -->
