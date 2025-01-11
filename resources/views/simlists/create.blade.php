@extends('layouts')
@section('content')

    <div class="container-fluid">
        <h3 class="text-dark mb-4">Create Sim info</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">New Sim </p>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('simlists.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="sim_info">SIM Համար</label>
                        <input type="text" name="number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="number">SIM Կոդ ICMC</label>
                        <input type="text" name="sim_info" class="form-control" required>
                    </div>
                    <div class="form-group">

                        <label for="sim_id">Օպերատոր</label>
                        <select class="form-control" name="sim_id">
                            <option value="{{null}}" >yntrel</option>
                            <optgroup label="operators">


                                <option value="Viva" >Viva</option>
                                <option value="Ucom" >Ucom</option>
                                <option value="Team">Team</option>
                            </optgroup>


                        </select>

                    </div>
                    <div class="form-group">

                        <input type="hidden" value="1" name="worker_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="mb">Գին</label>
                        <input type="number" name="price" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="mb">MB-ի Չափը</label>
                        <input type="number" name="mb" class="form-control" >
                    </div>

                    {{--                            <div class="form-group">--}}
                    {{--                                <label for="project_id">Project:</label>--}}
                    {{--                                <select id="project_id" name="project_id" required>--}}
                    {{--                                    @foreach ($projects as $project)--}}
                    {{--                                        <option value="{{ $project->id }}">{{ $project->firm_bank }}</option>--}}
                    {{--                                    @endforeach--}}
                    {{--                                </select>--}}


                    {{--                            </div>--}}

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
