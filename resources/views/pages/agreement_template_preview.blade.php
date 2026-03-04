<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Preview - {{ $template->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 20px; }
        .toolbar { display:flex; gap:10px; align-items:center; margin-bottom: 16px; }
        .paper { max-width: 900px; margin: 0 auto; }
        .meta { color:#666; font-size: 12px; margin-bottom: 10px; }

        /* Print settings */
        @media print {
            .toolbar { display:none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

<div class="toolbar">
    <button onclick="window.print()">Print</button>
    <button onclick="window.close()">Close</button>
</div>

<div class="paper">
    <div class="meta">
        <div><strong>Title:</strong> {{ $template->title }}</div>
        <div><strong>Type:</strong> {{ $template->type_label }}</div>
        <div><strong>Active:</strong> {{ $template->is_active ? 'Yes' : 'No' }}</div>
    </div>

    <hr>

    {{-- Content dari TinyMCE (admin input). trusted -> guna {!! !!} --}}
    <div class="content">
        @php

        $content = $template->content;

        if ($template->owner_signature_path) {

            $signature = '<img src="'.asset('storage/'.$template->owner_signature_path).'" style="height:80px;">';

            $content = str_replace('{{tandatangan_penyewa}}', $signature, $content);

        }

        @endphp

        {!! $content !!}
    </div>

    <hr>
</div>

</body>
</html>