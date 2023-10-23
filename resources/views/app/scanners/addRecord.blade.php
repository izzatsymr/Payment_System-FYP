@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('scanners.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
            </h4>

            <form method="POST" action="{{ route('scanners.storeCardScanner') }}" class="mt-4">
                @csrf <!-- Add the CSRF token field for security -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="card_id">Select Card</label>
                            <select name="card_id" id="card_id" class="form-control">
                                @foreach ($cards as $cardId => $rfid)
                                    <option value="{{ $cardId }}">{{ $rfid }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="scanner_id">Select Scanner</label>
                            <select name="scanner_id" id="scanner_id" class="form-control">
                                @foreach ($scanners as $scannerId => $scannerName)
                                    <option value="{{ $scannerId }}">{{ $scannerName }}</option>
                                @endforeach
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
