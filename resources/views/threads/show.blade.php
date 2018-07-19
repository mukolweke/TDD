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
    </div>
@endsection
