<div class="card" style="padding: 10px;margin-bottom: 20px;">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="/profiles/{{$reply->owner->name}}">{{$reply->owner->name}}</a>
                said {{ $reply->created_at->diffForHumans() }} ...

            </h5>
.            <div>
                <form method="post" action="/replies/{{$reply->id}}/favourites">

                    {{csrf_field()}}

                    <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{$reply->favourites_count}}{{str_plural(' like', $reply->favourites_count)}}
                    </button>

                </form>
            </div>
        </div>
    </div>

    <div class="card-section">
        {{$reply->body}}
    </div>
</div>
