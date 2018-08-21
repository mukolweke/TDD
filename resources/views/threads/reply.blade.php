<reply :attributes="{{$reply}}" inline-template v-cloak>
    <div id="reply-{{$reply->id}}" class="card" style="margin-bottom: 10px;">
        <div class="card-header">
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

        <div class="card-section" style="padding: 15px;">
            <div v-if="editing">
                <div class="form-group">
                    <textarea v-model="body" class="form-control"></textarea>
                </div>

                <button class="btn btn-xs btn-primary mr-1" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing=false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
            <div class="card-footer level">

                <button class="btn btn-xs mr-1" @click="editing=true">EDIT</button>
                <button class="btn btn-xs btn-danger mr-1" @click="destroy">DELETE</button>

            </div>
        @endcan
    </div>
</reply>