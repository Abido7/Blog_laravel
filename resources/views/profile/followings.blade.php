@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row    d-flex flex-row align-items-center">
            <div class="col-12">
                {{-- <form action="{{ url('/follow') }}" method="POST" id="follow-form">
                    @csrf
                    <input type="hidden" name="follow" id="hidden-follow-input">
                </form>
                <form action="{{ url('unfollow') }}" method="POST" style="display:none" id="unfollow-form">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="unfollowed" id="hidden-id">
                </form> --}}
                @forelse ($followings as $member)
                    <div class="card mt-2">
                        <div class=" card-header d-flex flex-row align-items-center ">
                            <div class="col-6 ">
                                <a href="{{ url("user/$member->id") }}"
                                    class="text-decoration-none d-flex flex-row align-items-center">
                                    <img width="50" class="rounded-circle" src="{{ asset("uploads/$member->img") }}"
                                        alt="">
                                    <h4 class="mx-1">{{ $member->name }}</h4>
                                </a>
                            </div>
                            <div class="col-6 d-flex flex-row justify-content-end align-items-center">

                                @if (in_array($member->id, $authFollowing))

                                    <button type="button" form="unfollow-form" class="btn btn-secondary"
                                        onclick="unfollow(<?= $member->id ?>);">
                                        UnFollow
                                    </button>
                                @else
                                    <button type="button" form="follow-form" class="btn btn-secondary"
                                        onclick="addFollow(<?= $member->id ?>);">
                                        Follow
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="card-body p-2 bg-secondary text-light">
                            <h5 class="card-title">Bio</h5>
                            <p class="card-text"> {{ $member->bio }}</p>
                        </div>
                    </div>
                @empty

                    <p class="h1 d-flex justify-content-center my-5 text-danger">You Not following Any :(</p>

                @endforelse
            </div>
        </div>
    </div>
@endsection
