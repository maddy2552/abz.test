@extends('adminlte::page')
@section('title', 'Create Employee')
@section('content_header')
    <h1>Employees</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add Employee</h3>
                </div>

                <form enctype="multipart/form-data" action="{{ route('employees.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputPhoto">Photo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="inputPhoto" name="photo">
                                    <label class="custom-file-label" for="inputPhoto">Choose photo</label>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    @error('photo')
                                    <div class="col p-0">
                                        <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                    </div>
                                    @enderror
                                    <div class="col p-0">
                                        <small class="text-muted float-right">File format jpg, png up to 5MB, the min. size of 300x300px</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Full Name</label>
                            <input type="text" class="form-control @error('fullName') is-invalid @enderror" id="inputName" name="fullName" data-field="item" placeholder="Name" value="{{ old('fullName') }}">
                            <div class="container">
                                <div class="row">
                                    @error('fullName')
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
                        <div class="form-group">
                            <label for="inputPhone">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="inputPhone" name="phone" value="{{ old('phone') }}">
                            <div class="container">
                                <div class="row">
                                    @error('phone')
                                    <div class="col p-0">
                                        <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                    </div>
                                    @enderror
                                    <div class="col p-0">
                                        <small class="text-muted float-right">Required format +380 (xx) XXX XX XX</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" name="email" value="{{ old('email') }}">
                            <div class="container">
                                <div class="row">
                                    @error('email')
                                    <div class="col p-0">
                                        <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPosition">Position</label>
                            <select class="form-control @error('position') is-invalid @enderror" name="position" id="inputPosition">
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                            <div class="container">
                                <div class="row">
                                    @error('position')
                                    <div class="col p-0">
                                        <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSalary">Salary, $</label>
                            <input type="text" class="form-control @error('salary') is-invalid @enderror" id="inputSalary" name="salary" value="{{ old('salary') }}">
                            <div class="container">
                                <div class="row">
                                    @error('salary')
                                    <div class="col p-0">
                                        <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputHead">Head</label>
                            <input type="text" class="form-control @error('head') is-invalid @enderror {{ Session::has('error') ? 'is-invalid' : '' }}" id="inputHead" name="head" value="{{ old('head') }}">
                            <div class="container">
                                <div class="row">
                                    @error('head')
                                        <div class="col p-0">
                                            <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                        </div>
                                    @enderror
                                    @if(Session::has('error'))
                                        <div class="col p-0">
                                            <span class="error invalid-feedback" style="display: block">{{ Session::get('error') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputDate">Date of employment</label>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" id="inputDate" name="date" value="{{ old('date') }}">
                            <div class="container">
                                <div class="row">
                                    @error('date')
                                    <div class="col p-0">
                                        <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('employees.index') }}" class="btn btn-default">Cancel</a>
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
            $(document).ready(function () {
                bsCustomFileInput.init();
            });

            $('#inputDate').datepicker({
                format: "dd.mm.yy",
                autoclose: true
            });

            $('#inputPhone').mask("+38R (00) 0000000", {placeholder: "+380 (__) _______", translation: { 'R' : { pattern: /[0]/, optional: false }}});
            $('#inputSalary').mask("000.000");

            $('#inputHead').autocomplete({
                source: '{!! route('employees.find') !!}',
                minLength: 3,
                delay: 500,
            });

            var target = $('[data-field="target"]');

            var input = $('[data-field="item"]');
            var item_length = input.val().length;

            target.html(item_length + ' / 256');

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
