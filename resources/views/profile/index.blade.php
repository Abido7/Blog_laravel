@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row  d-flex flex-row align-items-center">
            <div class="col-12">
                <form action="{{ url('post/delete') }}" method="POST" id="delete-form">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="postId" id="hidden-input">
                </form>
                @forelse ($posts as $post)
                    <div class="card w-75  m-3 m-auto">
                        <div class=" card-header d-flex flex-row align-items-center ">
                            <div class="col-6 d-flex flex-row align-items-center">
                                <img width="50" class="rounded-circle" src="{{ asset("uploads/$user->img") }}" alt="">
                                <h4 class="mx-1">{{ $user->name }}</h4>
                            </div>
                            <div class="col-3 d-flex flex-row align-items-center">
                                <p class="mx-1">
                                    <a class="text-muted text-decoration-none" href="{{ url("followings/$user->id") }}">
                                        Following ({{ $user->followings->count() }})
                                    </a>
                                </p>
                            </div>
                            <div class="col-3 d-flex flex-row justify-content-end align-items-center">

                                <i class="fa fa-trash" aria-hidden="true"></i>
                                <button type="submit" onclick="deletePost(<?= $post->id ?>)" class=" btn btn-danger">
                                    Delete Post
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

                <script>
                    function deletePost(id) {
                        document.getElementById('hidden-input').setAttribute('value', id);
                        document.getElementById('delete-form').submit();
                    }
                </script>
            </div>
        </div>
    </div>




    {{-- ===================================== --}}

    <div class="add-modal">
        <div class="modal fade" id="add-modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="modal-form" method="POST" action="{{ url('post/store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> Caption </label>
                                            <input type="text" name="caption" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> Image </label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="imgs[]" class="custom-file-input" multiple>
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
                        <button type="submit" class="btn btn-primary" form="modal-form">Post</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
@endsection
