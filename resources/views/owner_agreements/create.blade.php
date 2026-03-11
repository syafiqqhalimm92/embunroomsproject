@extends('layouts.app')

@section('title','Create Owner Agreement')

@section('content')

<h2>Create Owner Agreement</h2>

<div style="margin-bottom:10px;">
    <a href="{{ route('units.edit', $house->id) }}">
        <button type="button">← Back</button>
    </a>
</div>

@if ($errors->any())
    <div style="padding:10px;border:1px solid #a00;color:#a00;margin-bottom:12px;">
        <strong>There were some errors:</strong>
        <ul style="margin:6px 0 0 18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('owner-agreements.store', $house->id) }}">
    @csrf

    <table cellpadding="8" cellspacing="0">

        <tr>
            <td><strong>Agreement Template</strong></td>
            <td>
                <select name="agreement_template_id" style="width:300px;" required>
                    <option value="">-- Select Template --</option>

                    @foreach($templates as $template)
                        <option value="{{ $template->id }}"
                            @selected(old('agreement_template_id') == $template->id)>
                            {{ $template->title }}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <td style="width:220px;"><strong>Agreement Date</strong></td>
            <td>
                <input type="date" name="agreement_date" value="{{ old('agreement_date') }}" required>
            </td>
        </tr>

        <tr><td colspan="2"><hr></td></tr>

        <tr>
            <td><strong>Owner Name</strong></td>
            <td>
                <input type="text" name="owner_name"
                       value="{{ old('owner_name', $house->owner_full_name) }}"
                       style="width:420px;">
            </td>
        </tr>

        <tr>
            <td><strong>Owner IC</strong></td>
            <td>
                <input type="text" name="owner_ic"
                       value="{{ old('owner_ic', $house->owner_ic_no) }}"
                       style="width:260px;">
            </td>
        </tr>

        <tr>
            <td><strong>Owner Phone</strong></td>
            <td>
                <input type="text" name="owner_phone"
                       value="{{ old('owner_phone') }}"
                       style="width:260px;">
            </td>
        </tr>

        <tr>
            <td><strong>Bank Name</strong></td>
            <td>
                <input type="text" name="bank_name"
                       value="{{ old('bank_name', $house->bank_name) }}"
                       style="width:260px;">
            </td>
        </tr>

        <tr>
            <td><strong>Bank Account No</strong></td>
            <td>
                <input type="text" name="bank_account_no"
                       value="{{ old('bank_account_no', $house->bank_account_no) }}"
                       style="width:260px;">
            </td>
        </tr>

        <tr>
            <td><strong>Premise Address</strong></td>
            <td>
                {{-- display only --}}
                <textarea rows="3" style="width:520px;background:#f5f5f5;" readonly>{{ $house->address }}</textarea>
                {{-- hidden value for form submit --}}
                <input type="hidden" name="premise_address" value="{{ $house->address }}">
            </td>
        </tr>

        <tr><td colspan="2"><hr></td></tr>

        <tr>
            <td><strong>Start Date</strong></td>
            <td>
                <input type="date" name="start_date" value="{{ old('start_date') }}" required>
            </td>
        </tr>

        <tr>
            <td><strong>End Date</strong></td>
            <td>
                <input type="date" name="end_date" value="{{ old('end_date') }}" required>
            </td>
        </tr>

        <tr>
            <td><strong>Rent Price</strong></td>
            <td>
                <input type="number" step="0.01" name="rent_price" value="{{ old('rent_price', $house->house_rent_price) }}" style="width:180px;">
            </td>
        </tr>

        <tr>
            <td><strong>Deposit</strong></td>
            <td>
                <input type="number" step="0.01" name="deposit_amount" value="{{ old('deposit_amount') }}" style="width:180px;">
            </td>
        </tr>

        <tr>
            <td><strong>Utility Deposit</strong></td>
            <td>
                <input type="number" step="0.01" name="utility_deposit" value="{{ old('utility_deposit') }}" style="width:180px;">
            </td>
        </tr>

        <tr>
            <td><strong>Inventory</strong></td>
            <td>
                <textarea name="inventory" rows="5" style="width:520px;">{{ old('inventory') }}</textarea>
            </td>
        </tr>

        <tr>
            <td><strong>Emergency Contact</strong></td>
            <td>
                <textarea name="emergency_contact" rows="5" style="width:520px;">{{ old('emergency_contact') }}</textarea>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit">Save Agreement</button>
                <a href="{{ route('units.edit', $house->id) }}" style="margin-left:8px;">Cancel</a>
            </td>
        </tr>

    </table>
</form>

@endsection