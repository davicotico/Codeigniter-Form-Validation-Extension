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
We have two alternatives: With ajax validation OR without ajax
## Without Ajax
In order to implement form validation you’ll need two things:
* A View file containing a form.
* A controller method to receive, process the submitted data and redirect the result message.
### The Form
```html
<div class="panel-body">
    <?php echo $message; ?>
    <?php echo form_open('welcome/post', array('method' => 'post', 'id' => 'frmCadastro')); ?>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" size="50" value="<?php setValue('username') ?>">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" size="50">
    </div>
    <div class="form-group">
        <label for="passconf">Password Confirm</label>
        <input type="password" name="passconf" id="passconf" size="50" class="form-control">
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" size="50" value="<?php setValue('email') ?>">
    </div>
    <h4>Subscribe to:</h4>
    <div class="checkbox">
        <label><input type="checkbox" name="select[]" value="1" <?php setCheckbox('select', '1') ?>> Newsletter</label>
        <label><input type="checkbox" name="select[]" value="2" <?php setCheckbox('select', '2') ?>> Promotions</label>
        <label><input type="checkbox" name="select[]" value="3" <?php setCheckbox('select', '3') ?>> Free stuff</label>
    </div>
    <h4>Accept the terms?</h4>
    <div class="checkbox">
        <label><input type="checkbox" name="accept" value="1" <?php setCheckbox('accept', '1') ?>> I accept</label>
    </div>
    <div><button type="submit" id="btnSend" class="btn btn-success">Send</button></div>
    <?php echo form_close() ?>
</div>
```
### The controller

```php
class Welcome extends CI_Controller
{
    public function form()
    {
        $this->load->library('form_validation');
        $tpl = "<div class=\"alert alert-{type}\" role=\"alert\">{message}</div>";
        $this->form_validation->set_template($tpl, array('error'=>'danger'));
        $data['message'] = $this->form_validation->get_message();
        $this->form_validation->load_values();
        $this->load->view('myform', $data);
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
        $this->form_validation->set_rules('select[]', 'Subscribe', 'required');
        $this->form_validation->set_rules('accept', 'Accept the terms', 'required');
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_success_delimiters('<p style="color: green">', '</p>');
        $this->form_validation->set_redirect('welcome/form');
        $this->form_validation->set_success_message('Congratulations');
        $this->form_validation->add_success_json('test', '123'); // for ajax request
        $this->form_validation->repopulate_all_except(array('password', 'passconf'));
        $this->form_validation->execute(function(){ 
            log_message('debug', "Success: This was executed before the redirect (or before the response ajax)");
        }, function(){
            log_message('debug', 'Error: This was executed before the redirect (or before the response ajax)');
        });
    }
}
```

# Class reference
### set_success_message($text)
Setting the success message

**Parameters:**

* string $text - Success message
### set_success_delimiters($open, $close)
Sets the default prefix and suffix for success message

**Parameters:**

* string $open - Open delimiter
* string $close - Close delimiter

### set_redirect($redirect)
Redirect after execute validation

**Parameters:**

* string $redirect - URI/URL to redirect

### repopulate_all_except(array $array)
Exclude Fields to re-populate

**Parameters:**

* array $array Associative array with the fields to exclude

### execute(callable $success_cb, callable $error_cb = NULL)
Run the validation

**Parameters:**

* callable $success_cb Successfull callback
* callable $error_cb Error callback


### get_message()
Get the validation message

**Return:** string The message (Html code)
### get_values()
Get Form Values (JSON string) from flashdata

**Return:** string - Json string
### set_template($template, $typeClass = NULL)
Setting the template message

**Parameters:**

* string $template - Template string
* array $typeClass - (Optional) CSS Class to replace in template

## Helpers included
### setValue($field, $default = '')
Echoes the value for input field. Use in a view file. 
### setCheckbox($field, $value)
Echoes the 'checked' for input type checkbox. When the value is present in form values, display "checked". Use in a view file. 
