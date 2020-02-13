@extends('adminlte::page')
@section('title', 'Edit Position')
@section('content_header')
    <h1>Positions</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Edit Position</h3>
                </div>

                <form role="form" action="{{ route('positions.update', $position->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group m-0">
                            <label for="inputName">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" name="name" data-field="item" placeholder="Name" value="{{ $position->name }}">
                            <div class="container">
                                <div class="row">
                                    @error('name')
                                    <div class="col p-0">
                                        <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                    </div>
                                    @enderror
                                    <div class="col p-0">
                                        <small class="text-muted float-right" data-field="target">0 / 256</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col p-0">
                                        <p><b>Created at:</b> {{ $position->created_at->format('d.m.y') }}</p>
                                    </div>
                                    <div class="col p-0">
                                        <p class="float-right"><b>Admin created ID:</b> {{ $position->admin_created_id }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col p-0">
                                        <p><b>Updated at:</b> {{ $position->updated_at->format('d.m.y') }}</p>
                                    </div>
                                    <div class="col p-0">
                                        <p class="float-right"><b>Admin updated ID:</b> {{ $position->admin_updated_id }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('positions.index') }}" class="btn btn-default">Cancel</a>
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

            target.html(item_length + ' / 256');

            $(document).on('input', '[data-field="item"]', function () {
                $(this).parent('.form-group').find('.container .row .col span.error').hide();
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
