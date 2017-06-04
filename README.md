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

## Installation
Copy the folder *FormValidation/* and the file *MY_Form_validation.php* to your Codeigniter folder *application/libraries*
```
application/
-- libraries/
---- FormValidation/
---- MY_Form_validation.php
```
## How to use
### Without ajax
#### The Form

Create a view file (using the functions to repopulate) [The Form view](https://github.com/davicotico/Codeigniter-Form-Validation-Extension/blob/master/application/views/myform.php)

Create the controller method: [The Form controller method](https://github.com/davicotico/Codeigniter-Form-Validation-Extension/blob/master/application/controllers/Formtest.php#L7)

#### The validation

Create a controller method for validate your data (and save in database) [The post controller method](https://github.com/davicotico/Codeigniter-Form-Validation-Extension/blob/master/application/controllers/Formtest.php#L23)
### With Ajax
#### The Form

**Requirements:** The JQuery plugin [formHelper](https://github.com/davicotico/jQuery-formHelper)

Create a view file: [The Form view](https://github.com/davicotico/Codeigniter-Form-Validation-Extension/blob/master/application/views/myformAjax.php)

Create the controller method: [The form controller](https://github.com/davicotico/Codeigniter-Form-Validation-Extension/blob/master/application/controllers/Formtest.php#L16)

#### The validation

[The post controller method](https://github.com/davicotico/Codeigniter-Form-Validation-Extension/blob/master/application/controllers/Formtest.php#L23)

## Extending validations
### Create the validator function 
Open the file FormValidation/validators.php and create your function.

validators.php
```php
/*This example is for Brasil Zip code*/
function zipcode($value)
{
    return ((preg_match('/^[0-9]{5,5}([-]?[0-9]{3,3})?$/', $value))===1);
}
```
Done, now you can use the function in your validation rules.
### How to use
```php
$this->form_validation->set_rules('zipcode', 'Zip code', 'required|zipcode', array('zipcode'=>'Escreva um cep valido'));
```

# Class reference
### setSuccessMessage($text)
Setting the success message

**Parameters:**

* string $text - Success message
### setSuccessDelimiters($open, $close)
Sets the default prefix and suffix for success message

**Parameters:**

* string $open - Open delimiter
* string $close - Close delimiter

### setRedirect($redirect)
Redirect after execute validation

**Parameters:**

* string $redirect - URI/URL to redirect

### repopulateAllExcept(array $array)
Exclude Fields to re-populate

**Parameters:**

* array $array Associative array with the fields to exclude

### validate(callable $success_cb, callable $error_cb = NULL)
Run the validation

**Parameters:**

* callable $success_cb Successfull callback
* callable $error_cb Error callback


### getMessage()
Get the validation message

**Return:** string The message (Html code)
### getValues()
Get Form Values (JSON string) from flashdata

**Return:** string - Json string
### setTemplate($template, $typeClass = NULL)
Setting the template message

**Parameters:**

* string $template - Template string
* array $typeClass - (Optional) CSS Class to replace in template

### addSuccessJsonVar($key, $value)
Add variable on success json response (Only for ajax request)

**Parameters:**

* string $key - Key name
* string $value - Value

## Helpers included
### setValue($field, $default = '')
Display the value for input field. Use in a view file. 

**Parameters:**

* string $field - Input name
* string $default - (Optional) Default value
### setChecked($field, $value)
Display 'checked' for input type checkbox and radio button. When the value is present in form values, display "checked". Use in a view file. 

**Parameters:**

* string $field - Input name
* string $value - This value is setting? .. So, Checked

### setSelected($field, $value)
Display 'selected' for input select(comobobox). When the value is present in form values, display "selected". Use in a view file. 

**Parameters:**

* string $field - Input name
* string $value - This value is setting? .. So, Selected
