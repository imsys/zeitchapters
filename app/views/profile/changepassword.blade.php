@extends('templates.main')
@section('content')

<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">Mudanca de Senha</span>
	</div>
	<div class="mws-panel-body no-padding">
		{{ @$msg }}
		
		{{ Form::open(array('url'=>'profile/changepassword' ,'method'=>'POST','class' => 'mws-form')) }}
			<div class="mws-form-inline">
				
				<div class="mws-form-row">
					{{ Form::label('password', 'Senha Atual', array('class'=>'mws-form-label')) }}
					<div class="mws-form-item">
						{{ Form::password('password', array('class' => 'large')) }}
						{{ $errors->first('password', '<div class="mws-error">:message</div>') }}
					</div>
				</div>
				
				<div class="mws-form-row">
					{{ Form::label('newpassword', 'Nova Senha', array('class'=>'mws-form-label')) }}
					<div class="mws-form-item">
						{{ Form::password('newpassword', array('class' => 'large')) }}
						{{ $errors->first('newpassword', '<div class="mws-error">:message</div>') }}
					</div>
				</div>
				
				<div class="mws-form-row">
					{{ Form::label('confirmpassword', 'Confirmação de Senha', array('class'=>'mws-form-label')) }}
					<div class="mws-form-item">
						{{ Form::password('confirmpassword', array('class' => 'large')) }}
						{{ $errors->first('confirmpassword', '<div class="mws-error">:message</div>') }}
					</div>
				</div>
				
				
			</div>
			<div class="mws-button-row">
				{{ Form::submit('Alterar', array('class' => 'btn btn-danger')) }}
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop