@extends('admin.inc.master')

@section('title')
    users
@endsection

@section('body')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Home</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <!-- /.col-12 -->
                        <div class="col-3">

                            <div class="bg-secondary rounded">
                                <p class="h4 m-0 p-2">Users ({{ $users }})*</p>
                            </div>
                        </div>
                        <div class="col-3">

                            <div class="bg-secondary rounded">
                                <p class="h4 m-0 p-2">Posts ({{ $posts->count() }})*</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="bg-secondary rounded px-1">
                                <p class="h4 m-0 p-2">Comments ({{ $comments }})*</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="bg-secondary rounded">
                                <p class="h4 m-0 p-2">Likes ({{ $likes }})*</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {!! $postsChart->container() !!}
                            <script src="{{ $postsChart->cdn() }}">
                            </script>
                            {{ $postsChart->script() }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h2 class="h2 text-center mt-5">Top 5 Posts</h2>
                    </div>
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>posts_id</th>
                                    <th>User Name</th>
                                    <th>Likes</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>{{ $post->likes_count }}</td>
                                        <td>{{ $post->comments_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->

            {{-- <script src="{{ $postsChart->cdn() }}">
            </script> --}}
            {{-- {{ $postsChart->script() }} --}}
        </div>
        <!-- /.content -->

    @endsection
