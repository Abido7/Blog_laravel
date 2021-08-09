@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row    d-flex flex-row align-items-center">
            <div class="col-12">

                @foreach ($followings as $member)
                    <div class="card mt-2">
                        <div class=" card-header d-flex flex-row align-items-center ">
                            <div class="col-6 d-flex flex-row align-items-center">
                                <img width="50" class="rounded-circle" src="{{ asset("uploads/$member->img") }}" alt="">
                                <h4 class="mx-1">{{ $member->name }}</h4>
                            </div>
                            <div class="col-6 d-flex flex-row justify-content-end align-items-center">
                                <form action="{{ url("member/unfollow/$member->id") }}" method="POST" style="display:none"
                                    id="unfollow">
                                    @csrf
                                </form>
                                <button type="submit" form="unfollow" class="btn btn-secondary">
                                    UnFollow
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-2 bg-secondary text-light">
                            <h5 class="card-title">Bio</h5>
                            <p class="card-text"> {{ $member->bio }}</p>
                        </div>
                    </div>

                @endforeach


                {{-- @foreach ($member->posts as $post)
                    <div class="card w-75  m-3 m-auto">
                        <div class=" card-header d-flex flex-row align-items-center ">
                            <div class="col-4 d-flex flex-row align-items-center">
                                <img width="50" class="rounded-circle" src="{{ asset("uploads/$user->img") }}" alt="">
                                <h4 class="mx-1">{{ $user->name }}</h4>
                            </div>
                            <div class="col-4 d-flex flex-row align-items-center">
                                <p class="mx-1">
                                    <a class="text-muted text-decoration-none" href="{{ url("followings/$user->id") }}">
                                        Following ({{ $followings->count() }})
                                    </a>
                                </p>
                            </div>
                            <div class="col-4 d-flex flex-row justify-content-end align-items-center">
                                <form action="{{ url("user/unfollow/$user->id") }}" method="POST" style="display:none"
                                    id="unfollow">
                                    @csrf
                                </form>
                                <button type="submit" form="unfollow" class="btn btn-danger">
                                    Delete Post
                                </button>
                            </div>
                        </div>
                        <div class="card-title m-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-row justify-content-start align-items-center p-3">
                                        @foreach ($post->images as $image)
                                            <img class="rounded w-100" src="{{ asset("uploads/$image->img") }}" alt="">
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body py-0">
                            <p class="card-text">{{ $post->caption }}.</p>
                        </div>

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
                                    <p class="mx-3">
                                        {{ \Carbon\Carbon::parse($post->comments[0]->created_at)->diffForHumans(now()) }}
                                    </p>
                                </div>
                            </div>
                            <a class="text-light text-decoration-none" href="{{ url("post/$post->id") }}">
                                <p class="text-muted my-1">Comments..</p>
                            </a>
                        </div>
                    </div>
                @endforeach --}}
            </div>
        </div>
    </div>
@endsection
