<?php
require PROJECT_ROOT_PATH . "/models/PrimaryGenreModel.php";
class PrimaryGenreController extends BaseController
{
    /**
     * "/primary_genre/get" Endpoint - Get primary genre from id
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
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(ObjectResult::from_error($e));
        }
    }
    
    /**
     * "/primary_genre/get_list" Endpoint - Get list of all primary genres
     */
    public function get_list_action() : void
    {
        try {
            $model = new PrimaryGenreModel();
            $result = $model->get_all();
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(DataResult::from_error($e));
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
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(Result::from_error($e));
        }
    }

    /**
     * "/primary_genre/get_subgenres" Endpoint - Get all subgenres of primary genre
     */
    public function get_subgenres_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");
        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new PrimaryGenreModel();
            $result = $model->get_subgenres($id);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(DataResult::from_error($e));
        }
    }
}