<?php

namespace Uzumnasiya;

class Uzumnasiya
{
    public static function checkClient($phone)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://tori.paymart.uz/api/v3/uzum/buyer/check-status?callback=' . "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "phone" => $phone
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer 71da0f8b965cedf65569baaf85ba6889'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public static function createApplication($data)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://tori.paymart.uz/api/v3/uzum/buyer/check-status?callback=' . "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer 71da0f8b965cedf65569baaf85ba6889'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }


    public static function calculate($price, $user_id)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://tori.paymart.uz/api/v3/mfo/calculate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "user_id" => $user_id,
                "products" => [
                    [
                        "price" => $price,
                        "amount" => 1,
                        "product_id" => 1
                    ]
                ]
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer 71da0f8b965cedf65569baaf85ba6889'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        try {
            $data = json_decode($response);
            $months = $data->data;
            return $months;
        } catch (Exception $exception) {

        }

    }

    public function orderCheck($order_id, $api_key): bool
    {
        if (!is_numeric($order_id)) {
            return false;
        }
        $ch = curl_init();
        $url = "https://pay.intend.uz/api/v1/external/order/check";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);                //0 for a get request
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['order_id' => $order_id]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'api-key: ' . $api_key,
        ]);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        die(var_dump($response));
        if ($response['success'] === true) {
            return true;
        } else {
            return false;
        }

    }


}