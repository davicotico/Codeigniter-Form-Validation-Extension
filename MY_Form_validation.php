<?php
/**
 * Form Validation Extension Library for Codeigniter
 * @author David Ticona Saravia <david.ticona.saravia@gmail.com>
 * Features:
 * - Avoid resend POST vars on validate (Don't worry about F5)
 * - Get Flashmessage for Errors
 * - Get Flashmessage for Success
 * - Ajax Validation Response
 * - Customize Ajax success response
 * - Customize Success Message
 * - Extends Validators (Easy and fast)
 * 
 */
class MY_Form_validation extends CI_Form_validation
{
    protected $redirect;
    protected $excludeInputs;
    protected $successMessage;
    protected $success_delimiters;
    protected $ajaxResponse;
    protected $template;
    /**
     * @var Validators Object extensor
     */
    public $EXT;

    public function __construct($rules = array())
    {
        parent::__construct($rules);
        $this->init();
        include 'FormValidation/Validators.php';
        $this->EXT = new Validators($this);
    }
    /**
     * Initialize default values
     */
    protected function init()
    {
        $this->successMessage = 'OK!';
        $this->ajaxResponse = array();
        $this->set_success_delimiters('<p>', '</p>');
        $this->template = '<div class="{type}">{body}</div>';
        $this->redirect = base_url();
    }
    /**
     * Setting the success message
     * @param string $text Success message
     */
    public function set_success_message($text)
    {
        $this->successMessage = $text;
    }
    /**
     * Tag delimiters for success message
     * @param string $open Open delimiter
     * @param string $close Close delimiter
     */
    public function set_success_delimiters($open, $close)
    {
        $this->success_delimiters['open'] = $open;
        $this->success_delimiters['close']= $close;
    }
    /**
     * Attach variables on success json response (Only for ajax request)
     * @param string $key Json Key
     * @param string $value Json value
     */
    public function add_success_json($key, $value)
    {
        $this->ajaxResponse[$key] = $value;
    }
    /**
     * Redirect before execute validation
     * @param string $redirect URI/URL to redirect
     */
    public function set_redirect($redirect)
    {
        $this->redirect = $redirect;
    }
    /**
     * Exclude Fields to repopulate
     * @param array $array Associative array win the fields to exclude
     */
    public function repopulate_all_except(array $array)
    {
        $this->excludeInputs = $array;
    }
    
    /**
     * Run the validation
     * @param callable $success_cb Successfull callback
     * @param callable $error_cb Error callback
     */
    public function execute(callable $success_cb, callable $error_cb = NULL)
    {
        $isAjax = $this->CI->input->is_ajax_request();
        $this->isValid = $this->run();
        $isCallable = is_callable($error_cb);
        $msgType = 'success';
        if ($this->isValid == FALSE)
        {
            if ($isCallable)
            {
                call_user_func($error_cb);
            }
            $message = ($isAjax) ? json_encode($this->error_array()) : $this->error_string();
            $msgType = 'error';
        }
        else
        {
            call_user_func($success_cb);
            $this->ajaxResponse['valid'] = TRUE;
            $this->ajaxResponse['text']  = $this->successMessage;
            $json = json_encode($this->ajaxResponse);
            $message = ($isAjax) ? $json : "{$this->success_delimiters['open']}{$this->successMessage}{$this->success_delimiters['close']}";
        }
        if ($isAjax)
        {
            header('Content-Type: application/json; charset=utf-8');
            echo $message;
            exit(0);
        }
        else
        {
            $input = $this->getPostExcluding();
            $this->CI->session->set_flashdata('FV_values', json_encode($input));
            $this->CI->session->set_flashdata('FV_message', array('type'=>$msgType, 'body'=>$message));
            log_message('debug', "Validation executed at MY_Form_validation.php and redirect to: {$this->redirect}");
            redirect($this->redirect);
        }
    }
    /**
     * Get form post values excluding the setting elements
     * @return array Associative array
     */
    protected function getPostExcluding()
    {
        if (empty($this->excludeInputs))
        {
            return $this->CI->input->post(NULL, TRUE);
        }
        $except = $this->excludeInputs;
        $post = $this->CI->input->post(NULL, TRUE);
        foreach ($except as $k)
        {
            unset($post[$k]);
        }
        return $post;
    }
    /**
     * Get Form Values (JSON string) from flashdata
     * @return string Json string
     */
    public function get_values()
    {
        $values = $this->CI->session->flashdata('FV_values');
        return ($values===NULL) ? '' : $values;
    }
    /**
     * Get the validation message
     * @return string The message (Html code)
     */
    public function get_message()
    {
        $data = $this->getArrayMessage();
        if (empty($data))
        {
            return '';
        }
        $this->CI->load->library('parser');
        return $this->CI->parser->parse_string($this->template, $data, TRUE);
    }
    /**
     * Get array message from flashdata
     * @return array Array with data message
     */
    private function getArrayMessage()
    {
        $msg = $this->CI->session->flashdata('FV_message');
        return ($msg===NULL) ? array() : $msg;
    }
    /**
     * @param string $template Template string
     */
    public function set_template($template)
    {
        $this->template = $template;
    }
}
