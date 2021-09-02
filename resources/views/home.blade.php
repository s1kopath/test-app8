@extends('layouts.app')

@section('content')
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>

            </div>
        </div>
    </div>
</div> --}}


    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" type="button" data-toggle="modal" data-target="#exampleModal">
                                {{ __('Add Employee') }}
                            </a>

                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('home') }}">
                                {{ __('Employee List') }}
                            </a>
                        </li>

                    </ul>

                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

                @if (session()->has('success'))
                    <div class="alert alert-info d-flex justify-content-between">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger d-flex justify-content-between">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger d-flex justify-content-between mt-2">{{ $error }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endforeach
                @endif

                
                <h2>Employee List</h2>
                <div class="container">
                    <table class="table table-striped table-sm" id="myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Date of birth</th>
                                <th>Picture</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee as $key => $data)

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->contact }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->date_of_birth }}</td>
                                    <td>
                                        <img style="width: 100px; border-radius: 50%"
                                            src="{{ asset('storage/employees/' . $data->picture) }}" alt="">
                                    </td>
                                    <td>
                                        <a class="btn btn-warning" href="#" type="button" data-toggle="modal"
                                            data-target="#update{{ $data->id }}">Update</a> ||
                                        <a class="btn btn-danger"
                                            href="{{ route('delete_employee', $data->id) }}">Delete</a>
                                    </td>
                                </tr>
                                <!--update Modal -->
                                <div class="modal fade" id="update{{ $data->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update Employee</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post" action="{{ route('update_employee', $data->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $data->name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Contact</label>
                                                        <input type="number" class="form-control" name="contact"
                                                            value="{{ $data->contact }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email address</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ $data->email }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Date of birth</label>
                                                        <input type="date" class="form-control" name="date_of_birth"
                                                            value="{{ $data->date_of_birth }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Picture: </label>
                                                        <img style="width: 100px; border-radius: 50%"
                                                            src="{{ asset('storage/employees/' . $data->picture) }}"
                                                            alt="">
                                                        <input type="file" name="picture">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('add_employee') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="number" class="form-control" name="contact">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label>Date of birth</label>
                            <input type="date" class="form-control" name="date_of_birth">
                        </div>
                        <div class="form-group">
                            <label>Picture: </label>
                            <input type="file" name="picture">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
@endsection
