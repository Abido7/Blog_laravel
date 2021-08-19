<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto d-flex flex-row align-items-center">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item d-flex flex-row align-items-center">
                                <button type="button" class="btn  text-muted d-flex flex-row align-items-center"
                                    data-toggle="modal" data-target="#add-modal">
                                    New Post
                                </button>
                                <a class="text-decoration-none text-muted d-flex flex-row align-items-center mx-2"
                                    href="{{ url('/') }}">
                                    <p class="m-0">{{ __('Home') }}</p>
                                </a>
                                <a class="text-decoration-none text-muted d-flex flex-row align-items-center mx-2"
                                    href="{{ url('/profile') }}">
                                    <p class="m-0">{{ __('Profile') }}</p>
                                </a>
                                <?php $img = Auth::user()->img; ?>


                                <a class="text-decoration-none d-flex flex-row align-items-center position-relative mr-4"
                                    href="{{ url('/profile') }}">
                                    <img width="30" class="rounded-circle position-absolute" style=""
                                        src="{{ asset("uploads/$img") }}" alt="">
                                </a>


                            </li>
                            <li class="nav-item mx-4">
                                <a class="btn btn-sm btn-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <form action="{{ url('/follow') }}" method="POST" id="follow-form">
                @csrf
                <input type="hidden" name="follow" id="hidden-follow-input">
            </form>
            <form action="{{ url('unfollow') }}" method="POST" style="display:none" id="unfollow-form">
                @csrf
                @method('delete')
                <input type="hidden" name="unfollowed" id="hidden-id">
            </form>
            @yield('content')




            <div class="add-modal">
                <div class="modal fade" id="add-modal" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add New Post</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="modal-form" method="POST" action="{{ url('post') }}"
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
                                                            <input type="file" name="imgs[]" class="custom-file-input"
                                                                multiple>
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

        </main>
    </div>


    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        function addFollow(id) {
            document.getElementById('hidden-follow-input').setAttribute('value', id);
            document.getElementById('follow-form').submit();
        }

        function unfollow(id) {
            event.preventDefault();
            document.getElementById('hidden-id').setAttribute('value', id);
            document.getElementById('unfollow-form').submit();
        }
    </script>

</body>

</html>
