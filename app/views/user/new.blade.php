@extends('templates.main')
@section('content')
@include('user.top')
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-list">New User</span>
	</div>
	<div class="mws-panel-body no-padding">
		{{ Form::open(array('url'=>'user/'. (@$user->id?$user->id.'/edit':'new') ,'method'=>'POST','class' => 'mws-form')) }}
			<div class="mws-form-inline">
				<div class="mws-form-row">
					{{ Form::label('name', 'Name', array('class'=>'mws-form-label')) }}
					<div class="mws-form-item">
						{{ Form::text('name',Input::old('name', @$user->name), array('class' => 'large')) }}
						{{ $errors->first('name', '<div class="mws-error">:message</div>') }}
					</div>
				</div>
				<div class="mws-form-row">
					{{ Form::label('email', 'Email', array('class'=>'mws-form-label')) }}
					<div class="mws-form-item">
						{{ Form::text('email',Input::old('email', @$user->email), array('class' => 'large')) }}
						{{ $errors->first('email', '<div class="mws-error">:message</div>') }}
					</div>
				</div>
				<div class="mws-form-row">
					{{ Form::label('password', 'Change Password (optional)', array('class'=>'mws-form-label')) }}
					<div class="mws-form-item">
						{{ Form::password('password', array('class' => 'large')) }}
						{{ $errors->first('password', '<div class="mws-error">:message</div>') }}
					</div>
				</div>
				
				
				<div class="mws-form-row">
					{{ Form::label('role', 'Operational Roles', array('class'=>'mws-form-label')) }}
					<div class="mws-form-item clearfix">
						<ul class="mws-form-list inline">
							@foreach ($roles as $role)
								<li><label><input type="checkbox" name="role" value="{{$role->id}}" {{($user->has_role($role->name)?'checked':'')}} /> {{$role->name}}</label></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="mws-button-row">
				{{ Form::submit((@$user->id?'edit':'save'), array('class' => 'mws-button red')); }}
				{{-- Form::reset('Reset', array('class' => 'mws-button gray')); --}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop