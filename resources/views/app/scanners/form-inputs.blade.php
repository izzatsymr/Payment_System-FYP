@php $editing = isset($scanner) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $scanner->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', ($editing ? $scanner->amount : ''))"
            max="255"
            step="0.01"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="mode" label="Mode">
            @php $selected = old('mode', ($editing ? $scanner->mode : '')) @endphp
            <option value="pay" {{ $selected == 'pay' ? 'selected' : '' }} >Pay</option>
            <option value="setup" {{ $selected == 'setup' ? 'selected' : '' }} >Setup</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="user_id" label="Vendor ID" required>
            @php $selected = old('user_id', ($editing ? $scanner->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Vendor</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
