<?php 

namespace Coreapi;

class CoreapiTools
{

    private $token;
    private $package_version = '1.0.0';

    /**
     * The function __construct() is a special function that is called when an object is created
     * 
     * @param token The token you received from the user.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * > If the token is empty, return an error message
     * 
     * @return An array with a status and message.
     */
    private function check_token()
    {
        if (empty($this->token)) {
            return array(
                'status' => 'error',
                'message' => 'Token not set'
            );
        }
    }


    /**
     * A function that makes a request to the API.
     * 
     * @param version The version of the API you want to use.
     * @param service The service you want to use.
     * @param method The method you want to call.
     * @param param 
     * 
     * @return An array with a status and message.
     */
    private function api($version = 'v1', $service, $method, $param = array())
    {
        $this->check_token();

        $token = $this->token;

        $baseUrl = "https://coreapi.tech/api/";
        
        $url = $baseUrl . $version . "/" . $service . "/" . $method . "?token=" . $token;

        $param['platform'] = 'php';
        $param['version'] = $this->package_version;

        $url .= "&" . http_build_query($param);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);

        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($httpCode != 200) {

            return array(
                'status' => 'error',
                'message' => 'Request error'
            );
        }

        curl_close($curl);
        
        return json_decode($result, true);
    }

    /**
     * It returns the account information of the user.
     * 
     * @param email The email address of the account you want to get information about.
     * @param password Your account password
     * 
     * @return An array of data.
     */
    public function get_account_info($email, $password)
    {
        $data =  $this->api('v1', 'account', 'info', array(
            'email' => $email,
            'password' => $password
        ));

        return $data;
    }

    /**
     * It returns an array of strings.
     * 
     * @return array of strings.
     */
    private function get_geo_scopes()
    {
        return array(
            'country', 'region', 'city', 'currency', 'location', 'postal', 'call', 'all'
        );
    }

    /**
     * It returns the user's geo information.
     * 
     * @param ip The IP address you want to get information about.
     * @param scope The scope of the data you want to retrieve. You can use any of the following:
     */
    public function get_user_geo($ip, $scope = array('all'))
    {
        $scopes = $this->get_geo_scopes();

        foreach ($scope as $key => $value) {
            if (!in_array($value, $scopes)) {
                unset($scope[$key]);
            }
        }

        if (empty($scope)) {
            $scope = array('all');
        }

        $scope = implode(',', $scope);

        $data =  $this->api('v1', 'geo', 'user', array(
            'ip' => $ip,
            'scope' => $scope
        ));

        return $data;
    }

    /**
     * It checks if the email is valid or not.
     * 
     * @param email The email address to check
     */
    public function get_email_info($email)
    {
        $data =  $this->api('v1', 'email', 'check', array(
            'email' => $email
        ));

        return $data;
    }

    /**
     * It returns an array of languages.
     */
    private function get_sms_languages()
    {
        return array('en', 'ru', 'ua');
    }

    /**
     * A function that is used to authenticate a user using SMS.
     * 
     * @param phone The phone number to send the SMS to.
     * @param code The code you received via SMS
     * @param language The language of the SMS message. Supported languages are: en, ru, ua, kz, tr,
     * es, fr, de, it, pt, pl, nl, sv, no, da, fi, cs, el, hu, ro, sk, sl, b
     */
    public function send_sms_auth($phone, $code, $language){

        if(!isset($code)){

            return array(
                'status' => 'error',
                'message' => 'Code is empty'
            );
        }
        else
        {
            if(strlen($code) > 6){

                return array(
                    'status' => 'error',
                    'message' => 'Code is too long. Max 6 characters'
                );
            }
        }

        if(!isset($language)){

            return array(
                'status' => 'error',
                'message' => 'Language is empty'
            );
        }
        else
        {
            if(!in_array($language, $this->get_sms_languages())){

                return array(
                    'status' => 'error',
                    'message' => 'Supported only these language:'.' '.implode(', ', $this->get_sms_languages())
                );
            }
        }

        $data =  $this->api('v1', 'sms', 'auth', array(
            'phone' => $phone,
            'code' => $code,
            'language' => $language
        ));

        return $data;
    }

    /**
     * It gets the phone info from the API.
     * 
     * @param phone The phone number to check.
     * 
     * @return the data from the API.
     */
    public function get_phone_info($phone)
    {
        if(!isset($phone)){

            return array(
                'status' => 'error',
                'message' => 'Phone is empty'
            );
        }

        $data =  $this->api('v1', 'phone', 'check', array(
            'phone' => $phone
        ));

        return $data;
    }

}


?>