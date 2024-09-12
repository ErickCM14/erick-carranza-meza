<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'language']);
        $this->load->library(['tendencys', 'form_validation']);
    }

    public function index()
    {
        $this->data['main_page'] = 'home';
        $products = $this->tendencys->get_products();
        $this->data['products'] = isset($products['error']) && $products['error'] == false && !empty($products['data']) ? $products['data'] : array();
        $this->load->view('template', $this->data);
    }

    public function details($id)
    {
        $this->data['main_page'] = 'details';
        $products = $this->tendencys->get_product($id);
        $this->data['products'] = isset($products['error']) && $products['error'] == false && !empty($products['data']) ? $products['data'] : array();
        $this->load->view('template', $this->data);
    }

    public function quote()
    {
        // Validaciones
        $this->form_validation->set_rules('length', 'Largo', 'trim|required|regex_match[/^\d+(\.\d{1,2})?$/]', array('regex_match' => 'El campo {field} solo acepta dos decimales'));
        $this->form_validation->set_rules('width', 'Ancho', 'trim|required|regex_match[/^\d+(\.\d{1,2})?$/]', array('regex_match' => 'El campo {field} solo acepta dos decimales'));
        $this->form_validation->set_rules('height', 'Altura', 'trim|required|regex_match[/^\d+(\.\d{1,2})?$/]', array('regex_match' => 'El campo {field} solo acepta dos decimales'));
        $this->form_validation->set_rules('postalCode', 'Código Postal', 'trim|required|numeric|min_length[5]|max_length[5]');
        $this->form_validation->set_rules('phone', 'Celular', 'trim|required|min_length[10]|numeric|max_length[10]');
        $this->form_validation->set_rules('product_name', 'Nombre del producto', 'trim|required');
        $this->form_validation->set_rules('name', 'Nombre', 'trim|required|max_length[35]');
        $this->form_validation->set_rules('city', 'Ciudad', 'trim|required|max_length[35]');
        $this->form_validation->set_rules('district', 'Colonia', 'trim|required|max_length[35]');
        $this->form_validation->set_rules('street', 'Calle', 'trim|required|max_length[35]');
        $this->form_validation->set_rules('state', 'Estado', 'trim|required|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('number', 'Número exterior', 'trim|required|min_length[1]|max_length[10]');

        if (!$this->form_validation->run()) {
            $this->response['error'] = true;
            $this->response['message'] = strip_tags(validation_errors());
            print_r(json_encode($this->response));
        } else {
            // Se crea el json estatico
            $data_envia = array();
            $data_envia = [
                'origin' => [
                    'name' => "Usuario prueba",
                    'company' => "company",
                    'email' => "email@yopmail.com",
                    'phone' => 9999999999,
                    'street' => "Av Revolucion",
                    'number' => "117",
                    'district' => "Miguel Aleman",
                    'city' => "Acapulco",
                    'state' => "GR",
                    'country' => "MX",
                    'postalCode' => "39580",
                    'reference' => "reference",
                    'coordinates' => [
                        "latitude" => "",
                        "longitude" => "",
                    ],
                ],
                'destination' => [
                    'name' => $_POST['name'],
                    'company' => "",
                    'email' => "emailcustomer@yopmail.com",
                    'phone' => $_POST['phone'],
                    'street' => $_POST['street'],
                    'number' => "1",
                    'district' => $_POST['district'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'country' => "MX",
                    'postalCode' => $_POST['postalCode'],
                    'reference' => "reference",
                    'coordinates' => [
                        "latitude" => "",
                        "longitude" => "",
                    ],
                ],
            ];
            $data_envia['packages'][0]['content'] = $_POST['product_name'];
            $data_envia['packages'][0]['amount'] = 1;
            $data_envia['packages'][0]['type'] = "box";
            $data_envia['packages'][0]['weight'] = 10;
            $data_envia['packages'][0]['insurance'] = 0;
            $data_envia['packages'][0]['declaredValue'] = 0;
            $data_envia['packages'][0]['weightUnit'] = "KG";
            $data_envia['packages'][0]['lengthUnit'] = "CM";
            $data_envia['packages'][0]['dimensions']['length'] = (float) $_POST['length'];
            $data_envia['packages'][0]['dimensions']['width'] = (float) $_POST['width'];
            $data_envia['packages'][0]['dimensions']['height'] = (float) $_POST['height'];
            $data_envia['shipment']['carrier'] = 'dhl';
            $data_envia['shipment']['type'] = 1;
            $data_envia['shipment']['service'] = 'ground';

            // Consumo el metodo para cotizar
            $data = $this->tendencys->curl_envia('ship/rate/', 'POST', $data_envia);
            if (isset($data->error) && !empty($data->error)) {
                $this->response['error'] = true;
                $this->response['message'] = "No se pudo cotizar con los datos proporcionados";
                $this->response['data'] = $data;
                print_r(json_encode($this->response));
            } else {
                $this->response['error'] = false;
                $this->response['message'] = "El costo por el envío es de $" . number_format($data->data[0]->totalPrice, 2) . ' MXN';
                $this->response['data'] = $data;
                $this->response['data_envia'] = $data_envia;
                print_r(json_encode($this->response));
            }
        }
    }

    public function generate()
    {
        $this->form_validation->set_rules('data_envia', 'Cotizar', 'trim|required', array('required' => 'Primero debe cotizar para obtener el costo del envío'));

        if (!$this->form_validation->run()) {
            $this->response['error'] = true;
            $this->response['message'] = strip_tags(validation_errors());
            print_r(json_encode($this->response));
        } else {

            $data_envia = json_decode($_POST['data_envia'], true);
            $data_envia['settings']['printFormat'] = 'PDF';
            $data_envia['settings']['printSize'] = 'STOCK_4X6';
            $data_envia['settings']['comments'] = '';

            // // Consumo el metodo para generar
            $data = $this->tendencys->curl_envia('ship/generate/', 'POST', $data_envia);
            if (isset($data->error) && !empty($data->error)) {
                $this->response['error'] = true;
                $this->response['message'] = "No se pudo generar el envío con los datos proporcionados";
                $this->response['data'] = $data;
                print_r(json_encode($this->response));
            } else {
                $this->response['error'] = false;
                $this->response['message'] = "Se ha generado su envio correctamente";
                $this->response['data'] = $data;
                $this->response['data_envia'] = $data_envia;
                print_r(json_encode($this->response));
            }
        }
    }
}
