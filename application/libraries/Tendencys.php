<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tendencys
{
    private $CI;
    private $api_authorization;
    private $api_endpoint;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->helper('form');
        $this->api_endpoint = URL_BACKEND;
        $this->api_authorization = TOKEN;
    }

    public function get_products()
    {
        $url = $this->api_endpoint . "/products";
        $response = $this->curl($url, 'GET');
        return json_decode($response['body'], true);
    }

    public function get_product($id)
    {
        $url = $this->api_endpoint . "/products/" . $id;
        $response = $this->curl($url, 'GET');
        return json_decode($response['body'], true);
    }

    public function curl($url, $method = 'GET', $data = [])
    {
        $ch = curl_init();

        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->api_authorization
            )
        );

        //print_r($curl_options); return;        

        if (strtolower($method) == 'post') {
            $curl_options[CURLOPT_POST] = 1;
            $curl_options[CURLOPT_POSTFIELDS] = json_encode($data);
        } else {
            $curl_options[CURLOPT_CUSTOMREQUEST] = $method;
        }
        $curl_string = $this->buildCurlString($url, $curl_options);
        curl_setopt_array($ch, $curl_options);
        $result = array(
            'body' => curl_exec($ch),
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        );
        return $result;
    }

    private function buildCurlString($url, $curl_options)
    {
        $curl_string = "curl -X " . ($curl_options[CURLOPT_CUSTOMREQUEST] ?? 'POST');
        $curl_string .= " '" . $url . "'";

        if (isset($curl_options[CURLOPT_HTTPHEADER])) {
            foreach ($curl_options[CURLOPT_HTTPHEADER] as $header) {
                $curl_string .= " -H '" . $header . "'";
            }
        }

        if (isset($curl_options[CURLOPT_POSTFIELDS])) {
            $curl_string .= " -d '" . $curl_options[CURLOPT_POSTFIELDS] . "'";
        }

        return $curl_string;
    }

    function curl_envia($url, $method = 'GET', $data = [])
    {
        $url_api = "https://api-test.envia.com/";
        $url = $url_api . $url;

        try {
            $curl_options = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method
            );

            if (strtolower($method) == 'post') {
                // $curl_options[CURLOPT_POST] = 1;
                $curl_options[CURLOPT_POSTFIELDS] = json_encode($data);
            } else {
                $curl_options[CURLOPT_CUSTOMREQUEST] = 'GET';
            }

            $curl_options[CURLOPT_HTTPHEADER] = array(
                'Content-Type: application/json',
                'Authorization: ' . "Bearer " . TOKEN_ENVIA
            );

            $curl = curl_init();
            curl_setopt_array($curl, $curl_options);

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response);
        } catch (\Throwable $th) {
            //throw $th;
            echo $th;
        }
    }
}
