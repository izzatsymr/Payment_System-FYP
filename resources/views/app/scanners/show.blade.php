@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('scanners.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.scanners.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.scanners.inputs.name')</h5>
                    <span>{{ $scanner->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scanners.inputs.amount')</h5>
                    <span>{{ $scanner->amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scanners.inputs.mode')</h5>
                    <span>{{ $scanner->mode ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scanners.inputs.user_id')</h5>
                    <span>{{ optional($scanner->user)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('scanners.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Scanner::class)
                <a href="{{ route('scanners.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
