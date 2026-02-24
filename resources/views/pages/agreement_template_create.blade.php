@extends('layouts.app')

@section('title','Create Agreement Template')

@section('content')
    <h2>Create Agreement Template</h2>

    <div style="margin-bottom:10px;">
        <a href="{{ route('agreement.template') }}"><button type="button">← Back</button></a>
    </div>

    @if ($errors->any())
        <div style="padding:10px;border:1px solid #a00;color:#a00;margin-bottom:10px;">
            <ul style="margin:0 0 0 15px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('agreement.template.store') }}">
        @csrf

        <div style="margin-bottom:10px;">
            <label><strong>Type of Agreement</strong></label><br>
            <select name="type" required>
                <option value="">-- Select Type --</option>
                <option value="to_owner" @selected(old('type')==='to_owner')>To Owner</option>
                <option value="to_tenants" @selected(old('type')==='to_tenants')>To Tenants</option>
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label><strong>Title</strong></label><br>
            <input type="text" name="title" value="{{ old('title') }}" required style="width:420px;">
        </div>

        <button type="submit">Create Template</button>
    </form>
@endsection