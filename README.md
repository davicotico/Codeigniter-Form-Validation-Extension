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
* A controller method to receive and process the submitted data
### The Form
```html
<body>  
<?php  echo $message; ?>
<?php echo form_open('welcome/post', array('method'=>'post', 'id'=>'frmCadastro')); ?>
<h5>Username</h5>
<input type="text" name="username" id="username" size="50" value="<?php set_value('username') ?>" />
<h5>Password</h5>
<input type="password" name="password" id="password" value="" size="50" />
<h5>Password Confirm</h5>
<input type="password" name="passconf" id="passconf" value="" size="50" />
<h5>Email Address</h5>
<input type="email" name="email" id="email" size="50" value="<?php set_value('email') ?>" />
<label><input type="checkbox" name="select[]" value="1" <?php set_checkbox('select', '1') ?>> 1</label>
<label><input type="checkbox" name="select[]" value="2" <?php set_checkbox('select', '2') ?>> 2</label>
<label><input type="checkbox" name="select[]" value="3" <?php set_checkbox('select', '3') ?>> 3</label>
<div><input type="submit" value="Submit" /></div>
<?php echo form_close() ?>
</body>
```
### The controller
```php
public function form()
{
    $this->load->helper(array('form'));
    $this->load->library('form_validation');
    $data['message'] = $this->form_validation->get_message();
    $this->form_validation->load_values();
    $this->load->view('myform', $data);
}
    
public function post()
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required',
            array('required' => 'Escreva uma senha no campo %s.'));
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]', 
            array('required' => 'Escreva uma senha no campo %s.', 'matches'=>'Password não coincide'));
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('select[]', 'Num', 'required');
    $this->form_validation->set_error_delimiters('<p style="color: red">', '</p>');
    $this->form_validation->set_success_delimiters('<p style="color: green">', '</p>');
    $this->form_validation->set_redirect('welcome/form1');
    $this->form_validation->set_success_message('Dados corretos');
    $this->form_validation->repopulate_all_except(array('password', 'passconf'));
    $this->form_validation->execute(function(){ 
        log_message('debug', "Testing validation OK");
    }, function(){
        log_message('debug', 'Erro notificado');
    });
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
### set_template($template)
Setting the template message

**Parameters:**

* string $template - Template string
