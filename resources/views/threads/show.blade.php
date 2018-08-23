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

                    <replies
                             @added="repliesCount++"
                             @removed="repliesCount--"></replies>

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
