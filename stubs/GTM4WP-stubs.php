<?php
/**
 * Function executed during wp_head.
 * Outputs the main Google Tag Manager container code and if WooCommerce is active, it removes the
 * purchase data from the data layer if the order ID has been already tracked before and
 * double tracking prevention option is active.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_head/
 *
 * @param boolean $echo If set to true and AMP is currently generating the page content, the HTML is outputed immediately.
 * @return string|void Returns the HTML if the $echo parameter is set to false or when not AMP page generation is running.
 */
function gtm4wp_wp_header_begin( $echo = true ) {}
