@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="padding: 10px;">
                    <div class="card-header">Forum Thread</div>

                    <div class="card-section">
                        @foreach($threads as $thread)

                            <article>
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

                            </article>
                            <div class="body">
                                {{$thread->body}}
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
