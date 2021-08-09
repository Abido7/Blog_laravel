@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 ">
                <form action="{{ url("post/add-Comment/$post->id") }}" style="display:none" method="POST"
                    id="comment-post">
                    @csrf
                </form>
                <div class="card w-100  m-3">
                    <div class="card-header d-flex flex-row align-items-center">
                        <div class="col-6 d-flex flex-row justify-content-cnter align-items-center">
                            <img width="50" class="rounded-circle" src="{{ asset("uploads/$user->img") }}" alt="">
                            <h4 class="mx-1">{{ $user->name }}</h4>
                        </div>

                        <div class="col-6 d-flex flex-row justify-content-end align-items-center">
                            <form action="{{ url("user/unfollow/$user->id") }}" method="POST" style="display:none"
                                id="unfollow">
                                @csrf
                            </form>
                            <button type="submit" form="unfollow" class="btn btn-secondary">
                                UnFollow
                            </button>
                        </div>
                    </div>
                    <div class="card-title m-0">
                        <div class="row">
                            <div class="col-md-6">
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
                        <div class="form-group d-flex flex-row align-items-center">
                            <label class="m-0 pr-2" for="">Comment</label>
                            <input type="text" class="form-control" placeholder="type Your Comment..." form="comment-post">
                        </div>
                    </div>

                    @foreach ($post->comments as $comment)

                        <div class="card">
                            <div class="card-header bg-secondary">
                                <?php $user = $comment->user; ?>
                                <a class="text-light text-decoration-none d-flex flex-row align-items-center"
                                    href="{{ url("user/$user->id") }}">
                                    <img width="30px" class="rounded-circle m-2" src="{{ asset("uploads/$user->img") }}"
                                        alt="">
                                    <p class="text-center text-light"> {{ $user->name }}</p>
                                </a>
                            </div>
                            <div class="card-body border-2 bg-secondary text-light">
                                <div class="commet-body d-flex flex-row justify-content-between ">
                                    <a class="text-light text-decoration-none" href="{{ url("post/$post->id") }}">
                                        <p class="mx-3">{{ $comment->body }}</p>
                                    </a>
                                    <p class="mx-3">
                                        {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans(now()) }}
                                    </p>
                                </div>
                                <form action="{{ url("post/add-Comment/$comment->id") }}" style="display:none"
                                    method="POST" id="comment-comment">
                                    @csrf
                                </form>
                                <div class="form-group d-flex flex-row align-items-center">
                                    <label class="m-0 pr-2" for="">Comment</label>
                                    <input type="text" class="form-control" placeholder="type Your Comment..."
                                        form="comment-comment">
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
