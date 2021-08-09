@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach ($followings as $member)
                    <div class="card w-100 ">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex flex-row justify-content-start align-items-center">
                                        <a href="{{ url("user/$member->id") }}">

                                            <img width="50px" class="rounded-circle"
                                                src="{{ asset("uploads/$member->img") }}" alt="">
                                        </a>
                                        <h2 class=" px-2">{{ $member->name }}</h2>
                                    </div>
                                </div>
                                <div class="col-6 d-flex flex-row justify-content-end align-items-center">
                                    <form action="{{ url("user/unfollow/$member->id") }}" method="POST"
                                        style="display:none" id="unfollow">
                                        @csrf
                                    </form>
                                    <button type="submit" form="unfollow" class="btn btn-secondary">
                                        UnFollow
                                    </button>
                                </div>
                            </div>
                        </div>
                        @foreach ($member->posts as $post)
                            @foreach ($post->images as $image)
                                <div class="card-body ">
                                    <img class="rounded card-img w-50" src="{{ asset("uploads/$image->img") }}" alt="">
                                    <p class="card-text text-muted mt-2 ">{{ $post->caption }}.</p>
                                </div>
                            @endforeach
                            <div class="card">
                                <?php $user = $post->comments[0]->user; ?>

                                <div class="card-header">
                                    <a class="text-light text-decoration-none d-flex flex-row align-items-center"
                                        href="{{ url("user/$user->id") }}">
                                        <img width="30px" class="rounded-circle m-2"
                                            src="{{ asset("uploads/$user->img") }}" alt="">
                                        <p class="text-center text-info"> {{ $post->comments[0]->user->name }}</p>
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
                        @endforeach
                        <hr>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
