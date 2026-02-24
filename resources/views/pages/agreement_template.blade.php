@extends('layouts.app')

@section('title','Agreement Template')

@section('content')
    <h2>Agreement Template</h2>

    @if(session('success'))
        <div style="padding:10px;border:1px solid #0a0;color:#0a0;margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
        <thead>
            <tr>
                <th style="width:60px;">No</th>
                <th style="width:240px;">Type of Agreement</th>
                <th>Title</th>
                <th style="width:120px;">Active</th>
                <th style="width:140px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($templates as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        @if($t->type === 'owner_to_business')
                            Tn Rumah (Owner → Business)
                        @elseif($t->type === 'business_to_tenant')
                            Our Tenants (Business → Tenant)
                        @else
                            {{ $t->type }}
                        @endif
                    </td>
                    <td>{{ $t->title }}</td>
                    <td>{{ $t->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('agreement.template.edit', $t->id) }}">
                            <button type="button">Edit</button>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tiada template lagi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection