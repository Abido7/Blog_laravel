@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row  d-flex flex-row align-items-center">
            <div class="col-12">

                <div class="row">

                    <div class="col-md-4">
                        <div class="position-relative">
                            <img class="rounded w-100 position-relative" src="{{ asset("uploads/$user->img") }}" alt="">
                            <button type="button" class="btn text-info d-flex flex-row align-items-center"
                                data-toggle="modal" data-target="#edit-profile-modal" id="edit-info"
                                data-bio="{{ $user->bio }}>">
                                <i class=" fa fa-edit position-absolute" style="left:85%; top: 0; font-size: 3rem;"
                                    aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="bg-secondary  text-light rounded">
                            <p class="p-2">Bio</p>
                            <p class=" px-4">{{ $user->bio }}</p>
                            <div class="d-flex justify-content-start">
                                <p class="mx-2">
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

                @include('inc.messages')

                <form action="{{ url('post/delete') }}" method="POST" id="delete-form">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="postId" id="hidden-input">
                </form>

                @forelse ($posts as $post)
                    <div class="card   m-3 m-auto">
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
                        @if (isset($post->comments[0]))
                            <div class="card-footer d-flex w-100 justify-content-between align-items-center">
                                <?php $CommentUser = $post->comments[0]->user; ?>
                                <a class="text-light text-decoration-none d-flex flex-row align-items-center"
                                    href="{{ url("user/$CommentUser->id") }}">
                                    <img width="30px" class="rounded-circle m-2"
                                        src="{{ asset("uploads/$CommentUser->img") }}" alt="">
                                    <p class="text-center text-info m-0"> {{ $CommentUser->name }}</p>
                                    <a class="text-dark text-decoration-none" href="{{ url("post/$post->id") }}">
                                        <p class="mx-3 p-0">{{ $post->comments[0]->body }}</p>
                                    </a>
                                </a>
                                <p class="mx-3 my-0 p-0">
                                    <?php $totalDuration = \Carbon\Carbon::parse($post->comments[0]->created_at)->DiffInMinutes(now()); ?>
                                    {{ Carbon\CarbonInterval::minutes($totalDuration)->cascade()->forHumans() }}
                                </p>
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
                                <span aria-hidden="true">×</span>
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
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form id="form-profile-edit" method="POST" action="{{ url('profile/update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('Patch')
                                {{-- <input type="hidden" name="id" id="edit-id"> --}}
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

        <script>
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
