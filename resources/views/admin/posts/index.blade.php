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
                        <h1 class="m-0">Posts ({{ $posts->count() }})</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Posts</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- toggle status --}}
                    <form action="{{ url('/dashboard/toggle-status') }}" method="POST" id="status-form">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="userId" id="userId">
                    </form>
                    {{-- toggle role --}}
                    <form action="{{ url('/dashboard/toggle-role') }}" method="POST" id="role-form">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="userId" id="userRoleId">
                    </form>

                    <!-- /.col-12 -->
                    <div class="col-12">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Caption</th>
                                    <th>Posted By</th>
                                    <th>Posted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $post->caption }}</td>
                                        <td>
                                            {{-- <a class="lead" href="{{ url('dashboard/users/' . $post->user->id) }}">
                                                {{ $post->user->name }}
                                            </a> --}}
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse($post->created_at)->format('m/d/y h:m a') }}
                                        </td>
                                        <td></td>

                                        {{-- <td>
                                            @if ($post->status == 1)
                                                <button form="status-form" type="submit" class="btn btn-sm btn-success"
                                                    onclick="toggleStatus(<?= $post->id ?>)">
                                                    <span>yes</span>
                                                </button>
                                            @else
                                                <button form="status-form" type="submit" class="btn btn-sm btn-danger"
                                                    onclick="toggleStatus(<?= $post->id ?>)">
                                                    <span>no</span>
                                                </button>

                                            @endif
                                        </td> --}}

                                        {{-- <td>
                                            @if ($post->role->name == 'admin')
                                                <button form="role-form" type="submit" class="btn btn-sm btn-success"
                                                    onclick="toggleRole(<?= $post->id ?>)">
                                                    <span>yes</span>
                                                </button>
                                            @else
                                                <button form="role-form" type="submit" class="btn btn-sm btn-danger"
                                                    onclick="toggleRole(<?= $post->id ?>)">
                                                    <span>no</span>
                                                </button>

                                            @endif

                                        </td> --}}

                                        {{-- <td>
                                            <a href="{{ url("dashboard/users/$user->id") }}">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            <button form="delete-user-form" type="submit" class="btn text-danger"
                                                onclick="destroyUser(<?= $user->id ?>)">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td> --}}
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>


                    </div>
                    <!-- /.col-md-6 -->

                    {{-- delete user --}}
                    <form action="{{ url('/dashboard/users/' . Auth::user()->id) }}" method="POST" id="delete-user-form">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="userId" id="deletedUserId">
                    </form>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
            <script>
                function toggleStatus(id) {
                    document.getElementById('userId').setAttribute('value', id);
                }

                function toggleRole(id) {
                    document.getElementById('userRoleId').setAttribute('value', id);
                }

                function destroyUser(id) {
                    // console.log(id)
                    document.getElementById('deletedUserId').setAttribute('value', id);
                }
            </script>
        </div>
        <!-- /.content -->

    @endsection
