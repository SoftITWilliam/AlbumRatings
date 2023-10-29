<?php
require PROJECT_ROOT_PATH . "/models/ArtistModel.php";
class ArtistController extends BaseController
{
    /**
     * "/artist/get" Endpoint - Get artist from id
     * (currently only basic info)
     */
    public function get_action() : void 
    {
        $this->require_request_method("GET");
        $this->require_params("id");

        $params = $this->get_query_string_params();
        $id = $params["id"];

        try {
            $model = new ArtistModel();
            $result = $model->get_artist($id);
            $this->send_output(json_encode($result),
                array(CONTENT_TYPE_JSON, HEADER_OK)
            );
        } catch (Error $e) {
            $result = new ObjectResult();
            $result->info = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($result);
        }
    }
    
    /**
     * "/artist/get_list" Endpoint - Get list of all artists
     * (currently only basic info)
     */
    public function get_list_action() : void
    {
        try {
            $model = new ArtistModel();
            $result = $model->get_all_artists();
            $this->send_output(json_encode($result),
                array(CONTENT_TYPE_JSON, HEADER_OK)
            );
        } catch (Error $e) {
            $result = new DataResult();
            $result->info = 'Something went wrong! (' . $e->getMessage() . ')';
            $this->output_error_500($result);
        }
    }

    /**
     * "/artist/save" Endpoint - Save artist
     */
    public function save_action() : void 
    {
        $this->require_request_method("GET");

        $params = $this->get_query_string_params();

        try {
            $model = new ArtistModel();
            $result = $model->save_artist($params);
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