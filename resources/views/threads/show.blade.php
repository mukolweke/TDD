@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div class="card" style="padding: 10px;margin-bottom: 20px;">

                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-section">
                        {{$thread->body}}
                    </div>

                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                @if(auth()->check())

                    <form method="POST" action="{{$thread->path().'/replies'}}">
                        {{csrf_field()}}
                        <div class="form-group">

                            <textarea name="body" id="body" rows="5" class="form-control"
                                      placeholder="Have something to say"></textarea>

                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>

                @else

                    <p class="text-center">Please <a href="{{route('login')}}">sign</a> in please to participate on the
                        forum
                    </p>

                @endif

            </div>

            <div class="col-md-4">

                <div class="card" style="padding: 10px;margin-bottom: 20px;">

                    <div class="card-section">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{$thread->creator->name}}</a>, and currently has
                            {{$thread->replies_count}} {{ str_plural('comment', $thread->replies_count)}}.
                        </p>
                    </div>

                </div>

            </div>
        </div>


    </div>
@endsection
