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
    
    #region Request validation
    
    /**
     * Output an error if any of the required params are unset
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
            $this->output_error_500('Missing required params: ' . implode(", ", $missing_params));
        }
    }

    /**
     * Output an error if request method is not supported
     */
    protected function require_request_method(string $supported_method) 
    {
        $req_method = strtoupper($_SERVER["REQUEST_METHOD"]);
        if ($req_method != strtoupper($supported_method)) {
            $this->output_error_422("Method not supported");
        }
    }

    #endregion
    #region Output

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

    private function output_error(Result|string $info, array $http_headers) {
        if($info instanceof Result) {
            $result = $info;
        } else {
            $result = new Result();
            $result->info = $info;
        }
        $this->send_output(json_encode($result), $http_headers);
    }

    /**
     * Send API error 500 (WILL EXIT SCRIPT)
     */
    protected function output_error_500(Result|string $info) 
    {
        $headers = array(CONTENT_TYPE_JSON, HEADER_ERROR_500);
        $this->output_error($info, $headers);
    }
    /**
     * Send API error 422 (WILL EXIT SCRIPT)
     */
    protected function output_error_422(Result|string $info) 
    {
        $headers = array(CONTENT_TYPE_JSON, HEADER_ERROR_422);
        $this->output_error($info, $headers);
    }

    #endregion
}