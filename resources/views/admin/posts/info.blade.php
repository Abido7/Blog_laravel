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
                        <h1 class="m-0">Posts</h1>
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

                        {{-- <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Active</th>
                                    <th>Is Admin</th>
                                    <th>country</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->status == 1)
                                                <button form="status-form" type="submit" class="btn btn-sm btn-success"
                                                    onclick="toggleStatus(<?= $user->id ?>)">
                                                    <span>yes</span>
                                                </button>
                                            @else
                                                <button form="status-form" type="submit" class="btn btn-sm btn-danger"
                                                    onclick="toggleStatus(<?= $user->id ?>)">
                                                    <span>no</span>
                                                </button>

                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->role->name == 'admin')
                                                <button form="role-form" type="submit" class="btn btn-sm btn-success"
                                                    onclick="toggleRole(<?= $user->id ?>)">
                                                    <span>yes</span>
                                                </button>
                                            @else
                                                <button form="role-form" type="submit" class="btn btn-sm btn-danger"
                                                    onclick="toggleRole(<?= $user->id ?>)">
                                                    <span>no</span>
                                                </button>

                                            @endif

                                        </td>
                                        <td>{{ $user->country->name }}</td>
                                        <td>
                                            <a href="{{ url("dashboard/users/$user->id") }}">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            <button form="delete-user-form" type="submit" class="btn text-danger"
                                                onclick="destroyUser(<?= $user->id ?>)">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table> --}}


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
            {{-- <script>
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
            </script> --}}
        </div>
        <!-- /.content -->

    @endsection
