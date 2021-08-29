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
                        <h1 class="m-0">Users</h1>
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

                <div class="row">
                    {{-- toggle status --}}
                    <form action="" method="POST" id="status-form">
                        @csrf
                        @method('patch')
                    </form>



                    {{-- toggle role --}}
                    <form action="" method="POST" id="role-form">
                        @csrf
                        @method('patch')
                    </form>



                    <!-- /.col-12 -->
                    <div class="col-12">
                        <h2 class="h1 text-center mb-2">All Users ({{ $users->count() }})</h2>
                        <table class="table">
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
                                            @if ($user->is_active)
                                                <button form="status-form" type="submit" class="btn btn-sm btn-success"
                                                    onclick="deactivate(<?= $user->id ?>)">
                                                    <span>yes</span>
                                                </button>
                                            @else
                                                <button form="status-form" type="submit" class="btn btn-sm btn-danger"
                                                    onclick="activate(<?= $user->id ?>)">
                                                    <span>no</span>
                                                </button>

                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->role->name == 'admin')
                                                <button form="role-form" type="submit" class="btn btn-sm btn-success"
                                                    onclick="demote(<?= $user->id ?>)">
                                                    <span>yes</span>
                                                </button>
                                            @else
                                                <button form="role-form" type="submit" class="btn btn-sm btn-danger"
                                                    onclick="promote(<?= $user->id ?>)">
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


                function promote(id) {
                    event.preventDefault();
                    $('#role-form').attr('action', URL + '/dashboard/user/promote/' + id);
                    $('#role-form').submit();
                }

                function demote(id) {
                    event.preventDefault();
                    // $('.userId').attr('value', id);
                    $('#role-form').attr('action', URL + '/dashboard/user/demote/' + id);
                    $('#role-form').submit();
                }





                // function toggleRole(id) {
                //     document.getElementById('userRoleId').setAttribute('value', id);
                // }

                function destroyUser(id) {
                    // console.log(id)
                    document.getElementById('deletedUserId').setAttribute('value', id);
                }
            </script>
        </div>
        <!-- /.content -->

    @endsection
