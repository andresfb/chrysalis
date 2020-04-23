@extends('layouts.auth')

@section('content')
    <ul>
        @forelse ($projects as $project)
            <li>{{ $project->title }}</li>
        @empty
            <p>No projects</p>
        @endforelse
    </ul>
@stop
