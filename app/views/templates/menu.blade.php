<!--<div id="mws-nav-collapse">
                <span></span>
                <span></span>
                <span></span>
            </div>
<div id="mws-searchbox">
            
            </div>-->
<div id="mws-navigation">
	<ul>
		<li><a href="{{ URL::to('chapter/view/1') }}"><i class="icon-globe"></i> {{ trans('general.chapters') }}</a>
		
			<ul>
				@if(!Auth::guest())
					@foreach (Auth::user()->chapters as $chapter)
						<li><a href="{{ URL::to('chapter/view/'. $chapter->id ) }}">{{ $chapter->name}}</a></li>
					@endforeach
				@endif
			</ul>

		
		</li>
@if(!Auth::guest() && Auth::user()->has_role('admin'))
		<li><a href="{{ URL::to('user') }}"><i class="icon-users"></i> {{ trans('general.users') }}</a></li>
@endif

	</ul>
</div>