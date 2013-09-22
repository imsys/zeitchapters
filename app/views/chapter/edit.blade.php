@extends('templates.main')
@section('content')
@include('chapter.top')
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span><b>{{ trans('general.edit') . ': ' . $chapter->name }}</b></span>
	</div>
	<div class="mws-panel-body no-padding">
		{{ Form::open(array('url'=>'chapter/edit/'.$chapter->id, 'method'=>'POST', 'class' => 'mws-form')) }}
			<div class="mws-form-row">
				<div class="mws-form-cols">
					<div class="mws-form-col-3-8 alpha">
						{{ Form::label('name', 'Name (Original)') }}
						<div class="mws-form-item large">
							{{ Form::text('name',$chapter->name, array('class' => 'mws-textinput')) }}
							{{ $errors->first('name', '<div class="mws-error">:message</div>') }}
						</div>
					</div>
					<div class="mws-form-col-3-8">
						{{ Form::label('name_en', 'Name (English)') }}
						<div class="mws-form-item large">
							{{ Form::text('name_en',$chapter->name_en, array('class' => 'mws-textinput')) }}
							{{ $errors->first('name_en', '<div class="mws-error">:message</div>') }}
						</div>
					</div>

					<div class="mws-form-col-1-8">
						{{ Form::label('abbr', 'Abbreviation') }}
						<div class="mws-form-item large">
							{{ Form::text('abbr',$chapter->abbr, array('class' => 'mws-textinput')) }}
							{{ $errors->first('abbr', '<div class="mws-error">:message</div>') }}
						</div>
					</div>

					<div class="mws-form-col-1-8 omega">
						{{ Form::label('enabled', 'Chapter Status') }}
						<div class="mws-form-item large">
							<label>{{ Form::checkbox('enabled', 1, $chapter->enabled, array('class'=>'ibutton', 'data-label-on'=>trans('chapter.active'), 'data-label-off' => trans('chapter.unactive'))) }}</label>
						</div>
					</div>
				</div>
			</div>
			<div class="mws-form-row">
				<div class="mws-form-cols">
					<div class="mws-form-col-4-8 alpha">
						{{ Form::label('website', 'Website') }}
						<div class="mws-form-item large">
							{{ Form::text('website',$chapter->website, array('class' => 'mws-textinput')) }}
							{{ $errors->first('website', '<div class="mws-error">:message</div>') }}
						</div>
					</div>
					<div class="mws-form-col-4-8 omega">
						{{ Form::label('email', 'Email') }}
						<div class="mws-form-item large">
							{{ Form::text('email',$chapter->email, array('class' => 'mws-textinput')) }}
							{{ $errors->first('email', '<div class="mws-error">:message</div>') }}
						</div>
					</div>

				</div>
			</div>
			<div class="mws-form-row">
				<div class="mws-form-cols">

					<div class="mws-form-col-2-8 alpha">
						{{ Form::label('facebookpage', 'Facebook Page') }}
						<div class="mws-form-item large">
							{{ Form::text('facebookpage',$chapter->facebookpage, array('class' => 'mws-textinput')) }}
							{{ $errors->first('facebookpage', '<div class="mws-error">:message</div>') }}
						</div>
					</div>
					<div class="mws-form-col-2-8">
						{{ Form::label('facebookgroup', 'Facebook Group') }}
						<div class="mws-form-item large">
							{{ Form::text('facebookgroup',$chapter->facebookgroup, array('class' => 'mws-textinput')) }}
							{{ $errors->first('facebookgroup', '<div class="mws-error">:message</div>') }}
						</div>
					</div>
					<div class="mws-form-col-2-8">
						{{ Form::label('gpluspage', 'Google + Page') }}
						<div class="mws-form-item large">
							{{ Form::text('gpluspage',$chapter->gpluspage, array('class' => 'mws-textinput')) }}
							{{ $errors->first('gpluspage', '<div class="mws-error">:message</div>') }}
						</div>
					</div>
					<div class="mws-form-col-2-8 omega">
						{{ Form::label('gplusgroup', 'Google + Group') }}
						<div class="mws-form-item large">
							{{ Form::text('gplusgroup',$chapter->gplusgroup, array('class' => 'mws-textinput')) }}
							{{ $errors->first('gplusgroup', '<div class="mws-error">:message</div>') }}
						</div>
					</div>

				</div>
			</div>
			<div class="mws-form-row">
				<div class="mws-form-cols">

					<div class="mws-form-col-2-8 alpha">
						{{ Form::label('twitter', 'Twitter') }}
						<div class="mws-form-item large">
							{{ Form::text('twitter',$chapter->twitter, array('class' => 'mws-textinput')) }}
							{{ $errors->first('twitter', '<div class="mws-error">:message</div>') }}
						</div>
					</div>
					<div class="mws-form-col-2-8">
						{{ Form::label('woied', 'WOIED') }}
						<div class="mws-form-item large">
							{{ Form::text('woied',$chapter->woied, array('class' => 'mws-textinput')) }}
							{{ $errors->first('woied', '<div class="mws-error">:message</div>') }}
						</div>
					</div>
					<div class="mws-form-col-2-8">
						{{ Form::label('unlocode', 'UN/Locode') }}
						<div class="mws-form-item large">
							{{ Form::text('unlocode',$chapter->unlocode, array('class' => 'mws-textinput')) }}
							{{ $errors->first('unlocode', '<div class="mws-error">:message</div>') }}
						</div>
					</div>
					<div class="mws-form-col-2-8 omega">
						{{ Form::label('localcode', 'National Code (IBGE)') }}
						<div class="mws-form-item large">
							{{ Form::text('localcode',$chapter->localcode, array('class' => 'mws-textinput')) }}
							{{ $errors->first('localcode', '<div class="mws-error">:message</div>') }}
						</div>
					</div>
				</div>
			</div>

			<div class="mws-button-row">
				{{ Form::submit('Save', array('class' => 'btn btn-danger')); }}
			</div>
		{{ Form::close() }}
	</div>
</div>
@stop

@section('scripts')
<script>
$(function(){
	$.fn.iButton && $(".ibutton").iButton();
});
</script>
@stop