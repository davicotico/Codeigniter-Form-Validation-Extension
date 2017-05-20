<?php

/**
 * Form Validation Extension Library for Codeigniter
 * @author David Ticona Saravia <david.ticona.saravia@gmail.com>
 * 
 */
class MY_Form_validation extends CI_Form_validation
{

    protected $redirect;
    protected $excludeInputs;
    protected $repopulatedInputs;
    protected $successMessage;
    protected $success_delimiters;
    protected $ajaxResponse;
    protected $template;

    /**
     * @var Validators Object extensor
     */
    public $ext;

    public function __construct($rules = array())
    {
        parent::__construct($rules);
        $this->init();
        include 'Validators/Validators.php';
        require_once 'Validators/form_helper.php';
        $this->ext = new Validators($this);
    }

    /**
     * Initialize default values
     */
    protected function init()
    {
        $this->CI->load->library('session');
        $this->CI->load->helper('url');
        $this->successMessage = 'OK!';
        $this->ajaxResponse = array();
        $this->setSuccessDelimiters('<p>', '</p>');
        $this->template = '';
        $this->redirect = $this->CI->config->item('base_url');
    }

    /**
     * Setting the success message
     * @param string $text Success message
     */
    public function setSuccessMessage($text)
    {
        $this->successMessage = $text;
    }

    /**
     * Tag delimiters for success message
     * @param string $open Open delimiter
     * @param string $close Close delimiter
     */
    public function setSuccessDelimiters($open, $close)
    {
        $this->success_delimiters['open'] = $open;
        $this->success_delimiters['close'] = $close;
    }

    /**
     * Add variable on success json response (Only for ajax request)
     * @param string $key Json Key
     * @param string $value Json value
     */
    public function addSuccessJsonVar($key, $value)
    {
        $this->ajaxResponse[$key] = $value;
    }

    /**
     * Redirect before execute validation
     * @param string $redirect URI/URL to redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Exclude Fields to repopulate
     * @param array $array Associative array win the fields to exclude
     */
    public function repopulateAllExcept(array $array)
    {
        $this->excludeInputs = $array;
    }

    /**
     * Validate
     * @param callable $success_cb Success callback
     * @param callable $error_cb Error callback
     */
    public function validate(callable $success_cb, callable $error_cb = NULL)
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
        } else
        {
            call_user_func($success_cb);
            $message = ($isAjax) ? $this->_formatSuccessJson() : "{$this->success_delimiters['open']}{$this->successMessage}{$this->success_delimiters['close']}";
        }
        if ($isAjax)
        {
            header('Content-Type: application/json; charset=utf-8');
            echo $message;
            exit(0);
        } else
        {
            $input = $this->getPostExcluding($this->excludeInputs);
            $this->CI->session->set_flashdata('FV_values', json_encode($input));
            $this->CI->session->set_flashdata('FV_message', array('type' => $msgType, 'message' => $message));
            log_message('info', "Validation executed at MY_Form_validation.php and redirect to: {$this->redirect}");
            redirect($this->redirect);
        }
    }

    /**
     * @return string Json string for ajax response
     */
    private function _formatSuccessJson()
    {
        $this->ajaxResponse['valid'] = TRUE;
        $this->ajaxResponse['text'] = $this->successMessage;
        return json_encode($this->ajaxResponse);
    }

    /**
     * Get form post values excluding the setting elements
     * @param array $excludeInputs Don't repopulate this inputs
     * @return array Associative array
     */
    protected function getPostExcluding($excludeInputs)
    {
        if (empty($excludeInputs))
        {
            return $this->CI->input->post(NULL, TRUE);
        }
        $except = $excludeInputs;
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
    public function getValues()
    {
        $values = $this->CI->session->flashdata('FV_values');
        return ($values === NULL) ? '' : $values;
    }

    /**
     * @param string $template Template string
     * @param array $typeClass (Optional) CSS Class to replace in template
     */
    public function setTemplate($template, $typeClass = NULL)
    {
        $this->template['html'] = $template;
        $this->template['error'] = isset($typeClass['error']) ? $typeClass['error'] : 'error';
        $this->template['success'] = isset($typeClass['success']) ? $typeClass['success'] : 'success';
    }

    /**
     * Get array message from flashdata
     * @return array Array with data message
     */
    private function getArrayMessage()
    {
        $msg = $this->CI->session->flashdata('FV_message');
        return ($msg === NULL) ? array() : $msg;
    }

    /**
     * Get the validation message
     * @return string The message (Html code)
     */
    public function getMessage()
    {
        $data = $this->getArrayMessage();
        if (empty($data))
        {
            return '';
        }
        $data['type'] = $this->template[$data['type']];
        $str = strtr($this->template['html'], array('{type}' => $data['type'], '{message}' => $data['message']));
        return $str;
    }

    /**
     * Load form values
     * 
     */
    public function loadValues()
    {
        $values = $this->CI->session->flashdata('FV_values');
        if ($values !== NULL)
        {
            $inputData = json_decode($values, TRUE);
            $this->repopulatedInputs = $inputData;
        }
    }

    /**
     * Get form value
     * @param string $field Input name
     * @param string $default (Optional) Default value
     * @return mixed Form value
     */
    public function getValue($field, $default = '')
    {
        return (isset($this->repopulatedInputs[$field])) ? $this->repopulatedInputs[$field] : $default;
    }

}
