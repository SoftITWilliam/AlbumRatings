<?php
require PROJECT_ROOT_PATH . "/models/CountryModel.php";
class CountryController extends BaseController
{
    /**
    * "/country/get_list" Endpoint - Get list of all countries
    */
    public function get_list_action() : void
    {
        $error_msg = false;

        try {
            $model = new CountryModel();
            $result = $model->get_all_countries();
        } catch (Error $e) {
            $error_msg = 'Something went wrong! (' . $e->getMessage() . ')';
        }

        // send output
        if (!$error_msg) {
            $this->sendOutput(json_encode($result),
                array('Content-Type: application/json', HEADER_OK)
            );
        } else {
            $r = new DataResult();
            $r->info = $error_msg;
            $this->sendOutput(json_encode($r), 
                array('Content-Type: application/json', HEADER_ERROR_500)
            );
        }
    }
}