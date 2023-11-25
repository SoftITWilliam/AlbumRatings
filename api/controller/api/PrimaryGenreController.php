<?php
require PROJECT_ROOT_PATH . "/models/PrimaryGenreModel.php";
class PrimaryGenreController extends BaseController
{
    /**
     * "/primary_genre/get" Endpoint - Get primary genre from id
     * (currently only basic info)
     */
    public function get_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");

        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new PrimaryGenreModel();
            $result = $model->get($id);
            $this->send_output(json_encode($result), [CONTENT_TYPE_JSON, HEADER_OK]);
        } catch (Error $e) {
            $result = new ObjectResult();
            $result->info = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($result);
        }
    }
    
    /**
     * "/primary_genre/get_list" Endpoint - Get list of all primary genres
     * (currently only basic info)
     */
    public function get_list_action() : void
    {
        try {
            $model = new PrimaryGenreModel();
            $result = $model->get_all();
            $this->send_output(json_encode($result), [CONTENT_TYPE_JSON, HEADER_OK]);
        } catch (Error $e) {
            $result = new DataResult();
            $result->info = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($result);
        }
    }

    /**
     * "/primary_genre/save" Endpoint - Save primary genre
     */
    public function save_action() : void 
    {
        $this->require_request_method("GET");

        $params = $this->get_query_string_params();

        try {
            $model = new PrimaryGenreModel();
            $result = $model->save($params);
            $this->send_output(json_encode($result), [CONTENT_TYPE_JSON, HEADER_OK]);
        } catch (Error $e) {
            $result = new Result();
            $result->info = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($result);
        }
    }

    public function get_subgenres_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");
        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new PrimaryGenreModel();
            $result = $model->get_subgenres($id);
            $this->send_output(json_encode($result), [CONTENT_TYPE_JSON, HEADER_OK]);
        } catch (Error $e) {
            $result = new Result();
            $result->info = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($result);
        }
    }
}