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
        <script src="<?php echo BASE_URL ?>public/common/utilForm.js?v4"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                var frmValues = '<?php echo $values ?>';
                $('#frmCadastro').utilForm({data: frmValues, errorClass: 'alert-danger', successClass: 'alert-success'});
                /* INCLUDE THIS STATIC FUNCTIONS 
                setCheckbox: function(name, values){
            var $el = $("[name='" + name + "']");
            var data  = JSON.parse(values);
            if ($.isArray(data)){
                var selector = "[name='" + name + "\\[\\]']";
                $el = $(selector);
                $el.each(function(){
                    var val = $(this).val();
                    var state = (methods.inArray(val, data));
                    $(this).attr('checked', state);
                });
            } else{
                var state = (data == $el.val());
                $el.attr('checked', state);
            }
        },
        inArray: function(val, array){
            for (var i = 0, len = array.length; i < len; i++){
                if (array[i]==val){
                    return true;
                }
            }
            return false;
        }
        
        ##LAST
(function( $ ){
    var methods = {
        init : function(options) {
            var settings = $.extend({
                data: '',
                selectorMessage: '#message',
                errorClass: 'error',
                ajax: false
            }, options );
            var frmValues = settings.data;
            methods.fillForm(this, frmValues);
            if ((this.data('ajax') === 1)||(settings.ajax==true)){
                settingAjax(this);
            }
            function settingAjax(form) {
                form.on('submit', function (e) {
                    e.preventDefault();
                    var action = form.attr('action');
                    var data = form.serializeArray();
                    $.each(data, function (k, v) {
                        $("[name='" + v.name + "']").removeClass(settings.errorClass);
                    });
                    $.post(action, data, function (result){
                        var msg = '';
                        if (result.hasOwnProperty('valid')){
                            msg = result.text;
                        } else {
                            $.each(result, function (k, v){
                                $("[name='" + k + "']").addClass(settings.errorClass);
                                msg += '<p>' + v + '</p>';
                            });
                        }
                        $(settings.selectorMessage).html(msg).hide().fadeIn('slow');
                    });
                });
            }
        },
        fillForm : function(form, values) { 
            if (values === '')
                return;
            var $form = (form instanceof jQuery) ? form : $(form);
            var data = JSON.parse(values);
            $.each(data, function (name, val){
                var $el = $form.find("[name='" + name + "']");
                if ($.isArray(val)){
                    var selector = "[name='" + name + "\\[\\]']";
                    var $el = $form.find(selector);
                }
                var type = $el.attr('type');
                switch (type){
                    case 'checkbox':
                        if ($.isArray(val)) {
                            $el.each(function () {
                                var state = methods.inArray($(this).val(), val);
                                $(this).prop('checked', state);
                            });
                        } else {
                            $el.prop('checked', true);
                        }
                        break;
                    case 'radio':
                        $el.filter('[value="' + val + '"]').attr('checked', 'checked');
                        break;
                    default:
                        $el.val(val);
                }
            });
        },
        setCheckbox: function(form, name, values){
            var $form = (form instanceof jQuery) ? form : $(form);
            var $el = $form.find("[name='" + name + "']");
            var data  = JSON.parse(values);
            if ($.isArray(data)){
                var selector = "[name='" + name + "\\[\\]']";
                $el = $form.find(selector);
                $el.each(function(){
                    var val = $(this).val();
                    var state = methods.inArray(val, data);
                    $(this).prop('checked', state);
                });
            } else{
                var state = (data == $el.val());
                $el.prop('checked', state);
            }
        },
        inArray: function(val, array){
            for (var i = 0, len = array.length; i < len; i++){
                if (array[i]==val){
                    return true;
                }
            }
            return false;
        },
        checkAll: function(form, name, checked){
            $form = (form instanceof jQuery) ? form : $(form);
            if (checked instanceof jQuery){
                $chkAll = checked;
                var $check = $form.find("[name='" + name + "\\[\\]']");
                $chkAll.click(function(){
                    var state = $(this).prop('checked');
                    $form.find("[name='" + name + "\\[\\]']").prop('checked', state);
                });
                $check.click(function(){
                    if ($check.length === $form.find("[name='" + name + "\\[\\]']:checked").length)
                        $chkAll.prop('checked', true);
                    else
                        $chkAll.prop('checked', false);
                });
                return;
            }
            $form.find("[name='" + name + "\\[\\]']").prop('checked', checked);
        },
        chainedSelect: function(action, select1, select2){
            var $sel1 = (select1 instanceof jQuery) ? select1 : $(select1);
            var $sel2 = (select2 instanceof jQuery) ? select2 : $(select2);
            var key = $sel1.attr('name');
            $sel1.change(function(){
                var data = {};
                data[key] = $(this).val();
                $.post(action, data).done(function(result){
                        // var result = [{value: '11', text: 'ttt1'}, {value: '22', text: 'ttt2'}];
                        $.each(result, function(k, v){
                            var $opt = $('<option>');
                            $opt.val(v.value);
                            $opt.append(v.text);
                            $sel2.append($opt);
                        });
                        }).fail(function(e){
                            alert('Error: '+ e.statusText);
                        });
                //$.post(action, data, function(result){
                    
                //});
            });
        }
    };
    $.fn.utilForm = function(methodOrOptions) {
        if ( methods[methodOrOptions] ) {
            return methods[ methodOrOptions ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  methodOrOptions + ' does not exist on jQuery.utilform' );
        }    
    };
})( jQuery );
        ##
        
                */
            });
        </script>
    </body>
</html>
