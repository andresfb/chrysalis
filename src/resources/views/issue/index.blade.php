@extends('layouts.auth')

@section('content')
    <ul>
        @forelse ($issues as $issue)
            <li>{{ $issue->title }}</li>
        @empty
            <p>No projects</p>
        @endforelse
    </ul>
@stop
