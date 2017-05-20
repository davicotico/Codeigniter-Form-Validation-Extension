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

## How to use
### Without ajax
[See the controller example](https://github.com/davicotico/Codeigniter-Form-Validation-Extension/blob/master/application/controllers/Welcome.php#L7)

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
Echoes the value for input field. Use in a view file. 

**Parameters:**

* string $field - Input name
* string $default - (Optional) Default value
### setCheckbox($field, $value)
Echoes the 'checked' for input type checkbox. When the value is present in form values, display "checked". Use in a view file. 

**Parameters:**

* string $field - Input name
* string $value - This value is setting? .. So, Checked

