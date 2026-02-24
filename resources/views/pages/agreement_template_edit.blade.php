@extends('layouts.app')

@section('title','Edit Agreement Template')

@section('content')
    <h2>Edit Agreement Template</h2>

    <div style="margin-bottom:10px;">
        <a href="{{ route('agreement.template') }}"><button type="button">← Back</button></a>
    </div>

    <div style="padding:10px;border:1px solid #ddd;margin-bottom:12px;">
        <strong>Type:</strong> {{ $template->type_label }}
    </div>

    @if ($errors->any())
        <div style="padding:10px;border:1px solid #a00;color:#a00;margin-bottom:10px;">
            <strong>There were some errors:</strong>
            <ul style="margin:5px 0 0 15px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('agreement.template.update', $template->id) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom:10px;">
            <label><strong>Title</strong></label><br>
            <input type="text" name="title" value="{{ old('title', $template->title) }}" style="width:420px;">
        </div>

        <div style="margin-bottom:10px;">
            <label><strong>Agreement Content</strong></label><br>
            <textarea id="contentEditor" name="content" rows="18" style="width:100%;">{{ old('content', $template->content) }}</textarea>
            <small style="color:#666;">Tip: boleh guna bold, table, bullet, dan lain-lain.</small>
        </div>

        <div style="margin-bottom:10px;">
            <label>
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $template->is_active))>
                Active
            </label>
        </div>

        <button type="submit">Save Template</button>
    </form>

    {{-- TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#contentEditor',
            height: 520,
            menubar: true,
            plugins: 'lists link table code',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link table | code',
        });
    </script>
@endsection