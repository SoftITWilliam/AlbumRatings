<?php
require PROJECT_ROOT_PATH . "/models/CountryModel.php";
class CountryController extends BaseController
{
    /**
     * "/country/get" Endpoint - Get country from id
     */
    public function get_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");

        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new CountryModel();
            $result = $model->get($id);
            $this->send_output(json_encode($result), [CONTENT_TYPE_JSON, HEADER_OK]);
        } catch (Error $e) {
            $result = new ObjectResult();
            $result->info = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($result);
        }
    }
    
    /**
     * "/country/get_list" Endpoint - Get list of all countries
     */
    public function get_list_action() : void
    {
        $result = new DataResult();
        try {
            $model = new CountryModel();
            $result = $model->get_all();
            $this->send_output(json_encode($result), [CONTENT_TYPE_JSON, HEADER_OK]);
        } catch (Error $e) {
            $result->info = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($result);
        }
    }

    /**
     * "/country/save" Endpoint - Save country
     */
    public function save_action() : void 
    {
        $this->require_request_method("GET");

        $params = $this->get_query_string_params();

        try {
            $model = new CountryModel();
            $result = $model->save($params);
            $this->send_output(json_encode($result),
                array(CONTENT_TYPE_JSON, HEADER_OK)
            );
        } catch (Error $e) {
            $result = new Result();
            $result->info = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($result);
        }
    }
}