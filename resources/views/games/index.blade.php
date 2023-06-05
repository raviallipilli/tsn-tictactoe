@extends('layouts.app')
@section('content')

    <!-- List of of all stats -->
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('The players') }}</th>
                <th scope="col">{{ __('Number of games') }}</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($games as $game)
            <tr>
                <th scope="row">{{ $game->id }}</th>
                <td>{{ ucfirst($game->first_player_name) }} | {{ ucfirst($game->second_player_name) }}</td>
                <td>{{ $game->countGameRounds() }}</td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <!-- end of list -->
    <hr>
    <!-- redirect buttons -->
    <div class="row">
        <div class="col text-center">

            {{ link_to_route('games.create', __('New game'), [], ['class' => 'btn btn-success btn-block mb-3']) }}

        </div>
        <div class="col text-center">

            {!! Form::open(['route' => 'gameRounds.store', 'method' => 'post']) !!}
            {!! Form::hidden('game_id', $game->id) !!}
            {!! Form::submit(__('Play again'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div>
    </div>
    <!-- end of redirects -->
@endsection
