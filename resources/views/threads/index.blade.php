@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @forelse($threads as $thread)

                    <div class="panel panel-default" style="padding: 10px;">
                        <div class="panel-heading">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{$thread->path()}}">
                                        @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))

                                            <strong>
                                                {{$thread->title}}
                                            </strong>

                                        @else

                                            {{$thread->title}}

                                        @endif
                                    </a>
                                </h4>

                                <strong>
                                    <a href="{{$thread->path()}}">
                                        {{$thread->replies_count}} {{str_plural('reply', $thread->replies_count)}}
                                    </a>
                                </strong>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="body">
                                {{$thread->body}}
                            </div>
                        </div>
                    </div>

                @empty
                    <p>There are no relevant records aat this time</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection


