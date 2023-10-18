@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('scanners.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                @lang('crud.scanners.create_title')
            </h4>

            <form method="POST" action="{{ route('scanners.storeCardScanner') }}" class="mt-4">
                @csrf <!-- Add the CSRF token field for security -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="scanner_id">Select Scanner</label>
                            <select name="scanner_id" id="scanner_id" class="form-control">
                                @foreach ($scanners as $id => $id)
                                    <option value="{{ $id }}">{{ $id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="card_id">Select Card</label>
                            <select name="card_id" id="card_id" class="form-control">
                                @foreach ($cards as $id => $id)
                                    <option value="{{ $id }}">{{ $id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="is_success">Is Success</label>
                            <select name="is_success" id="is_success" class="form-control">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('scanners.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <button type="submit" class="btn btn-primary float-right">
                        <i class="icon ion-md-save"></i>
                        @lang('crud.common.create')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
