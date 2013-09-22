@extends('templates.main')
@section('content')
@include('chapter.top')



<div class="mws-panel grid_8 mws-collapsible">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-table-1"><b>{{ $chapter->name }} : {{ trans('general.members') }}</b></span>
	</div>
	<div class="mws-panel-body no-padding">
		<table class="mws-table">
			<thead>
				<tr>
					<th>{{ trans('general.name') }}</th>
					<th>Roles</th>
				
				</tr>
			</thead>
			<tbody>
			@foreach ($users as $user)
				<tr class="">
					<td><a href="{{ $user->fblink }}" target="_blank">{{ $user->name }}</a</td>

					<td>
						@if ($caneditrole)
							{{ Form::select('userrole_'+$user->id, $chaprole, $user->pivot->chapterrole_id, array('class'=>'userrole','userid'=>$user->id,'orig'=>$user->pivot->chapterrole_id)) }}
							<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only saverolebt" role="button" aria-disabled="false" title="Button with icon only" id="saverole_{{ $user->id }}" userid="{{ $user->id }}" style="display: none;"><span class="ui-button-icon-primary icol-accept"></span></button>
							
						@else
							{{ $chaprole[$user->pivot->chapterrole_id] }}
						@endif
					</td>
			
				</tr>
			@endforeach

			</tbody>
		</table>
		
	</div>
</div>

@stop




@section('scripts')
@if ($caneditrole)
<script>
$(function(){
	$('select.userrole').change(function() {
		var savebutton = $('#saverole_'+$(this).attr('userid'));

		if($(this).val()==$(this).attr('orig')){
			savebutton.hide();
		} else {
			savebutton.show();
		}
	});
	$('.saverolebt').mouseup(function() {

		var dropdown = $('.userrole[userid='+$(this).attr('userid')+']');
		var savebt = $(this);
		$.post("{{ URL::to('chapter/users/'.$chapter->id) }}", { userid: $(this).attr('userid'), changerole: dropdown.val() })
			.done(function(data) {
				if(data){
					savebt.hide();
					dropdown.attr('orig',dropdown.val());
				}
			});
	});
});
</script>
@endif
@stop
