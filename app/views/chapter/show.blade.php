@extends('templates.main')
@section('content')
@include('chapter.top')


<div class="mws-panel grid_6 mws-collapsible">
	<div class="mws-panel-header">
		<span><b>{{ $chapter->name }} : Info</b></span>
		<div class="mws-collapse-button mws-inset"><span></span></div>
	</div>
	@if ($usercoordchap)
	<div class="mws-panel-toolbar">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ URL::to('chapter/edit/'.$chapter->id) }}" class="btn"><i class="icol-pencil"></i> {{ trans('general.edit') }}</a>
			</div>
		</div>
	</div>
	@endif
	<div class="mws-panel-body">
		
		<div class="mws-panel-content" style="height: 127px;" >
			<div class="grid_4">
				<div>Abbr: <b>{{ $chapter->abbr }}</b></div>
				<div>Website: <b><a href="{{ $chapter->website }}" target="_blank">{{ $chapter->website }}</a></b></div>
				<div>Facebook Page: <b><a href="{{ $chapter->facebookpage }}" target="_blank">{{ $chapter->facebookpage }}</a></b></div>
				<div>Facebook Group: <b><a href="{{ $chapter->facebookgroup }}" target="_blank">{{ $chapter->facebookgroup }}</a></b></div>
				<div>Google+ Page: <b><a href="{{ $chapter->gpluspage }}" target="_blank">{{ $chapter->gpluspage }}</a></b></div>
				<div>Google+ Group: <b><a href="{{ $chapter->gplusgroup }}" target="_blank">{{ $chapter->gplusgroup }}</a></b></div>
				<div>Twitter: <b><a href="{{ $chapter->twitter }}" target="_blank">{{ $chapter->twitter }}</a></b></div>
			</div>
			<div class="grid_2">
				<div>Chap Status: <b>{{ ($chapter->enabled?'<span style="color:green">Ative</span>':'<span style="color:brown">Unactive</span>') }}</b></div>
				<div>Coordenator: 
					@if(@$chapter->coordinators[0]->name)
						<b>
							@if($usercoordchap)
								<a href="{{ @$chapter->coordinators[0]->fblink }}" target="_blank">{{ @$chapter->coordinators[0]->name }}</a>
							@else
								{{ @$chapter->coordinators[0]->name }}
							@endif
						</b>
					@elseif ($chapter->id == 1)
					
					@elseif ($userrole)
						<a href="{{ URL::to('chapter/requestcoord/'.$chapter->id) }}" type="button" class="btn btn-success btn-small">Desejo coordenar este capítulo.</a>
					@else
						Você pode requisitar para coordenar este capítulo, mas primeiro precisa se tornar um membro dele.
					@endif
					
					
				
				</div>
			
			</div>
			<div class="grid_1">
				<div><b>Indentification</b></div>
				<div>WOIED: <b>{{ $chapter->woied }}</b></div>
				<div>UN/Locode: <b>{{ $chapter->unlocode }}</b></div>
				<div>Local Code: <b>{{ $chapter->localcode }}</b></div>
			</div>
		</div>
	</div>
</div>

<div class="mws-panel grid_2">
	<div class="mws-panel-header">
		<span><b><i class="icon-book"></i> {{ trans('chapter.statusonchap') }}</b></span>
	</div>
	<div class="mws-panel-body no-padding">
		<ul class="mws-summary clearfix">
			<li>
				<span class="key"><i class="icon-certificate"></i> {{ trans('chapter.myrole') }}</span>
				<span class="val" style="overflow: visible;">
					<span class="text-nowrap">
						<div class="btn-group">
							<button type="button" class="btn btn-small"{{ ($userrole && $userrole->name!='member'?'disabled':'') }}>
								@if($userrole)
									{{ trans('chapter.'.$userrole->name) }}
								@else
									{{ trans('chapter.norole') }}
								@endif
							</button>

							@unless($userrole && $userrole->name!='member')
							<button type="button" class="btn btn-small dropdown-toggle " data-toggle="dropdown"><span class="caret"></span></button>
							<ul class="dropdown-menu pull-right">
									<li class="becomemember {{ ($userrole?'hide':'') }}"><a href="#">{{ trans('chapter.becomemember') }}</a></li>
									<li class="removemembership {{ ($userrole?'':'hide') }}"><a href="#">{{ trans('chapter.removemembership') }}</a></li>
							</ul>
							@endif
						</div>

					</span>
				</span>
			</li>
			<li>
				<span class="key"><i class="icon-envelope"></i> {{ trans('chapter.subscription') }}</span>
				<span class="val">
					<span class="text-nowrap"><input class="ibutton subscription" type="checkbox" data-label-on="{{ trans('chapter.subscription_on') }}" data-label-off="{{ trans('chapter.subscription_off') }}" {{(Auth::user()->is_subscribed_to($chapter->id)?'checked':'')}}></span>
				</span>
			</li>
			
		</ul>
	</div>
</div>


<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span class="mws-i-24 i-table-1"><b>{{ $chapter->name }} : {{ trans('general.subchapters') }}</b></span>
	</div>
	<div class="mws-panel-body no-padding">
		<table class="mws-table">
			<thead>
				<tr>
					<th>{{ trans('general.chapter') }}</th>
					<th>Coordinator</th>
		
				</tr>
			</thead>
			<tbody>
			@foreach ($chapter->subchapters as $sub)
				<tr>
					<td>{{ HTML::link('chapter/view/'.$sub->id, $sub->name) }}</td>

					<td>@if($usercoordchap)
						<a href="{{ @$sub->coordinators[0]->fblink }}" target="_blank">{{ @$sub->coordinators[0]->name }}</a>
						@else
							{{ @$sub->coordinators[0]->name }}
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

<script>
$(function() {
	var subscriptionbt_loaded = false;

	$.fn.iButton && $(".ibutton.subscription").iButton({
		change: function ($input){
			if(subscriptionbt_loaded){
				change_subscription(($input.is(':checked')?'get':'remove'));
			}
			subscriptionbt_loaded = true;
		}
	}).trigger("change");

	$('.becomemember').mouseup(function() {
		change_membership('get');		
	});
	$('.removemembership').mouseup(function() {
		change_membership('remove');
	});

	/*$('.subscription').mouseup(function() {
	log.console('sasad');
		log.console($(this).is(':checked'));
		//change_subscription(($(this).is(':checked')?'':''));
	});*/

	function change_membership ( act){
		$.post("{{ URL::to('chapter/membership/'.$chapter->id) }}", { action: act })
			.done(function (data){
				if(data){
					location.reload();
				}});
	}

	function change_subscription ( act){
		$.post("{{ URL::to('chapter/subscription/'.$chapter->id) }}", { action: act });
	}
});
</script>

@stop