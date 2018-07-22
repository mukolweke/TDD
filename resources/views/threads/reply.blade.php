<div class="card" style="padding: 10px;margin-bottom: 20px;">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="#">{{$reply->owner->name}}</a>
                said  {{ $reply->created_at->diffForHumans() }} ...

            </h5>

            <div>
                <form method="post" action="/replies/{{$reply->id}}/favorites">

                    {{csrf_field()}}

                    <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{$reply->favorites()->count()}}{{str_plural(' like', $reply->favorites()->count())}}
                    </button>

                </form>
            </div>
        </div>
    </div>

    <div class="card-section">
        {{$reply->body}}
    </div>
</div