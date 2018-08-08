@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($threads as $thread)

                    <div class="card" style="padding: 10px;">
                        <div class="card-header">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{$thread->path()}}">
                                        {{$thread->title}}
                                    </a>
                                </h4>

                                <strong>
                                    <a href="{{$thread->path()}}">
                                        {{$thread->replies_count}} {{str_plural('reply', $thread->replies_count)}}
                                    </a>
                                </strong>
                            </div>
                        </div>

                        <div class="card-section">

                            <div class="body">
                                {{$thread->body}}
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
@endsection
