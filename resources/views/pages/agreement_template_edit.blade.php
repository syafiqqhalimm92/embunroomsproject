@extends('layouts.app')

@section('title','Edit Agreement Template')

@section('content')

<h2>Edit Agreement Template</h2>

<div style="margin-bottom:10px;">
    <a href="{{ route('agreement.template') }}">
        <button type="button">← Back</button>
    </a>
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


<form id="templateForm" method="POST" action="{{ route('agreement.template.update', $template->id) }}">
@csrf
@method('PUT')

<div style="margin-bottom:10px;">
    <label><strong>Title</strong></label><br>
    <input type="text" name="title" value="{{ old('title', $template->title) }}" style="width:420px;">
</div>


<div style="margin-bottom:10px;">
<label><strong>Agreement Content</strong></label><br>

{{-- Placeholder Panel --}}
<div style="border:1px solid #ddd; padding:10px; margin:10px 0; background:#fafafa;">
    <strong>Available Placeholders</strong>
    <div style="color:#666; font-size:12px; margin-top:4px;">
        Klik placeholder untuk copy. Lepas tu paste dalam content template.
    </div>

    @php
        if ($template->type === 'to_tenants') {
            $placeholders = [
                '{{agreement_date}}' => 'Tarikh agreement',
                '{{tenant_name}}' => 'Nama tenant',
                '{{tenant_ic}}' => 'IC tenant',
                '{{tenant_phone}}' => 'Telefon tenant',
                '{{house_address}}' => 'Alamat rumah',
                '{{room_name}}' => 'Nama bilik',
                '{{start_date}}' => 'Tarikh mula',
                '{{end_date}}' => 'Tarikh tamat',
                '{{rental_duration}}' => 'Tempoh sewaan',
                '{{monthly_rent}}' => 'Sewa bulanan',
                '{{security_deposit}}' => 'Deposit sekuriti',
                '{{agreement_fee}}' => 'Yuran agreement',
                '{{kunci_tenant}}' => 'Bilangan kunci tenant',
                '{{electric_has_limit}}' => 'Electric ada limit',
                '{{electric_free_kwh}}' => 'Electric free kwh',
                '{{electric_extra_rate}}' => 'Electric extra rate',
                '{{electric_min_charge}}' => 'Electric min charge',
                '{{electric_current_reading}}' => 'Electric current reading',
                '{{electric_reading_date}}' => 'Electric reading date',
                '{{tenant_signature}}' => 'Signature tenant',
                '{{owner_signature}}' => 'Signature owner',
                '{{gambar_ic_tenant_depan}}' => 'IC tenant depan',
                '{{gambar_ic_tenant_belakang}}' => 'IC tenant belakang',
            ];
        } else {
            $placeholders = [
                '{{tarikh_perjanjian}}' => 'Tarikh perjanjian',
                '{{tuan_rumah_nama}}' => 'Nama tuan rumah',
                '{{tuan_rumah_ic}}' => 'No IC tuan rumah',
                '{{tuan_rumah_telefon}}' => 'Telefon tuan rumah',
                '{{bank_akaun_no}}' => 'No akaun bank',
                '{{bank_nama}}' => 'Nama bank',
                '{{alamat_premis}}' => 'Alamat premis',
                '{{tempoh_sewaan}}' => 'Tempoh sewaan',
                '{{tarikh_mula}}' => 'Tarikh mula sewa',
                '{{tarikh_tamat}}' => 'Tarikh tamat sewa',
                '{{sewa_bulanan}}' => 'Sewa bulanan',
                '{{deposit_sekuriti}}' => 'Deposit sekuriti',
                '{{deposit_utiliti}}' => 'Deposit utiliti',
                '{{tandatangan_tnrumah}}' => 'Signature tuan rumah',
                '{{senarai_inventori}}' => 'Senarai inventori',
                '{{inventori_ulasan_lain}}' => 'Ulasan inventori',
                '{{emergency_contact}}' => 'Emergency contact',
            ];
        }
    @endphp

    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:10px;">
        @foreach($placeholders as $ph => $label)
            <button
                type="button"
                class="ph-btn"
                data-placeholder='@json($ph)'
                title="{{ $label }}"
                style="padding:6px 10px; border:1px solid #ccc; background:#fff; cursor:pointer;"
            >
                {{ $ph }}
            </button>
        @endforeach
    </div>

    <div id="phCopiedMsg" style="display:none; margin-top:10px; color:green; font-size:12px;">
        Copied!
    </div>
