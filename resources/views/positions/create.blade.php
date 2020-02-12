@extends('adminlte::page')
@section('title', 'Create Position')
@section('content_header')
    <h1>Positions</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Create Position</h3>
                </div>

                <form role="form" action="{{ route('positions.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" class="form-control @error('positionName') is-invalid @enderror" id="inputName" name="positionName" data-field="item" placeholder="Name" value="{{ old('positionName') }}">
                            <div class="container">
                                <div class="row">
                                    @error('positionName')
                                        <div class="col p-0">
                                            <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                        </div>
                                    @enderror
                                    <div class="col p-0">
                                        <small class="text-muted float-right" data-field="target">0 / 256</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $(function () {
            var target = $('[data-field="target"]');

            var input = $('[data-field="item"]');
            var item_length = input.val().length;

            if(item_length > 256)
            {
                target.html(item_length + ' / 256');
            }

            $(document).on('input', '[data-field="item"]', function () {
                var item = $(this);
                var item_length = item.val().length;
                target.html(item_length + ' / 256');
                if(item_length > 256)
                {
                    $(this).addClass('is-invalid');
                }
                else if (item_length <= 256)
                {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
