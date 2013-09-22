@extends('templates.main')
@section('content')
@include('chapter.top')
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span><b>{{ $chapter->name }} : Pedido de Coordenaçao</b></span>
	</div>
	<div class="mws-panel-body no-padding">
		{{ Form::open(array('url'=>'chapter/requestcoord/'.$chapter->id, 'method'=>'POST', 'class' => 'mws-form')) }}
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<p>Por favor, faça seu pedido para criar um capítulo, e o coordenador responsável entrará em contato por email. Se possível informe outras formas de comunicação. Como Skype, Facebook ou Google Plus.</p>
					
					{{ Form::textarea('message',''	,array('class' => 'large autosize', 'style' => 'width: 100%;height: 108px;' )) }}
					{{ $errors->first('message', '<div class="mws-error">:message</div>') }}
				</div>
				<div class="mws-form-row">
					
				</div>
				
				<div class="mws-form-row">
					<label class="mws-form-label">
					{{ HTML::image(Captcha::img(), 'Captcha image') }}</label>
					<div class="mws-form-item">
						<input type="text" name="captcha">
						{{ $errors->first('captcha', '<div class="mws-error">:message</div>') }}
					</div>
				</div>
				
				
			</div>
			<div class="mws-button-row">
				{{ Form::submit('Enviar pedido', array('class' => 'btn btn-danger')); }}
			</div>
		{{ Form::close() }}
	</div>
</div>
             
@stop