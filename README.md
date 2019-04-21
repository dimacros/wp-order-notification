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
