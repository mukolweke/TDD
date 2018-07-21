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
                                <h4>
                                    <a href="/threads/{{$thread->channel->slug}}/{{$thread->id}}">{{$thread->title}}</a>
                                </h4>
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
