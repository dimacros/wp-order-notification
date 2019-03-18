<?php 

namespace Dimacros\Listeners;

use Aws\Sns\SnsClient;
use Aws\Sns\Exception\SnsException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Exception;

class SendTicketNotification 
{
    public static function handle($order_id, $plainPhoneNumber = NULL)
    {
        /**
         * Class WC_Order
         * @link https://docs.woocommerce.com/wc-apidocs/class-WC_Order.html  
         */
        $order = wc_get_order($order_id);
        $logger = wc_get_logger();
        $logger_context = ['source' => 'sms-notification'];

        $client = new SnsClient([
            'credentials' => [
                'key' => AWS_ACCESS_KEY,
                'secret' => AWS_SECRET_KEY,
            ],
            'region' => 'us-east-1',
            'version' => 'latest'
        ]);
        
        $tickets = get_posts([
            'post_parent'=> $order_id,
            'post_type' => 'tc_tickets_instances'
        ]);
        
        $ticket_id = $tickets[0]->ID;
        $order_key = get_post_meta($order_id, '_tc_paid_date', true);
        $security = wp_create_nonce("download_ticket_{$ticket_id}_{$order_key}");

        $ticket_download_url = home_url('/') . '?' . http_build_query([
            'download_ticket' => $ticket_id, 
            'order_key' => $order_key,
            'download_ticket_nonce' => $security
        ]);
        
        $util = PhoneNumberUtil::getInstance();

        try {
            $message = utf8_encode("Descargue su ticket en: {$ticket_download_url}");
            $phoneNumber = $util->parse(
                $plainPhoneNumber ?? $order->get_billing_phone(), DEFAULT_COUNTRY_CODE
            );

            if( !$util->isValidNumber($phoneNumber) ) {
                throw new Exception('El número no es válido.');
            }

            $result = $client->publish([
                'Message' => $message,
                'PhoneNumber' => $util->format($phoneNumber, PhoneNumberFormat::E164)
            ]);
            
            $logger->info(
                "Pedido #{$order_id} - MessageId: {$result['MessageId']}: $message", $logger_context
            );

            return $result;
        }
        catch(NumberParseException $e) {
            $logger->error("Pedido #{$order_id}:" . $e->getMessage(), $logger_context);
        }
        catch(SnsException $e) {
            $logger->error("Pedido #{$order_id}:" . $e->getMessage(), $logger_context);
        }
        catch(Exception $e) {
            $logger->error("Pedido #{$order_id}:" . $e->getMessage(), $logger_context);
        }
    }
}