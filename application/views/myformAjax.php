<html>
    <head>
        <title>Form Validation Improved Demo 2 - With Ajax</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    </head>
    <body>  
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">Register</div>
                        <div class="panel-body">
                            <div id="message" class="alert" role="alert"></div>
                            <?php echo form_open('welcome/post', array('method' => 'post', 'id' => 'frmCadastro', 'data-ajax' => 1)); ?>
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
                                <input type="email" name="email" id="email" class="form-control" size="50" value="">
                            </div>
                            <h4>Subscribe to:</h4>
                            <div class="checkbox">
                                <label><input type="checkbox" name="select[]" value="1"> Newsletter</label>
                                <label><input type="checkbox" name="select[]" value="2"> Promotions</label>
                                <label><input type="checkbox" name="select[]" value="3"> Free stuff</label>
                            </div>
                            <h4>Accept the terms?</h4>
                            <div class="checkbox">
                                <label><input type="checkbox" name="accept" value="1"> I accept</label>
                            </div>
                            <div><button type="submit" id="btnSend" class="btn btn-success">Send</button></div>
                            <?php echo form_close() ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="<?php echo BASE_URL ?>public/common/formHelper.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                var frmValues = '<?php echo $values ?>';
                $('#frmCadastro').utilForm({data: frmValues, errorClass: 'alert-danger', successClass: 'alert-success'});
            });
        </script>
    </body>
</html>
