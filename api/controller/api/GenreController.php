<?php
require PROJECT_ROOT_PATH . "/models/GenreModel.php";
class GenreController extends BaseController
{
    /**
     * "/genre/get" Endpoint - Get genre from id
     */
    public function get_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");

        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new GenreModel();
            $result = $model->get($id);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(ObjectResult::from_error($e));
        }
    }

    /**
     * "/genre/get_subgenres" Endpoint - Get all genres with this genre as its parent
     */
    public function get_subgenres_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");

        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new GenreModel();
            $result = $model->get_subgenres($id);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(DataResult::from_error($e));
        }
    }

    /**
     * "/genre/get_subgenre_tree" Endpoint
     */
    public function get_subgenre_tree_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");

        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new GenreModel();
            $result = $model->get_subgenre_tree($id);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(DataResult::from_error($e));
        }
    }

    /**
     * "/genre/get_top_level_genre_action" Endpoint
     */
    public function get_top_level_genre_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");

        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new GenreModel();
            $result = $model->get_top_level_genre($id);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(ObjectResult::from_error($e));
        }
    }

    /**
     * "/genre/get_ancestors" Endpoint
     */
    public function get_ancestors_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");

        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new GenreModel();
            $result = $model->get_ancestors($id);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(DataResult::from_error($e));
        }
    }

    /**
     * 
     */
    public function get_all_top_level_genres_action() : void 
    {
        try {
            $model = new GenreModel();
            $result = $model->get_all_top_level_genres();
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(DataResult::from_error($e));
        }
    }
    
    /**
     * "/genre/get_list" Endpoint - Get list of all genres
     */
    public function get_list_action() : void
    {
        try {
            $model = new GenreModel();
            $result = $model->get_all();
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(DataResult::from_error($e));
        }
    }

    /**
     * "/genre/save" Endpoint - Save primary genre
     */
    public function save_action() : void 
    {
        $this->require_request_method("GET");

        $params = $this->get_query_string_params();

        try {
            $model = new GenreModel();
            $result = $model->save($params);
            $this->output_ok($result);
        } catch (Error $e) {
            $this->output_error_500(Result::from_error($e));
        }
    }
}