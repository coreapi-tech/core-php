# README

This is a PHP code that uses the CoreapiTools library to interact with the Coreapi API service. The Coreapi service provides various functionalities related to user identification, authentication, and validation.
## Installation
1. Clone the repository
2. Install the dependencies by running composer install
3. Include the CoreapiTools class in your PHP code using require_once 'vendor/autoload.php';

## Usage

### Authentication
First, you need to obtain an API token from the Coreapi service. This token is required for every request made to the API. You can obtain the token from the Coreapi website by registering and subscribing to the service.

After obtaining the token, you can create an instance of the CoreapiTools class by passing the token as a parameter.


```$token = 'affkqjjnfnafnjj';```
```$coreapi = new Coreapi\CoreapiTools($token);```

### User Geo-location

You can use the `get_user_geo($ip)` method to obtain the geographical location of a user based on their IP address.

```$ip = 'ip';```
```$geoUser = $coreapi->get_user_geo($ip);```

The `$ip` parameter is the IP address of the user you want to get the location for. The $geoUser variable will contain an array of data related to the user's location.

### Email Verification
You can use the `get_email_info('email')` method to verify if an email address is valid and retrieve additional information about it.

```$emailInfo = $coreapi->get_email_info('email');```

The email parameter is the email address you want to verify. The $emailInfo variable will contain an array of data related to the email, including its validity status.

### Phone Verification

You can use the `get_phone_info('phone')` method to verify if a phone number is valid and retrieve additional information about it.

```$phoneInfo = $coreapi->get_phone_info('phone');```
The phone parameter is the phone number you want to verify. The $phoneInfo variable will contain an array of data related to the phone number, including its validity status.

### SMS Authentication

You can use the send_sms_auth('phone', 'code', 'en') method to send an SMS authentication code to a phone number.

```$smsAuth = $coreapi->send_sms_auth('phone', 'code', 'en');```

The phone parameter is the phone number you want to send the authentication code to, the code parameter is the authentication code you want to send, and the en parameter is the language code for the message.

The $smsAuth variable will contain a response object with information about the status of the SMS authentication request.

## Conclusion
This PHP code demonstrates how to use the CoreapiTools library to interact with the Coreapi service. By following the steps outlined in this README, you should be able to use the Coreapi service to verify user identities, authenticate users, and perform other related tasks.