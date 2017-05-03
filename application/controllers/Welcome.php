<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author David Ticona Saravia <david.ticona.saravia@gmail.com>
 */
class Welcome extends MX_Controller
{
	/**
	 * The form
	 */
	public function index()
	{
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $data['message'] = $this->form_validation->get_message();
        $data['values']  = $this->form_validation->get_values();
        $data['ajax'] = FALSE;
        $this->load->view('myform', $data);
	}
    /**
	 * 
	 */
    public function post()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', array(
            'required', array('isCEP', array($this->form_validation->EXT, 'isCEP'))),
            array('isCEP'=>'Digitos no cep')
                );
        $this->form_validation->set_rules('password', 'Password', 'required',
                array('required' => 'Escreva uma senha no campo %s.'));
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]', 
                array('required' => 'Escreva uma senha no campo %s.', 'matches'=>'Password não coincide'));
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('select[]', 'Num', 'required');
        
        $this->form_validation->set_rules('aceito', 'Aceitar', 'required');
        
        $this->form_validation->set_error_delimiters('<p style="color: red">', '</p>');
        $this->form_validation->set_success_delimiters('<p style="color: green">', '</p>');
        $this->form_validation->set_redirect('welcome/index');
        $this->form_validation->set_success_message('Dados corretos');
        $this->form_validation->add_success_json('test', '123'); // for ajax request
        $this->form_validation->repopulate_all_except(array('password', 'passconf'));
        $this->form_validation->execute(function(){ 
            log_message('debug', "Testing validation OK");
        }, function(){
            log_message('debug', 'Erro notificado');
        });
    }
}
