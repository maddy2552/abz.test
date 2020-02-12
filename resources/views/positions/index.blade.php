@extends('adminlte::page')
@section('title', 'Positions')
@section('content_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1 class="float-left">Positions</h1>
            </div>
            <div class="col">
                <a href="{{ route('positions.create') }}" class="btn btn-info float-right">Add position</a>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-header">Positions</div>
        <div class="card-body">
            <table class="table table-bordered table-striped compact" id="positions-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th style="width: 6em">Last update</th>
                    <th style="width: 8em">Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
            $('#positions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatables.data') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('#positions-table').on('click', '.btn-delete', function () {
                let name = 'Are u sure to delete ' + $(this).parents('tr').find('.sorting_1').html() + '?';
                let route = $(this).attr('data-id');
                $('#exampleModal .modal-body').html(name);
                $('#exampleModal .modal-footer form').attr('action', route);
            });
        });
    </script>
@endpush
