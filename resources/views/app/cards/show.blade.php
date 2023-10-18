@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('cards.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.cards.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.cards.inputs.rfid')</h5>
                    <span>{{ $card->rfid ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cards.inputs.security_key')</h5>
                    <span>{{ $card->security_key ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cards.inputs.balance')</h5>
                    <span>{{ $card->balance ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cards.inputs.status')</h5>
                    <span>{{ $card->status ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.cards.inputs.student_id')</h5>
                    <span>{{ optional($card->student)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('cards.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Card::class)
                <a href="{{ route('cards.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
