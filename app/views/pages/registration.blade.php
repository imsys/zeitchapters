@extends('templates.main')
@section('styles')
{{ HTML::style('custom-plugins/wizard/wizard.css') }}
@stop


@section('body')
<div class="container" style="padding-top: 20px;">
      <div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-magic"></i> Registro</span>
                    </div>
                    <div class="mws-panel-body no-padding">
						{{ Form::open(array('url'=>'registration','method'=>'POST','class' => 'mws-form wzd-default')) }}

                            <fieldset class="wizard-step mws-form-inline">
                                <legend class="wizard-label"><i class="icol-accept"></i> Perfil do Membro</legend>
                                <div id class="mws-form-row">
                                    <label class="mws-form-label">Nome <span class="required">*</span></label>
                                    <div class="mws-form-item">
										{{ Form::text('name','', array('class' => 'required large')) }}
										{{ $errors->first('name', '<div class="mws-error">:message</div>') }}
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Email <span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        {{ Form::text('email','', array('class' => 'required email large')) }}
										{{ $errors->first('email', '<div class="mws-error">:message</div>') }}
                                    </div>
                                </div>
								
								<div class="mws-form-row">
                                    <label class="mws-form-label">Senha <span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="password" name="password" class="required large" />
										{{ $errors->first('password', '<div class="mws-error">:message</div>') }}
                                    </div>
                                </div>
								
								<div class="mws-form-row">
                                    <label class="mws-form-label">Confirmação de Senha <span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <input type="password" name="password_confirm" class="required large" />
										{{ $errors->first('password_confirm', '<div class="mws-error">:message</div>') }}
                                    </div>
                                </div>
								
								<div class="mws-form-row">
                                    <label class="mws-form-label">Captcha: <span class="required">*</span>{{ HTML::image(Captcha::img(), 'Captcha image') }}</label>
									
                                    <div class="mws-form-item">
                                        <input type="text" name="captcha" class="required large" />
										{{ $errors->first('captcha', '<div class="mws-error">:message</div>') }}
                                    </div>
                                </div>
								
								
                                
                            </fieldset>
                            
                            <fieldset class="wizard-step mws-form-inline chapters-col">
                                <legend class="wizard-label"><i class="icol-delivery"></i> Capítulo</legend>
                                
                                <div class="mws-form-row chap-div chap-1" level="1" parent="1">
                                    <label class="mws-form-label">Capítulo <span class="required">*</span></label>
                                    <div class="mws-form-item">
                                        <select class="required large" name="chapter[1]" parent="1">
											<option value="0">Escolha um Capítulo</option>
                                            <option value="2">Brasil</option>
                                        </select>
                                    </div>
                                </div>
							
                                
                            </fieldset>
						
                        {{ Form::close() }}
                    </div>
                </div>
    </div>
@stop


@section('scripts')
<!-- Wizard Plugin -->
   
{{ HTML::script('custom-plugins/wizard/wizard.min.js') }}
{{ HTML::script('custom-plugins/wizard/jquery.form.min.js') }}

{{ HTML::script('js/demo/demo.wizard.js') }}

<script>
$(function(){
	var chap_onchange = function (){
		var selectedval = $(this).val();
		var objlevel = ($(this).attr('level')?parseInt($(this).attr('level')):1);
		if(selectedval !== 0) {
			$.post("{{ URL::to('registration/list-subchapters') }}/" + selectedval)
			.done(function (data){
		
				var newlevel = objlevel+1;
				$('.chap-'+newlevel).remove();
				
				if(data.length > 0){
					$('.chapters-col').append("<div class='mws-form-row chap-div' level='"+newlevel+"' parent='"+selectedval+"'>\n\
\n\
 <label class='mws-form-label'>Capítulo</label>\
                                    <div class='mws-form-item'>\
                                        <select class='large' name='chapter["+newlevel+"]' level='"+newlevel+"' parent='"+selectedval+"'>\
                                        </select>\
                                    </div>\n\
</div>");
					var currobj = $('.chap-div[level='+newlevel+']');
					for(var i=1; i <= newlevel ; i++){
						currobj.addClass('chap-'+i);
					}
					var dropdown = $('select[parent='+ selectedval +']');
					dropdown.append("<option value='0'>Selecione um Capitulo</option>");
					for(var i=0; data[i] !== undefined; i++){
						dropdown.append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
					}
					dropdown.change(chap_onchange);
				}});
		} 
	};
	
	$('select[parent=1]').change(chap_onchange);

	var selected_chap = {{json_encode(Input::old('chapter'))}};

	if (selected_chap){
		var c = 1;
		var interval = setInterval(function() { 
			$('.chap-'+c).find('select').val(selected_chap[c]);
			$('.chap-'+c).find('select').change();
			c++;		  
			if(!selected_chap[c]) clearInterval(interval);
		}, 100);
	}

	
});


</script>



@stop