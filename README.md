SMS Notification
=======================
##AWS SNS Example:
```php
    $service = new SmsService('aws');
    $service->createMessage([
      'MessageStructure' => 'SMS',
      'Message' => 'This a test message',
      // the number you'd like to send the message to
      'PhoneNumber' => '+15558675309',
      'MessageAttributes' => [
           'AWS.SNS.SMS.SenderID' => [
               'DataType' => 'String',
               //Max String Lenght is 11 and must be alpha-numeric
               'StringValue' => 'CompanyName' 
           ],
           'AWS.SNS.SMS.SMSType' => [
               'DataType' => 'String',
               //This could be 'Promotional' or 'Transactional'
               'StringValue' => 'Transactional'
           ]
      ]
    ])->send();

    //Important, in the wp-config file you must store the required credentials:
    define('AWS_ACCESS_KEY', ''); 
    define('AWS_SECRET_KEY', '');
```
##Twilio Example: 
```php
    $service = new SmsService('twilio');
    // the number you'd like to send the message to
    $phoneNumber = '+15558675309';
    $service->createMessage([
        'body' => 'This a test message',
         // A Twilio phone number you purchased at twilio.com/console
        'from' => '+15017250604', 
        //Or instead of "from" you can do this
        'messagingServiceSid' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXX'
    ])->to($phoneNumber)->send();

    //Important, in the wp-config file you must store the required credentials:
    define('TWILIO_ACCOUNT_SID', '');
    define('TWILIO_AUTH_TOKEN', '');
```