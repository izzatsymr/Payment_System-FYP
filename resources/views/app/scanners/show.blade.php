@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('scanners.index') }}" class="mr-4">
                    <i class="icon ion-md-arrow-back"></i>
                </a>
                @lang('crud.scanners.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>Item Name</h5>
                    <span>{{ $scanner->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>Amount</h5>
                    <span>{{ $scanner->amount ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.scanners.inputs.mode')</h5>
                    <span>{{ $scanner->mode ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>Vendor Name</h5>
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
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Scanner Records</h4>
            <div class="table-responsive">
                <table class="table table-borderless" id="sortable-table">
                    <thead>
                        <tr>
                            <th id="col-studentID">
                                Student ID
                            </th>
                            <th id="col-cardRFID">
                                Card RFID <i class="fas fa-sort">
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
                        @forelse($scanner->cards as $transaction)
                            <tr>
                                <td>{{ $transaction->student_id }}</td>
                                <td>{{ $transaction->rfid }}</td>
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
