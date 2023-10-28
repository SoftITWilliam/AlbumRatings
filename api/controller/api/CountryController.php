<?php
require PROJECT_ROOT_PATH . "/models/CountryModel.php";
class CountryController extends BaseController
{
    /**
     * "/country/get" Endpoint - Get country from id
     */
    public function get_action() : void 
    {
        $req_method = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($req_method) != 'GET') $this->output_error_422("Method not supported");

        $params = $this->get_query_string_params();
        $this->require_params("country_id");

        $id = $params["country_id"];

        try {
            $model = new CountryModel();
            $result = $model->get_country($id);
            $this->send_output(json_encode($result),
                array('Content-Type: application/json', HEADER_OK)
            );
        } catch (Error $e) {
            $error_msg = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($error_msg);
        }
    }
    /**
     * "/country/get_list" Endpoint - Get list of all countries
     */
    public function get_list_action() : void
    {
        try {
            $model = new CountryModel();
            $result = $model->get_all_countries();
            $this->send_output(json_encode($result),
                array('Content-Type: application/json', HEADER_OK)
            );
        } catch (Error $e) {
            $error_msg = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($error_msg);
        }
    }
}