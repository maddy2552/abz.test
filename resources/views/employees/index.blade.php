@extends('adminlte::page')
@section('title', 'Employees')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="float-left">Employees</h1>
        </div>
        <div class="col">
            <a href="{{ route('employees.create') }}" class="btn btn-info float-right">Add employee</a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-header">Employees</div>
        <div class="card-body">
            <table class="table table-bordered table-striped compact" id="employees-table">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Date of employment</th>
                    <th style="width: 8em">Phone Number</th>
                    <th>Email</th>
                    <th>Salary</th>
                    <th style="width: 4em">Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deleting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $(function() {
            $('#employees-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatables.getEmployees') !!}',
                "columnDefs": [
                    {
                        "targets": "_all",
                        "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
                            if (colIndex === 6) {
                                $(td).mask('$000,000');
                            }
                        }
                    }
                ],
                columns: [
                    { data: 'photo', orderable: false, searchable: false, 'render' : function (url) {
                            return '<img style="width: 50px; height: 50px" class="rounded-circle" src="uploads/'+url+'"/>';
                        }
                    },
                    { data: 'full_name'},
                    { data: 'position_id'},
                    { data: 'date_of_employment'},
                    { data: 'phone' },
                    { data: 'email' },
                    { data: 'salary', 'render' : function (salary, type, obj, param4) {
                            console.log(param4);
                            return salary;
                        }},
                    { data: 'action', orderable: false, searchable: false }
                ]
            });
            $('#employees-table').on('click', '.btn-delete', function () {
                let name = 'Are u sure to delete ' + $(this).parents('tr').find('td').next().html() + '?';
                let route = $(this).attr('data-id');
                $('#exampleModal .modal-body').html(name);
                $('#exampleModal .modal-footer form').attr('action', route);
            });
        });
    </script>
@endpush
