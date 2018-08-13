@extends('layouts.app')


@section('content')

    <div class="container">

        <div class="grid-x">
            <div class="medium-offset-3 medium-8 columns">

                <div class="page-header">
                    <h1>

                        {{$profileUser->name}}
                        <small>Since {{$profileUser->created_at->diffForHumans()}}</small>

                    </h1>
                </div>


                @foreach($threads as $thread)

                    <div class="card" style="padding: 10px;margin-bottom: 20px;">

                        <div class="card-header">

                            <div class="level">

                        <span class="flex">

                            <a href="{{route('profile', $thread->creator)}}">{{$thread->creator->name}}</a> posted:
                            <a href="{{$thread->path()}}">{{ $thread->title }}</a>

                        </span>

                                <span>

                            {{ $thread->created_at->diffForHumans() }}

                        </span>

                            </div>

                        </div>

                        <div class="card-section">
                            {{$thread->body}}
                        </div>

                    </div>

                @endforeach

                {{ $threads->links() }}

            </div>
        </div>
    </div>

@endsection