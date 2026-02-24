@extends('layouts.app')

@section('title','Agreement Template')

@section('content')

    @if(session('success'))
        <div style="padding:10px;border:1px solid #0a0;color:#0a0;margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display:flex;align-items:center;margin-bottom:12px;">
        <h2 style="margin:0;">Agreement Template</h2>

        <div style="margin-left:auto;">
            <a href="{{ route('agreement.template.create') }}">
                <button type="button">Create</button>
            </a>
        </div>
    </div>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
        <thead>
            <tr>
                <th style="width:60px;">No</th>
                <th style="width:240px;">Type of Agreement</th>
                <th>Title</th>
                <th style="width:120px;">Active</th>
                <th style="width:140px;">Action</th>
                <th style="width:120px;">Delete</th>
            </tr>
        </thead>
        <tbody>
            @forelse($templates as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->type_label }}</td>
                    <td>{{ $t->title }}</td>
                    <td>{{ $t->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('agreement.template.edit', $t->id) }}">
                            <button type="button">Edit</button>
                        </a>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('agreement.template.destroy', $t->id) }}"
                            onsubmit="return confirm('Delete template ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
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