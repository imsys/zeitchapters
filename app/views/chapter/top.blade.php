<div class="chapter">
	
	<h4 class="grid_3">
		@if ( $chapter->parent_id )
			{{ HTML::link('chapter/view/'.$chapter->parent->id, '<< '. $chapter->parent->name) }}
		@endif
	</h4>
	
	<h1 class="grid_3" style="text-shadow: 1px 1px white;color: #40962F;">{{ HTML::link('chapter/view/'.$chapter->id, $chapter->name) }}</h1>

	<a class="mws-stat" {{ ((Auth::user()->has_role_on_chapter('coordinator', $chapter->id) || Auth::user()->has_role_on_chapter('subcoordinator', $chapter->id) || Auth::user()->has_role('admin'))? 'href="'. URL::to('chapter/users/'.$chapter->id) .'"' : '') }}>
		<span class="mws-stat-icon icol32-walk"></span>

		<!-- Statistic Content -->
		<span class="mws-stat-content">
			<span class="mws-stat-title">{{ trans('general.members') }}</span>
			<span class="mws-stat-value">{{ $chapter->users()->count() }}</span>
		</span>
	</a>

</div>
