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
Enjoy the new methods added:
```php
$this->form_validation->set_success_delimiters('<p style="color: green">', '</p>');
$this->form_validation->set_redirect('welcome/index');
$this->form_validation->set_success_message('Dados corretos');
$this->form_validation->repopulate_all_except(array('password', 'passconf'));
```
Use the 'execute' method for validate

execute($success_callback, $error_callback);
```php
$this->form_validation->execute(function(){ 
    log_message('debug', "Here save your data. This line will be executed before redirect"); 
}, function(){
    log_message('debug', 'Error. This line will be executed before redirect');
});
```
# Class reference
#### set_success_message($text)
Setting the success message
* **Parameters:**

string $text - Success message

#### set_success_delimiters($open, $close)
* **Parameters:**

Sets the default prefix and suffix for success message

string $open - Open delimiter
string $close - Close delimiter

#### set_redirect($redirect)
* **Parameters:**

string $redirect - URI/URL to redirect

Redirect after execute validation
#### repopulate_all_except(array $array)
* **Parameters:**

array $array Associative array with the fields to exclude

Exclude Fields to re-populate
#### execute(callable $success_cb, callable $error_cb = NULL)
* **Parameters:**

callable $success_cb Successfull callback
callable $error_cb Error callback

Run the validation
#### get_message()
* **Return:**

string The message (Html code)

Get the validation message
