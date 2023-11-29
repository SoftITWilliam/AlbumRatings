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
            $model = new Country();
            $result = $model->get($id);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(ObjectResult::from_error($e));
        }
    }
    
    /**
     * "/country/get_list" Endpoint - Get list of all countries
     */
    public function get_list_action() : void
    {
        try {
            $model = new Country();
            $result = $model->get_all();
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(DataResult::from_error($e));
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
            $model = new Country();
            $result = $model->save($params);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(Result::from_error($e));
        }
    }

    /**
     * "/country/search" Endpoint - Get countries that match search name
     */
    public function search_action() : void
    {
        $this->require_request_method("GET");
        $this->require_params("value");
        
        $params = $this->get_query_string_params();

        try {
            $model = new Country();
            $result = $model->search($params["value"]);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(DataResult::from_error($e));
        }
    }
}