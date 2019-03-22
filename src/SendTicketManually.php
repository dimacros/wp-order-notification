<?php

namespace Dimacros;

class SendTicketManually
{
    public static function call() {

        if(!current_user_can('administrator')) return;

        $order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
        $plainPhoneNumber = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $result = Listeners\SendTicketNotification::handle($order_id, $plainPhoneNumber);

        wp_die("Pedido #{$order_id} - MessageId: {$result['MessageId']}");
    }
}