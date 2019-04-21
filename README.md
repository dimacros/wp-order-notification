SMS Notification
=======================
Enviar un SMS con la url del ticket, luego de confirmar el pedido. La url por defecto viene acortado por el acortador Bitly. 

```php
    //Important, in the wp-config.php file you must store the required credentials:
    define('AWS_ACCESS_KEY', ''); 
    define('AWS_SECRET_KEY', '');
    
    define('BITLY_ACCESS_TOKEN', ''); 
    define('BITLY_GROUP_GUID', '');
