@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-12">
                <div class="bg-secondary text-light" style="border-radius: 50% 0% 0% 50% !important;">
                    <div class="row">

                        <div class="col-4">
                            <img class="w-100" style="border-radius: 50%;" src="{{ asset("uploads/$user->img") }}" alt="">

                        </div>
                        <div class="col-8 d-flex flex-column justify-content-center align-items-center">
                            <div class="p-2 w-100 ">
                                <h2 class="h3">{{ $user->name }}</h2>
                                <p class="">Bio</p>
                                <p class="">{{ $user->bio }}</p>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex justify-content-start">
                                        <p class="mx-1">
                                            <a class="text-light text-decoration-none"
                                                href="{{ url("followings/$user->id") }}">
                                                Following ({{ $user->followings->count() }})
                                            </a>
                                        </p>
                                        <p class="mx-2">
                                            <a class="text-light text-decoration-none"
                                                href="{{ url("followers/$user->id") }}">
                                                Followers ({{ $user->followers->count() }})
                                            </a>
                                        </p>
                                    </div>
                                    <div>
                                        @if (Auth::user()->role->name == 'admin')

                                            {{-- toggle status --}}
                                            <form action="" method="POST" id="status-form">
                                                @csrf
                                                @method('patch')
                                            </form>


                                            @if ($user->is_active)

                                                <button type="submit" title="tap to deactivate"
                                                    class="btn text-danger d-flex flex-row align-items-center"
                                                    form="status-form" onclick="deactivate(<?= $user->id ?>)">
                                                    <i class=" fa fa-eye-slash" style="left:80%; top: 20%; font-size: 2rem;"
                                                        aria-hidden="true"></i>
                                                </button>

                                            @else
                                                <button type="submit" title="tap to activate"
                                                    class="btn text-info d-flex flex-row align-items-center"
                                                    form="status-form" onclick="activate(<?= $user->id ?>)">
                                                    <i class=" fa fa-eye" style="left:80%; top: 20%; font-size: 2rem;"
                                                        aria-hidden="true"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                @if (!$user->is_active)
                    <p class="text-danger text-bold"> You Deactivated By Admin</p>
                @endif


            </div>


        </div>
        <div class="row    d-flex flex-row align-items-center">
            <div class="col-12">

                @forelse ($user->posts as $post)
                    <div class="card w-75  mt-3 mx-auto">
                        <div class=" card-header d-flex flex-row align-items-center ">
                            <div class="col-6 d-flex flex-row align-items-center">
                                <img width="50" class="rounded-circle" src="{{ asset("uploads/$user->img") }}" alt="">
                                <h4 class="mx-1">{{ $user->name }}</h4>
                            </div>
                            <div class="col-6 d-flex flex-row justify-content-end align-items-center">


                                @if ($user->is_active)
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
                                @else
                                    <p class="text-danger">deactivted user!</p>
                                @endif

                            </div>
                        </div>
                        <div class="card-title w-75 m-auto">
                            <div class="row">
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

                            </div>
                        </div>
                        <div class="card-body py-0">
                            <p class="card-text">{{ $post->caption }}.</p>
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
                    <p class="h1 d-flex justify-content-center my-5 text-danger">User Not Had Any Posts</p>
                @endforelse
            </div>
        </div>
        <script>
            var URL = window.location.origin;

            function activate(id) {
                event.preventDefault();
                $('#status-form').attr('action', URL + '/dashboard/user/activate/' + id);
                $('#status-form').submit();
            }

            function deactivate(id) {
                event.preventDefault();
                $('#status-form').attr('action', URL + '/dashboard/user/deactivate/' + id);
                $('#status-form').submit();
            }
        </script>

    </div>
@endsection
