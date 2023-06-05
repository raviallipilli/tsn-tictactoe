@extends('layouts.app')
@section('content')
    <!-- redirect to create player names page -->
    <div class="text-center">

        {{ link_to_route('games.create', __('Start the game'), [], ['class' => 'btn btn-primary btn-lg']) }}

    </div>
    <!-- end of redirect -->
@endsection
