@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-4">
                <img class="rounded w-100 " src="{{ asset("uploads/$user->img") }}" alt="">
            </div>
            <div class="col-md-8">
                <div class="bg-secondary  text-light rounded">
                    <p class="p-2">Bio</p>
                    <p class=" px-4">{{ $user->bio }}</p>
                    <div class="d-flex justify-content-start">
                        <p class="mx-1">
                            <a class="text-light text-decoration-none" href="{{ url("followings/$user->id") }}">
                                Following ({{ $user->followings->count() }})
                            </a>
                        </p>
                        <p class="mx-2">
                            <a class="text-light text-decoration-none" href="{{ url("followers/$user->id") }}">
                                Followers ({{ $followers }})
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row    d-flex flex-row align-items-center">
            <div class="col-12">
                <h2>{{ $user->name }} Posts</h2>

                @forelse ($posts as $post)
                    <div class="card w-75  m-3 m-auto">
                        <div class=" card-header d-flex flex-row align-items-center ">
                            <div class="col-6 d-flex flex-row align-items-center">
                                <img width="50" class="rounded-circle" src="{{ asset("uploads/$user->img") }}" alt="">
                                <h4 class="mx-1">{{ $user->name }}</h4>
                            </div>
                            <div class="col-6 d-flex flex-row justify-content-end align-items-center">
                                @if (in_array($user->id, $authFollowings))

                                    <button type="button" form="unfollow-form" class="btn btn-secondary"
                                        onclick="unfollow(<?= $user->id ?>);">
                                        UnFollow
                                    </button>
                                @else
                                    <button type="button" form="follow-form" class="btn btn-secondary"
                                        onclick="addFollow(<?= $user->id ?>);">
                                        Follow
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-title m-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-row justify-content-start align-items-center p-3">
                                        @forelse ($post->images as $image)
                                            @if (count($post->images) <= 1)

                                                <img class="rounded w-100" src="{{ asset("uploads/$image->img") }}"
                                                    alt="">
                                            @else
                                                <img class="rounded" style="max-width: 50%"
                                                    src="{{ asset("uploads/$image->img") }}" alt="">
                                            @endif
                                        @empty
                                        @endforelse
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body py-0">
                            <p class="card-text">{{ $post->caption }}.</p>
                        </div>
                        @if (isset($post->comments[0]))
                            <div class="card">
                                <div class="card-header">
                                    <?php $CommentUser = $post->comments[0]->user; ?>
                                    <a class="text-light text-decoration-none d-flex flex-row align-items-center"
                                        href="{{ url("user/$CommentUser->id") }}">
                                        <img width="30px" class="rounded-circle m-2"
                                            src="{{ asset("uploads/$CommentUser->img") }}" alt="">
                                        <p class="text-center text-info"> {{ $CommentUser->name }}</p>
                                    </a>
                                </div>
                                <div class="card-body border-2 bg-secondary text-light">
                                    <div class="commet-body d-flex flex-row justify-content-between ">
                                        <a class="text-light text-decoration-none" href="{{ url("post/$post->id") }}">
                                            <p class="mx-3">{{ $post->comments[0]->body }}</p>
                                        </a>
                                        <p class="mx-3 my-0 p-0">
                                            <?php $totalDuration = \Carbon\Carbon::parse($post->comments[0]->created_at)->DiffInMinutes(now()); ?>
                                            {{ Carbon\CarbonInterval::minutes($totalDuration)->cascade()->forHumans() }}
                                        </p>
                                    </div>
                                </div>


                            </div>

                        @else
                            <div class="card mb-4">
                                <div class="card-header">
                                    <p>no comments</p>
                                </div>
                                <a class="text-light text-decoration-none" href="{{ url("post/$post->id") }}">
                                    <p class="text-muted my-1">Comments..</p>
                                </a>
                            </div>
                        @endif

                    </div>
                @empty
                    <p class="h1 d-flex justify-content-center my-5 text-danger">User Not Had Any Posts</p>
                @endforelse
            </div>
        </div>


    </div>
@endsection
