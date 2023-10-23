@extends('layouts.app')
<link href="{{ asset('css/digital-card.css') }}" rel="stylesheet">

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('cards.index') }}" class="mr-4">
                    <i class="icon ion-md-arrow-back"></i>
                </a>
                @lang('crud.cards.show_title')
            </h4>

            <div class="mt-4 digital-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Card Information') }}</h3>
                </div>
                <div class="card-content">
                    <div class="card-field">
                        <label>RFID:</label>
                        <span>{{ $card->rfid ?? '-' }}</span>
                    </div>
                    <div class="card-field">
                        <label>{{ __('Security Key') }}:</label>
                        <span>{{ $card->security_key ?? '-' }}</span>
                    </div>
                    <div class="card-field">
                        <label>{{ __('Balance') }}:</label>
                        <span>{{ $card->balance ?? '-' }}</span>
                    </div>
                    <div class="card-field">
                        <label>{{ __('Status') }}:</label>
                        <span>{{ $card->status ?? '-' }}</span>
                    </div>
                    <div class="card-field">
                        <label>{{ __('Student') }}:</label>
                        <span>{{ optional($card->student)->name ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Card Records</h4>
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>RFID</th>
                            <th>ITEM</th>
                            <th>AMOUNT</th>
                            <th>SUCCESS</th>
                            <th>TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($card->scanners as $transaction)
                            <tr>
                                <td>{{ $card->rfid }}</td>
                                <td>{{ $transaction->name }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->pivot->is_success }}</td>
                                <td>{{ $transaction->pivot->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
