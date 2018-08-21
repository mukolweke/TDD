<div id="reply-{{$reply->id}}" class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="/profiles/{{$reply->owner->name}}">{{$reply->owner->name}}</a>
                said {{ $reply->created_at->diffForHumans() }} ...

            </h5>
            .
            <div>
                <form method="post" action="/replies/{{$reply->id}}/favourites">

                    {{csrf_field()}}

                    <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{$reply->favourites_count}}{{str_plural(' like', $reply->favourites_count)}}
                    </button>

                </form>
            </div>
        </div>
    </div>

    <div class="panel-body">
        {{$reply->body}}
    </div>

    @can('update', $reply)
        <div class="panel-footer">
            <form action="/replies/{{$reply->id}}" method="POST">
                {{csrf_field()}}
                {{method_field("DELETE")}}

                <button class="btn btn-danger btn-xs">DELETE</button>
            </form>
        </div>
    @endcan
</div>
