# Codeigniter-Form-Validation-Extension
# Intro
This is a extension library from Form_validation
## Features
* Avoid resend POST vars on validate (Don't worry about F5)
* Get Flashmessage for Errors
* Get Flashmessage for Success
* Ajax Validation Response
* Customize Ajax success response
* Customize Success Message
* Extends Validators (Easy and fast)

# How to use
Enjoy the news methods added:
```
$this->form_validation->set_success_delimiters('<p style="color: green">', '</p>');
$this->form_validation->set_redirect('welcome/index');
$this->form_validation->set_success_message('Dados corretos');
$this->form_validation->repopulate_all_except(array('password', 'passconf'));
```
Use the 'execute' method for validate
execute($success_callback, $error_callback);
```
$this->form_validation->execute(function(){ 
    log_message('debug', "Testing validation OK"); 
}, function(){
    log_message('debug', 'Erro notificado');
});
```
See the file Welcome.php for more details.
Documentation coming soon.
