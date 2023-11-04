@extends('layouts.app')

@section('content')
<link href="{{ asset('css/digital-card.css') }}" rel="stylesheet">
<div class="container">
    <div class="bankcard">
        <div class="bankcard-inner">
            <div class="front">
                <div class="row">
                    <img src="https://i.ibb.co/WHZ3nRJ/visa.png" width="60px">
                </div>
                <div class="row card-no">
                    <p>RFID {{ $card->rfid ?? '-' }}</p>
                </div>
                <div class="row card-holder">
                    <p>STUDENT NAME</p>
                    <p>BALANCE</p>
                </div>
                <div class="row name">
                    <p>{{ optional($card->student)->name ?? '-' }}</p>
                    <p>{{ $card->balance ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<p></p>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Card Records</h4>
                <div class="table-responsive">
                    <table class="table table-borderless" id="sortable-table">
                        <thead>
                            <tr>
                                <th>
                                    Card RFID
                                </th>
                                <th id="col-item">
                                    Item <i class="fas fa-sort"></i>
                                </th>
                                <th id="col-amount">
                                    Amount <i class="fas fa-sort"></i>
                                </th>
                                <th id="col-success">
                                    Success <i class="fas fa-sort"></i>
                                </th>
                                <th id="col-time">
                                    Time <i class="fas fa-sort"></i>
                                </th>
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
