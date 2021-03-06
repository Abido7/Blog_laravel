@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                {{-- <form action="{{ url('unfollow') }}" method="POST" style="display:none" id="unfollow-form">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="unfollowed" id="hidden-id">
                </form> --}}
                @forelse ($user->followings as $member)
                    @forelse ($member->posts as $post)
                        <div class="card w-75 mx-auto my-3 p-2">
                            <div class="row">
                                <div class="col-6">
                                    <a class="text-decoration-none d-flex flex-row justify-content-start align-items-center"
                                        href="{{ url("profile/$member->id") }}">
                                        <img width="50px" class="rounded-circle" src="{{ asset("uploads/$member->img") }}"
                                            alt="">
                                        <h2 class=" px-2">{{ $member->name }}</h2>
                                    </a>
                                </div>
                                <div class="col-6 d-flex flex-row justify-content-end align-items-center">

                                    <button type="button" form="unfollow-form" class="btn btn-secondary"
                                        onclick="unfollow(<?= $member->id ?>)">
                                        UnFollow
                                    </button>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex flex-row justify-content-start align-items-center p-3">
                                    @forelse ($post->images as $image)
                                        @if (count($post->images) <= 1)

                                            <img class="rounded w-75 m-auto" src="{{ asset("uploads/$image->img") }}"
                                                alt="">
                                        @else
                                            <img class="rounded" style="max-width: 50%"
                                                src="{{ asset("uploads/$image->img") }}" alt="">
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                            <div class="card-body py-0">
                                <p id="test" class="card-text">{{ $post->caption }}.</p>


                            </div>
                            @if (isset($post->latestComment))
                                @php
                                    $CommentUser = $post->latestComment->user;
                                @endphp
                                @if (isset($CommentUser))
                                    <div class="card-footer d-flex w-100 justify-content-between align-items-center">
                                        <a class="text-light text-decoration-none d-flex flex-row align-items-center"
                                            href="{{ url("profile/$CommentUser->id") }}">
                                            <img width="30px" class="rounded-circle m-2"
                                                src="{{ asset("uploads/$CommentUser->img") }}" alt="">
                                            <p class="text-center text-info m-0"> {{ $CommentUser->name }}</p>
                                            <a class="text-dark text-decoration-none" href="{{ url("post/$post->id") }}">
                                                <p class="mx-3 p-0">{{ $post->latestComment->body }}</p>
                                            </a>
                                        </a>
                                        <p class="mx-3 my-0 p-0">
                                            <?php $totalDuration = \Carbon\Carbon::parse($post->latestComment->created_at)->DiffInMinutes(now()); ?>
                                            {{ Carbon\CarbonInterval::minutes($totalDuration)->cascade()->forHumans() }}
                                        </p>
                                    </div>

                                @endif
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
                        <p class="h1 d-flex justify-content-center my-5 text-danger">No Posts Here :(</p>
                    @endforelse
            </div>
        @empty
            <p class="h1 d-flex justify-content-center align-items-center my-5 text-danger"> you had no followings :(
            </p>
            @endforelse
        </div>
    </div>
    <script>
        // function unfollow(id, e) {
        //     event.preventDefault();
        //     document.getElementById('hidden-id').setAttribute('value', id);
        //     document.getElementById('unfollow-form').submit();
        // }


        // $("#test").click(function() {
        //     alert("The paragraph was clicked.");
        // });
    </script>
    </div>
@endsection
