@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{$thread->replies_count}}" inline-template>

        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="card" style="padding: 10px;margin-bottom: 20px;">

                        <div class="card-header">
                            <div class="level">
                            <span class="flex">
                                <a href="/profiles/{{$thread->creator->name}}">{{$thread->creator->name}}</a> posted:
                                {{ $thread->title }}

                            </span>

                                @can('update', $thread)
                                    <form action="{{$thread->path()}}" method="POST">
                                        {{csrf_field()}}

                                        {{method_field('DELETE ')}}

                                        <button type="submit" class="btn btn-danger btn-xs">DELETE THREAD</button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="card-section" style="padding: 20px;">
                            {{$thread->body}}
                        </div>

                    </div>

                    <replies :data="{{$thread->replies}}" @removed="repliesCount--"></replies>

                    @if(auth()->check())

                        <form method="POST" action="{{$thread->path().'/replies'}}">
                            {{csrf_field()}}
                            <div class="form-group">

                            <textarea name="body" id="body" rows="5" class="form-control"
                                      placeholder="Have something to say"></textarea>

                            </div>

                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>

                    @else

                        <p class="text-center">Please <a href="{{route('login')}}">sign</a> in please to participate on
                            the
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
                                <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count)}}.
                            </p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </thread-view>
@endsection
