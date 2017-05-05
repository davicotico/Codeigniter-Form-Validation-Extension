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
<script type="text/javascript">
    $(document).ready(function(){
        var frmValues = '<?php echo $values ?>';
        fillForm(frmValues);
        if ($('#frmCadastro').data('ajax')===1){
            settingAjax();
        }
        function settingAjax(){
            $('#frmCadastro').on('submit', function(e){
                e.preventDefault();
                var action = $(this).attr('action');
                var data = $(this).serializeArray();
                $.each(data, function(k, v){
                    $("[name='"+v.name+"']").removeClass('error');
                });
                $.post(action, data, function(result){
                    var msg = '';
                    if (result.hasOwnProperty('valid')){
                        msg = result.text;
                    } else{
                        $.each(result, function(k, v){
                            $("[name='"+k+"']").addClass('error');
                            msg += '<p>'+v+'</p>';
                        });
                    }
                    $('#message').html(msg).hide().fadeIn('slow');
                });
            });
        }
        function fillForm(values){
            if (values === '') return;
            var data = jQuery.parseJSON(values);
            $.each(data, function(name, val){
                var $el = $("[name='"+name+"']");
                if ($.isArray(val)){
                    var selector = "[name='"+name+"\\[\\]']";
                    var $el = $(selector);
                }
                var type = $el.attr('type');
                switch(type){
                case 'checkbox':
                    if ($.isArray(val)){
                        $el.each(function(){
                            var state = ($.inArray($(this).val(), val)!==-1);
                            $(this).prop('checked', state);
                        });
                    } else{
                        $el.attr('checked', 'checked');
                    }
                    break;
                case 'radio':
                    $el.filter('[value="'+val+'"]').attr('checked', 'checked');
                    break;
                default:
                    $el.val(val);
                }
            });
        }
    });
    
    /*
    
    var frmValues = '<?php echo $values ?>';
        //$('#frmCadastro').utilForm({data: frmValues});
        $('#frmCadastro').utilForm('fillForm', frmValues);
    
    (function( $ ){
    var methods = {
        init : function(options) {
            var settings = $.extend({
                data: '',
                selectorMessage: '#message',
                errorClass: 'error'
            }, options );
            var frmValues = settings.data;
            methods.fillForm(frmValues);
            if (this.data('ajax') === 1) {
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
        fillForm : function(values) {    
            if (values === '')
                return;
            var data = jQuery.parseJSON(values);
            $.each(data, function (name, val) {
                var $el = $("[name='" + name + "']");
                if ($.isArray(val)) {
                    var selector = "[name='" + name + "\\[\\]']";
                    var $el = $(selector);
                }
                var type = $el.attr('type');
                switch (type) {
                    case 'checkbox':
                        if ($.isArray(val)) {
                            $el.each(function () {
                                var state = ($.inArray($(this).val(), val) !== -1);
                                $(this).prop('checked', state);
                            });
                        } else {
                            $el.attr('checked', 'checked');
                        }
                        break;
                    case 'radio':
                        $el.filter('[value="' + val + '"]').attr('checked', 'checked');
                        break;
                    default:
                        $el.val(val);
                }
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
    */
</script>
</body>
</html>
