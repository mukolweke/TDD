<div class="card" style="padding: 10px;margin-bottom: 20px;">
    <div class="card-header">
        <a href="#">{{$reply->owner->name}}</a>   said  {{ $reply->created_at->diffForHumans() }} ...
    </div>

    <div class="card-section">
        {{$reply->body}}
    </div>
</div>