/*@extends('templates.main')
@section('content')
	<table class="chapter">
    @foreach ($chapters as $chapter)
        <tr>
            <td>{{ HTML::link('chapter/view/'.$chapter->id, $chapter->name) }}</td>
           
            <td>{{ HTML::link('chapter/view/'.$chapter->id, 'Read more &rarr;') }}</td>
		</tr>
    @endforeach
	</table>

{{ $chapter->[1]->subchapters()->first()->name }}

@stop*/