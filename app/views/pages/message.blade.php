@extends('templates.main')
@section('body')
<div class="container" style="padding-top: 20px;">
      <div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-magic"></i> {{ $title }}</span>
                    </div>
                    <div class="mws-panel-body">
						{{ $msg }}
                    </div>
                </div>
    </div>
@stop