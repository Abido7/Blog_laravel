@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row    d-flex flex-row align-items-center">
            <div class="col-12">
                <h2>{{ $user->name }} Posts</h2>
                @forelse ($user->posts as $post)
                    <div class="card w-75  m-3 m-auto">
                        <div class=" card-header d-flex flex-row align-items-center ">
                            <div class="col-6 d-flex flex-row align-items-center">
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
                                <div class="col-12">
                                    <div class="d-flex flex-row justify-content-start align-items-center p-3">
                                        {{-- @forelse ($post->images as $image) --}}
                                        <img class="rounded w-100" src="{{ asset("uploads/$image->img") }}" alt="">
                                        {{-- @endforelse --}}
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
                @endforelse
            </div>
        </div>
    </div>
@endsection
