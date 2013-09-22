@extends('templates.main')
@section('content')
@include('user.top')

<div class="mws-panel grid_8 mws-collapsible">
	<div class="mws-panel-header">
		<span><i class="icon-users"></i> {{ trans('general.users') }}</span>
	</div>
	<div class="mws-panel-toolbar">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ URL::to('user/new') }}" class="btn"><i class="icol-add"></i> {{ trans('general.add') }}</a>
			</div>
		</div>
	</div>
	<div class="mws-panel-body no-padding">
	
		<table class="mws-table">
			<thead>
				<tr>
					
					<th>{{ trans('general.name') }}</th>
					<th>Members</th>
					<th>Email Subscribbers</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($users as $user)
				<tr class="even">
					
					<td>
						{{ HTML::link('user/'.$user->id.'/edit', $user->name) }}
					</td>
					<td></td>
					<td></td>
				</tr>
			@endforeach

			</tbody>
		</table>
	</div>
</div>

@stop