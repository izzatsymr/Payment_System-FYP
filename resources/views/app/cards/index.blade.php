@extends('layouts.app')

@section('content')
<div class="container">
    <div class="searchbar mt-0 mb-4">
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="input-group">
                        <input
                            id="indexSearch"
                            type="text"
                            name="search"
                            placeholder="{{ __('crud.common.search') }}"
                            value="{{ $search ?? '' }}"
                            class="form-control"
                            autocomplete="off"
                        />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="icon ion-md-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-right">
                @can('create', App\Models\Card::class)
                <a href="{{ route('cards.create') }}" class="btn btn-primary">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">@lang('crud.cards.index_title')</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.cards.inputs.rfid')
                            </th>
                            <th class="text-left">
                                @lang('crud.cards.inputs.security_key')
                            </th>
                            <th class="text-left">
                                @lang('crud.cards.inputs.balance')
                            </th>
                            <th class="text-left">
                                @lang('crud.cards.inputs.student_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.cards.inputs.status')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cards as $card)
                        @if(auth()->user()->hasRole('super-admin') || auth()->user()->id == $card->student->user_id)
                        <tr>
                            <td>{{ $card->rfid ?? '-' }}</td>
                            <td>{{ $card->security_key ?? '-' }}</td>
                            <td>{{ $card->balance ?? '-' }}</td>
                            <td>{{ optional($card->student)->name ?? '-' }}</td>
                            <td>
                                <form action="{{ route('cards.toggle-status', $card) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-light">
                                        @if($card->status === 'active')
                                            <i class="ion-icon ion-md-toggle-on"></i>
                                        @else
                                            <i class="ion-icon ion-md-toggle-off"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="text-center" style="width: 134px;">
                                <div role="group" aria-label="Row Actions" class="btn-group">
                                    @can('update', $card)
                                    <a href="{{ route('cards.edit', $card) }}">
                                        <button type="button" class="btn btn-light">
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan
                                    @can('view', $card)
                                    <a href="{{ route('cards.show', $card) }}">
                                        <button type="button" class="btn btn-light">
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan
                                    @can('delete', $card)
                                    <form action="{{ route('cards.destroy', $card) }}" method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-light text-danger">
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="6">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">{{ $cards->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
