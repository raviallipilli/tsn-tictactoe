@extends('layouts.app')
@section('content')

    <!-- player names -->
    <div class="text-center font-italic f-size-1-5 mb-3">
        {{ ucfirst($game->first_player_name) }} {{ __('vs') }} {{ ucfirst($game->second_player_name) }}
    </div>
    <!-- end of player names -->
    <!-- display if errors -->
    @if ($errors->any())

        <div class="alert alert-danger" role="alert">
            <p class="mb-0">{{ __('Errors') }}</p>
            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>
        </div>

    @endif
    <!-- end of errors -->
    <!-- check if the game has started -->
    @if (empty($prepareData['gameHistories']))
        <div class="text-center">
            {{ __('Start the game') }}
        </div>
    @endif
    <!-- end of check -->
    <!-- if game has ended, display the winner with result -->
    @if ($isFullGameField || $prepareData['gameOver'])

        <div class="text-center">
            {{ __('The game is over') }}
        </div>

        @if ($prepareData['playerWinner'])
            <div class="text-center f-size-2">
           "{{ ($game::getPlayerTypes($firstPlayerType) === $game::getPlayerTypes($prepareData['playerWinner']) ) ? ucfirst($game->first_player_name) : ucfirst($game->second_player_name) }}" {{ __('is the Winner') }}
            </div>
        @else
            <div class="text-center f-size-2">
                {{ __('A draw') }}
            </div>
        @endif
    <!-- end of results -->
    <!-- else if no winner keep continue the game -->
    @else

        @if ($prepareData['playerType'] && $prepareData['playerType'] === $firstPlayerType)
            <div class="d-flex align-items-center justify-content-center">
                <div>@if ($prepareData['playerType'] && $prepareData['playerType'] === $firstPlayerType) {{ $game->second_player_name }}'{{ __('s turn') }} @endif&nbsp;</div>
                <div class="mb-2 f-size-2">{{ $game::getPlayerTypes($secondPlayerType) }}</div>
            </div>
        @endif

        @if ($prepareData['playerType'] && $prepareData['playerType'] === $secondPlayerType)
            <div class="d-flex align-items-center justify-content-center">
            <div>@if ($prepareData['playerType'] && $prepareData['playerType'] === $secondPlayerType) {{ $game->first_player_name }}'{{ __('s turn') }} @endif&nbsp;</div>
                <div class="mb-2 f-size-2">{{ $game::getPlayerTypes($firstPlayerType) }}</div>
            </div>
        @endif

    @endif
    <!-- end of game check -->
    <!-- the game logic begins here -->
    <div class="ttt-content mt-3">

        @for ($row = 1; $row <= $gameSize; $row++)
            <div class="d-flex justify-content-center ttt-row">

                @for ($col = 1; $col <= $gameSize; $col++)
                    <div class="align-self-center ttt-col">

                        @if (isset($prepareData['gameHistories'][$row][$col]))

                            <div class="ttt-element">

                                @if ($prepareData['horizontalSuccess'][$row] ?? null)
                                    <div class="line"></div>

                                @elseif($prepareData['verticalSuccess'][$col] ?? null)
                                    <div class="line rotate-90"></div>

                                @elseif ($prepareData['diagonalRightSuccess'][$row][$col] ?? null)
                                    <div class="line rotate-135"></div>

                                @elseif ($prepareData['diagonalLeftSuccess'][$row][$col] ?? null)
                                    <div class="line rotate-45"></div>
                                @endif

                                {{  $game::getPlayerTypes($prepareData['gameHistories'][$row][$col]) }}

                            </div>

                        @else

                            <div class="ttt-element">

                                @if (! $prepareData['gameOver'])

                                    {!! Form::open(['route' => 'gameHistories.store', 'method' => 'post']) !!}
                                    {!! Form::hidden('game_id', $game->id) !!}
                                    {!! Form::hidden('game_round_id', $round) !!}
                                    {!! Form::hidden('game_row', $row) !!}
                                    {!! Form::hidden('game_column', $col) !!}

                                    @if (! $prepareData['playerType'])
                                        {!! Form::hidden('player_type', $firstPlayerType) !!}
                                    @endif

                                    @if ($prepareData['playerType'] && $prepareData['playerType'] === $firstPlayerType)
                                        {!! Form::hidden('player_type', $secondPlayerType) !!}
                                    @endif

                                    @if ($prepareData['playerType'] && $prepareData['playerType'] === $secondPlayerType)
                                        {!! Form::hidden('player_type', $firstPlayerType) !!}
                                    @endif

                                    {!! Form::submit('', ['class' => 'btn btn-link btn-block']) !!}
                                    {!! Form::close() !!}

                                @endif

                            </div>

                        @endif

                    </div>
                @endfor

            </div>
        @endfor

    </div>
    <!-- game ends with results and player moves -->
    <hr>
    <!-- redirect buttons start -->
    <div class="row">
        <div class="col-sm text-center pb-3">

            {!! Form::open(['route' => 'gameRounds.store', 'method' => 'post']) !!}
            {!! Form::hidden('game_id', $game->id) !!}
            {!! Form::submit(__('Play again'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div>
        <div class="col-sm text-center pb-3">

            {{ link_to_route('games.create', __('New game'), [], ['class' => 'btn btn-success']) }}

        </div>
        <div class="col-sm text-center pb-3">

            {{ link_to_route('games.index', __('Statistics'), [], ['class' => 'btn btn-info']) }}

        </div>
    </div>
    <!-- redirect end -->
@endsection
