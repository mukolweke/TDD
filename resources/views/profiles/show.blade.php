@extends('layouts.app')


@section('content')

    <div class="container">

        <div class="grid-x">
            <div class="medium-offset-3 medium-8 columns">

                <div class="page-header">
                    <h1>

                        {{$profileUser->name}}

                    </h1>
                </div>


                @forelse($activities as $date => $activity)
                    <h3 class="page-header">{{$date}}</h3>
                    @foreach ($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.$record->type", ['activity'=>$record])
                        @endif
                    @endforeach

                @empty

                    <p>No Activity for thise user yet..</p>

                @endforelse

                {{--{{ $threads->links() }}--}}

            </div>
        </div>
    </div>

@endsection