</div>


<textarea id="contentEditor" name="content" rows="18" style="width:100%;">
    {{ old('content', $template->content) }}
</textarea>

<small style="color:#666;">
    Tip: boleh guna bold, table, bullet, dan lain-lain.
</small>

</div>


<div style="margin-bottom:10px;">
<label>
<input type="checkbox" name="is_active" value="1" @checked(old('is_active', $template->is_active))>
Active
</label>
</div>


<hr>


<h3>Owner Signature (E-Signature)</h3>

@if($template->owner_signature_path)

<div style="margin-bottom:10px;">
<div>Current signature:</div>

<img
src="{{ asset('storage/'.$template->owner_signature_path) }}"
style="max-width:300px;border:1px solid #ccc;padding:8px;"
alt="Owner signature">

<div style="margin-top:8px;">
<label>
<input type="checkbox" name="remove_owner_signature" value="1">
Remove current signature
</label>
</div>

</div>

@endif


<canvas id="sigPad" width="420" height="180" style="border:1px solid #333;background:#fff;"></canvas>

<br>

<button type="button" id="sigClear">Clear</button>

<input type="hidden" name="owner_signature_data" id="owner_signature_data">


<div style="margin-top:18px;">
<button type="submit">Save Template</button>
</div>

</form>


{{-- TinyMCE --}}
<script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js"></script>

<script>

tinymce.init({
    selector:'#contentEditor',
    height:520,
    menubar:true,
    plugins:'lists link table code',
    toolbar:'undo redo | bold italic underline | bullist numlist | link table | code'
});

</script>



{{-- Placeholder Copy --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const msg = document.getElementById('phCopiedMsg');

    document.querySelectorAll('.ph-btn').forEach(function (btn) {
        btn.addEventListener('click', async function () {
            const placeholder = JSON.parse(this.dataset.placeholder);

            try {
                await navigator.clipboard.writeText(placeholder);
            } catch (err) {
                const temp = document.createElement('textarea');
                temp.value = placeholder;
                document.body.appendChild(temp);
                temp.select();
                document.execCommand('copy');
                document.body.removeChild(temp);
            }

            if (msg) {
                msg.style.display = 'block';
                setTimeout(function () {
                    msg.style.display = 'none';
                }, 1000);
            }
        });
    });
});
</script>



{{-- Signature Pad --}}
<script>

document.addEventListener('DOMContentLoaded',function(){

    const canvas=document.getElementById('sigPad');
    if(!canvas) return;

    const ctx=canvas.getContext('2d');
    let drawing=false;

    function pos(e){

        const rect=canvas.getBoundingClientRect();

        const clientX=(e.touches?e.touches[0].clientX:e.clientX);
        const clientY=(e.touches?e.touches[0].clientY:e.clientY);

        return{
        x:clientX-rect.left,
        y:clientY-rect.top
        };

    }

    function start(e){

        drawing=true;

        const p=pos(e);

        ctx.beginPath();
        ctx.moveTo(p.x,p.y);

    }

    function move(e){

        if(!drawing) return;

        e.preventDefault();

        const p=pos(e);

        ctx.lineWidth=2;
        ctx.lineCap='round';

        ctx.lineTo(p.x,p.y);
        ctx.stroke();

    }

    function end(){ drawing=false; }

        canvas.addEventListener('mousedown',start);
        canvas.addEventListener('mousemove',move);
        window.addEventListener('mouseup',end);

        canvas.addEventListener('touchstart',start,{passive:false});
        canvas.addEventListener('touchmove',move,{passive:false});
        window.addEventListener('touchend',end);


        document.getElementById('sigClear').addEventListener('click',function(){

        ctx.clearRect(0,0,canvas.width,canvas.height);

    });


    function isBlank(c){

        const px=new Uint32Array(
        c.getContext('2d').getImageData(0,0,c.width,c.height).data.buffer
        );

        return !px.some(v=>v!==0);

    }


    document.getElementById('templateForm').addEventListener('submit',function(){

            const hidden=document.getElementById('owner_signature_data');

            if(isBlank(canvas)){
                hidden.value='';
                return;
            }

        hidden.value=canvas.toDataURL('image/png');

    });

});

</script>


@endsection