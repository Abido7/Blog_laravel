@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            @php
                $user = $post->user;
                // $user == null ? redirect(url('/')) ;
                // dd($post);
            @endphp

            @isset($post->user)

                <div class="col-12 ">
                    <div class="card w-100  mt-3">
                        <div class="card-header py-1 d-flex flex-row align-items-center">
                            <div class="col-6">
                                <a class="text-decoration-none d-flex flex-row justify-content-cnter align-items-center"
                                    href="{{ url("profile/$user->id") }}">
                                    <img width="50" class="rounded-circle" src="{{ asset("uploads/$user->img") }}" alt="">
                                    <h4 class="mx-1">{{ $user->name }}</h4>
                                </a>
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
                            {{-- Like form --}}
                            <form action="{{ url('post/like') }}" style="display:none" method="POST" id="like-post">
                                @csrf
                                <input type="text" name="postId" type="hidden" value="{{ $post->id }}">
                            </form>
                            <form action="{{ url("post/dislike/$post->id") }}" style="display:none" method="POST"
                                id="dislike-post">
                                @csrf
                                @method('delete')
                            </form>

                            <p class="card-text">{{ $post->caption }}.</p>
                            <div class="info  d-flex align-items-center justify-content-start">

                                @if ($post->isLiked(Auth::user()))
                                    <button type="submit" class="btn text-info" form="dislike-post">
                                        <i class="far fa-thumbs-up"></i>
                                        like
                                    </button>
                                @else
                                    <button type="submit" class="btn text-secondary" form="like-post">
                                        <i class="far fa-thumbs-up"></i>
                                        like
                                    </button>
                                @endif

                                <p class="mr-2 my-0">{{ count($post->Likes) }} likes</p>
                                <p class=" my-0">{{ count($post->comments) }} Comments</p>
                            </div>
                            <div class="form-group d-flex flex-row align-items-center justify-content-center">
                                {{-- comment form --}}
                                <form action="{{ url("/add-comment/$post->id") }}" style="display:none" method="POST"
                                    enctype="multipart/form-data" id="comment-post">
                                    @csrf
                                </form>
                                <label class="m-0 pr-2" for="">Comment</label>
                                <input type="text" name="comment" class="form-control" placeholder="type Your Comment..."
                                    form="comment-post">
                                <div class="">
                                    <div class="custom-file">
                                        <input type="file" form="comment-post" name="img" class="custom-file-input">
                                        <label class="custom-file-label">Choose Image </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn " form="comment-post"><i
                                        class="far fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
                @foreach ($post->comments as $comment)
                    <div class="col-12">
                        <table class="table  bg-secondary">
                            <thead>
                                <tr class=" text-white">
                                    <th class="d-flex justify-content-start ">
                                        <?php $user = $comment->user; ?>
                                        <a href="{{ url("user/$user->id") }}">
                                            <img width="30px" class="rounded-circle m-2"
                                                src="{{ asset("uploads/$user->img") }}" alt="">
                                        </a>
                                        <a href="{{ url("user/$user->id") }}"
                                            class=" text-decoration-none text-center text-light m-0">
                                            {{ $comment->user->name }}</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-secondary text-white">
                                    <td class="d-flex  justify-content-between">
                                        <div class="d-flex justify-content-start">
                                            <p class="mx-3 my-0 ">{{ $comment->body }}</p>
                                            @forelse ($comment->images as $img)
                                                <img class="w-25 rounded img-fluid py-2"
                                                    src="{{ asset("uploads/$img->img") }}" alt="">
                                            @empty
                                            @endforelse
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-secondary text-white">
                                        <p class="mx-3 my-0 p-0">
                                            <?php $totalDuration = \Carbon\Carbon::parse($comment->created_at)->DiffInMinutes(now()); ?>
                                            {{ Carbon\CarbonInterval::minutes($totalDuration)->cascade()->forHumans() }}
                                        </p>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endisset


        </div>
    </div>
    </div>

    </div>
@endsection
