@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row    d-flex flex-row align-items-center">
            <div class="col-12">

                @forelse ($user->followers as $member)
                    {{-- {{ dd($member) }} --}}
                    <div class="card mt-2">
                        <div class=" card-header d-flex flex-row align-items-center ">
                            <div class="col-6 ">
                                <a href="{{ url("profile/$member->id") }}"
                                    class="text-decoration-none d-flex flex-row align-items-center">
                                    <img width="50" class="rounded-circle" src="{{ asset("uploads/$member->img") }}"
                                        alt="">
                                    <h4 class="mx-1">{{ $member->name }}</h4>
                                </a>
                            </div>
                            <div class="col-6 d-flex flex-row justify-content-end align-items-center">
                                @if ($member->id !== Auth::user()->id)

                                    @if (Auth::user()->isFollowing($member))

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
                                @endif
                            </div>
                        </div>

                        <div class="card-body p-2 bg-secondary text-light">
                            <h5 class="card-title">Bio</h5>
                            <p class="card-text"> {{ $member->bio }}</p>
                        </div>
                    </div>
                @empty

                    <p class="h1 d-flex justify-content-center my-5 text-danger">You Not Have Followers :(</p>

                @endforelse
            </div>
        </div>
    </div>
@endsection
