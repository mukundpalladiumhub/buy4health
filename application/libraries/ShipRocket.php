<?php

class ShipRocket{

    public function getToken() {

        $url = "external/auth/login";
        $url = SHIPROCKET_URL . $url;
        $fields_string = "";
        $data = array('email' => SHIPROCKET_EMAIL, 'password' => SHIPROCKET_PASS);

        $fields = array('password' => urlencode($data['password']), 'email' => urlencode($data['email']));

        //url-ify the data for the POST
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POST, count($fields));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['accept: application/json']);

        $result = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($result, true);


        return $response['token'];
    }
    
    public function sendCURL($url, $fields) {
        $url = SHIPROCKET_URL . $url;
        $fields_string = "";
        $orderItem_string = "";

        $fields_string = json_encode($fields);


        $AUTH_TOKEN = $this->getToken();

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $AUTH_TOKEN,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($fields_string))
        );
        $result = curl_exec($curl);
        curl_close($curl);


        return json_decode($result, true);
    }
    
     function createOrder($data_order, $data_orderDetail) {
        
    }


}

?>