<?php

namespace Dimacros;

class AdminMenu 
{
    public static function init() 
    {
        add_submenu_page(
            'woocommerce',
            'Woocommerce SMS Notification',
            'SMS Notification',
            'administrator',
            'woocommerce-sms-notification',
            function() {
                print self::view('admin/form-send-ticket', [
                    'orders' => get_posts([
                        'post_type' => 'shop_order', 
                        'post_status' => 'wc-completed'
                    ])
                ]);
            }
        );  
    }

    public static function view()
    {
        ob_start();
            extract($data);
            include(VIEW_DIR . '/' . $name . '.php');
            $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}