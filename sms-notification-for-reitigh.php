<?php
/*
Plugin Name: SMS Notification For ReightConsultura
Description: Plugin creado para la página <a href="https://reitighconsultora.com.ar">https://reitighconsultora.com.ar</a>
Version:     1.0.0
Author:      dimacros
Author URI:  https://dimacros.net/
License: Proprietary
*/

defined('ABSPATH') or die('No script kiddies please!');
define('DEFAULT_COUNTRY_CODE', 'AR');

require __DIR__ . '/vendor/autoload.php';

//Check if WooCommerce is active
if ( in_array('woocommerce/woocommerce.php', get_option('active_plugins')) ) {
    /**
     * Hook belonging to Woocommerce 
     * @link https://docs.woocommerce.com/wc-apidocs/hook-docs.html
     */
    
    add_action('woocommerce_order_status_completed', [
        Dimacros\Listeners\SendTicketNotification::class, 'handle'
    ]);
}

add_action('admin_menu', [
    Dimacros\AdminMenu::class, 'init'
]);

add_action('admin_post_send_ticket_manually', [
    Dimacros\SendTicketManually::class, 'call'
]);