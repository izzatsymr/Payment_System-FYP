@php $editing = isset($card) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="rfid"
            label="Rfid"
            :value="old('rfid', ($editing ? $card->rfid : ''))"
            maxlength="255"
            placeholder="Rfid"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="security_key"
            label="Security Key"
            :value="old('security_key', ($editing ? $card->security_key : ''))"
            maxlength="255"
            placeholder="Security Key"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="balance"
            label="Balance"
            :value="old('balance', ($editing ? $card->balance : ''))"
            step="0.01"
            placeholder="Balance"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $card->status : 'Active')) @endphp
            <option value="active" {{ $selected == 'active' ? 'selected' : '' }} >Active</option>
            <option value="deactive" {{ $selected == 'deactive' ? 'selected' : '' }} >Deactive</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="student_id" label="Student" required>
            @php $selected = old('student_id', ($editing ? $card->student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Student</option>
            @foreach($students as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
