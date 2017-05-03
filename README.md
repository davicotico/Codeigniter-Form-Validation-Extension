# Codeigniter Form Validation Extension
This is a extension library of Form_validation
## Features
* Avoid resend POST vars on refresh form page (Don't worry about F5)
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
### set_success_message($text)
Setting the success message

* **Parameters:**

string $text - Success message
### set_success_delimiters($open, $close)
Sets the default prefix and suffix for success message

* **Parameters:**

string $open - Open delimiter
string $close - Close delimiter

### set_redirect($redirect)
Redirect after execute validation
* **Parameters:**

string $redirect - URI/URL to redirect

### repopulate_all_except(array $array)
Exclude Fields to re-populate
* **Parameters:**

array $array Associative array with the fields to exclude

### execute(callable $success_cb, callable $error_cb = NULL)
Run the validation
* **Parameters:**

callable $success_cb Successfull callback
callable $error_cb Error callback


### get_message()
Get the validation message
* **Return:**

string The message (Html code)
### get_values()
Get Form Values (JSON string) from flashdata
* **Return:**

string - Json string
### set_template($template)
Setting the template message
* **Parameters:**

string $template - Template string

