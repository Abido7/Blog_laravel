@extends('admin.inc.master')

@section('title')
    dashboard
@endsection

@section('body')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $user->name }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $user->name }}</li>
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
                            <tbody>
                                {{-- name --}}

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                {{-- email --}}
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>

                                {{-- image --}}
                                <tr>

                                    <th>Image</th>
                                    <td>
                                        <img src="{{ asset("uploads/$user->img") }}" class="w-25" alt="">
                                    </td>
                                </tr>

                                {{-- country --}}
                                <tr>
                                    <th>country</th>
                                    <td>{{ $user->country->name }}</td>
                                </tr>

                                <tr>
                                    <th>Added At</th>
                                    <td>{{ Carbon\Carbon::parse($user->created_at)->format('m/d/Y') }}</td>
                                </tr>

                                {{-- is admin --}}
                                <tr>
                                    <th>Is Admin</th>
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
                                </tr>

                                {{-- is active --}}
                                <tr>

                                    <th>Active</th>

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
                                </tr>



                            </tbody>

                        </table>


                    </div>
                    <!-- /.col-md-6 -->

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
            </script>
        </div>
        <!-- /.content -->

    @endsection
