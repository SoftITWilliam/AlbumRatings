<?php
class BaseController
{
    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->send_output('', array('HTTP/1.1 404 Not Found'));
    }

    /**
     * Get querystring params.
     */
    protected function get_query_string_params() : array
    {
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }

    /**
     * Throw an error if any of the required params are unset
     */
    protected function require_params(string ...$required_params) : void 
    {
        $query_params = $this->get_query_string_params();
        $missing_params = [];
        foreach($query_params as $key => $value) {
            if(array_search($key, $required_params) === false) {
                array_push($missing_params, $key);
            }
        }
        if (count($missing_params) > 0) {
            throw new Exception('Missing required params: ' . implode(", ", $missing_params));
        }
    }

    /**
     * Send API output.
     * (EXITS SCRIPT)
     */
    protected function send_output($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }

    /**
     * Send API error 500 (WILL EXIT SCRIPT)
     */
    protected function output_error_500(string $info) {
        $r = new DataResult();
        $r->info = $info;
        $this->send_output(json_encode($r), array(CONTENT_TYPE_JSON, HEADER_ERROR_500));
    }
    /**
     * Send API error 422 (WILL EXIT SCRIPT)
     */
    protected function output_error_422(string $info) {
        $r = new DataResult();
        $r->info = $info;
        $this->send_output(json_encode($r), array(CONTENT_TYPE_JSON, HEADER_ERROR_422));
    }
}