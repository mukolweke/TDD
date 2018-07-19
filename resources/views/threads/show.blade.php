@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="padding: 10px;">
                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-section">
                        {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
        @if(auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <form method="POST" action="{{$thread->path().'/replies'}}">
                        {{csrf_field()}}
                        <div class="form-group">

                            <textarea name="body" id="body" rows="5" class="form-control"
                                      placeholder="Have something to say"></textarea>

                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>

                </div>
            </div>
            @else
            <p class="text-center">Please <a href="{{route('login')}}">sign</a> in please to participate on the forum </p>
        @endif
    </div>
@endsection
