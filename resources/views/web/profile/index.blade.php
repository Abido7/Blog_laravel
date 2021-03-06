@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row d-flex flex-row align-items-center">
            <div class="col-12">
                {{-- admin deactivate user --}}

                <div class="bg-secondary mb-5 text-light" style="border-radius: 50% 0% 0% 50% !important;">
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

                @include('inc.messages')

                <form action="{{ url('post/destroy') }}" method="POST" id="delete-form">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="postId" id="hidden-input">
                </form>

                @forelse ($user->posts as $post)
                    <div class="card mx-auto w-75  m-3">
                        <div class=" card-header d-flex flex-row align-items-center ">
                            <div class="col-6 d-flex flex-row align-items-center">
                                <img width="50" class="rounded-circle" src="{{ asset("uploads/$user->img") }}" alt="">
                                <h4 class="mx-1">{{ $user->name }}</h4>
                            </div>
                            <div class="col-3 d-flex flex-row align-items-center">
                            </div>
                            <div class="col-3 d-flex flex-row justify-content-end align-items-center">

                                <button type="button" class="btn  text-muted d-flex flex-row align-items-center"
                                    data-toggle="modal" data-target="#edit-modal" id="edit-post"
                                    onclick="setId(<?= $post->id ?>)" data-caption="{{ $post->caption }}">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </button>

                                <button type="submit" onclick="deletePost(<?= $post->id ?>)"
                                    class=" btn p-0 m-0 text-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>

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
                        @if (isset($post->latestComment))
                            @php
                                $CommentUser = $post->latestComment->user;
                            @endphp
                            @if (isset($CommentUser))
                                <div class="card">
                                    <div class="card-header">
                                        <a class="text-light text-decoration-none d-flex flex-row align-items-center"
                                            href="{{ url("profile/$CommentUser->id") }}">
                                            <img width="30px" class="rounded-circle m-2"
                                                src="{{ asset("uploads/$CommentUser->img") }}" alt="">
                                            <p class="text-center text-info"> {{ $CommentUser->name }}</p>
                                        </a>
                                    </div>
                                    <div class="card-body border-2 bg-secondary text-light">
                                        <div class="commet-body d-flex flex-row justify-content-between ">
                                            <a class="text-light text-decoration-none"
                                                href="{{ url("post/$post->id") }}">
                                                <p class="mx-3">{{ $post->latestComment->body }}</p>
                                            </a>
                                            <p class="mx-3 my-0 p-0">
                                                <?php $totalDuration = \Carbon\Carbon::parse($post->latestComment->created_at)->DiffInMinutes(now()); ?>
                                                {{ Carbon\CarbonInterval::minutes($totalDuration)->cascade()->forHumans() }}
                                            </p>
                                        </div>
                                    </div>
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
                    <p class="h1 d-flex justify-content-center my-5 text-danger">No Posts You Can Add Now!</p>
                @endforelse

            </div>
        </div>




        {{-- edite post modal --}}
        <div class="edit-modal">
            <div class="modal fade" id="edit-modal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Post</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">??</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="modal-form-edit" method="POST" action="{{ url('post/update') }}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="id" id="edit-id">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label> Caption </label>
                                                <input type="text" id="edit-caption" name="caption" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="modal-form-edit">update</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>

        {{-- {{-- edite modal --}}
        <div class="edit-profile-modal">
            <div class="modal fade" id="edit-profile-modal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Profile Info</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">??</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form id="form-profile-edit" method="POST" action="{{ url('profile/update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('Patch')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> bio </label>
                                                <input type="text" id="edit-bio" name="bio" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> Image </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="img" class="custom-file-input">
                                                        <label class="custom-file-label">Choose Image </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="form-profile-edit">update</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
        @if (session()->get('registered') == '/register')
            <script>
                window.onload = function() {
                    document.getElementById("edit-info").click();
                };
            </script>
            {{ session()->forget('registered') }}
        @endif

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

            function deletePost(id) {
                document.getElementById('hidden-input').setAttribute('value', id);
                document.getElementById('delete-form').submit();
            }

            function setId(id) {
                document.getElementById('edit-id').setAttribute('value', id);
            }

            let caption = document.getElementById('edit-post').getAttribute('data-caption');
            let bio = document.getElementById('edit-info').getAttribute('data-bio');
            document.getElementById('edit-caption').setAttribute('value', caption);
            document.getElementById('edit-bio').setAttribute('value', bio);
        </script>
    </div>
@endsection
