<html>
<head>
<title>My Form</title>
</head>
<style>
.error {border: red solid 1px;}
</style>
<body>  
<?php  echo $message; ?>
<div id="message" style="display: none;"></div>
<?php echo form_open('welcome/post', array('method'=>'post', 'id'=>'frmCadastro', 'data-ajax'=>$ajax)); ?>
<h5>Username</h5>
<input type="text" name="username" id="username" value="" size="50" />
<h5>Password</h5>
<input type="password" name="password" id="password" value="" size="50" />
<h5>Password Confirm</h5>
<input type="password" name="passconf" id="passconf" value="" size="50" />
<h5>Email Address</h5>
<input type="email" name="email" id="email" value="" size="50" />
<label><input type="checkbox" name="select[]" value="1"> 1</label>
<label><input type="checkbox" name="select[]" value="2"> 2</label>
<label><input type="checkbox" name="select[]" value="3"> 3</label>
<br><label><input type="checkbox" name="aceito" value="1"> Aceito</label>
<div><input type="submit" value="Submit" /></div>
<?php echo form_close() ?>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="<?php echo BASE_URL ?>public/common/utilForm.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var frmValues = '<?php echo $values ?>';
        $('#frmCadastro').utilForm('fillForm', frmValues);
    });
</script>
</body>
</html>
