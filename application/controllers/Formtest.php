<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author David Ticona Saravia <david.ticona.saravia@gmail.com>
 */
class Formtest extends CI_Controller
{
    public function index()
    {
        $this->load->library('form_validation');
        $tpl = "<div class=\"alert alert-{type}\" role=\"alert\">{message}</div>";
        $this->form_validation->setMessageTemplate($tpl, array('error'=>'danger'));
        $data['message'] = $this->form_validation->getMessage();
        $this->form_validation->loadValues();
        $this->load->view('myform', $data);
    }
    public function formAjax()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $data['ajax'] = TRUE;
        $this->load->view('myformAjax', $data);
    }
    public function post()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username','required');
        $this->form_validation->set_rules('password', 'Password', 'required',
                array('required' => 'Escreva uma senha no campo %s.'));
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]', 
                array('required' => 'Escreva uma senha no campo %s.', 'matches'=>'Password não coincide'));
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('zipcode', 'Zip code', 'required|zipcode',
                array('zipcode'=>'Escreva um cep valido'));
        $this->form_validation->set_rules('select[]', 'Subscribe', 'required');
        $this->form_validation->set_rules('accept', 'Accept the terms', 'required');
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->setSuccessDelimiters('<p style="color: green">', '</p>');
        $this->form_validation->setRedirect('formtest/index');
        $this->form_validation->setSuccessMessage('Congratulations');
        $this->form_validation->addSuccessJsonVar('test', '123'); // for ajax request
        $this->form_validation->repopulateAllExcept(array('password', 'passconf'));
        $this->form_validation->validate(function(){ 
            log_message('info', "Success: This was executed before the redirect (or before the response ajax)");
        }, function(){
            log_message('debug', 'Error: This was executed before the redirect (or before the response ajax)');
        });
    }
}
