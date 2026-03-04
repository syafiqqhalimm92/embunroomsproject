<?php

namespace App\Http\Controllers;

use App\Models\AgreementTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AgreementTemplateController extends Controller
{
    public function index()
    {
        $templates = AgreementTemplate::orderBy('id','desc')->get();
        return view('pages.agreement_template', compact('templates'));
    }

    public function edit(AgreementTemplate $template)
    {
        return view('pages.agreement_template_edit', compact('template'));
    }

    public function create()
    {
        return view('pages.agreement_template_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:to_owner,to_tenants',
            'title' => 'required|string|max:255',
        ]);

        $template = AgreementTemplate::create([
            'type' => $data['type'],
            'title' => $data['title'],
            'content' => '',
            'is_active' => true,
        ]);

        return redirect()->route('agreement.template.edit', $template->id)
            ->with('success', 'Template created. Sila isi content.');
    }

    public function update(Request $request, AgreementTemplate $template)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'is_active' => 'nullable|boolean',

            // signature dataURL dari canvas (optional)
            'owner_signature_data' => 'nullable|string',
            'remove_owner_signature' => 'nullable|boolean',
        ]);

        // checkbox active
        $data['is_active'] = $request->has('is_active');

        // ===== 1) Remove signature (if checked) =====
        if ($request->has('remove_owner_signature')) {
            if ($template->owner_signature_path) {
                Storage::disk('public')->delete($template->owner_signature_path);
            }
            $data['owner_signature_path'] = null;
            $data['owner_signature_updated_at'] = null;
        }

        // ===== 2) Save signature ONLY if user actually draws =====
        // (Jika canvas kosong, JS sepatutnya hantar empty string. Tapi kita guard juga di backend.)
        $sig = $request->input('owner_signature_data');

        if (!$request->has('remove_owner_signature') && !empty($sig) && str_starts_with($sig, 'data:image')) {

            // expected: data:image/png;base64,xxxx
            $parts = explode(',', $sig, 2);
            if (count($parts) === 2) {
                [$meta, $content] = $parts;
                $binary = base64_decode($content);

                // Guard: pastikan decode ok & bukan "blank png"
                // blank signature biasanya sangat kecil. Adjust threshold jika perlu.
                if ($binary !== false && strlen($binary) > 500) {

                    // delete lama
                    if ($template->owner_signature_path) {
                        Storage::disk('public')->delete($template->owner_signature_path);
                    }

                    $filename = 'signatures/templates/' . $template->id . '_' . Str::random(10) . '.png';
                    Storage::disk('public')->put($filename, $binary);

                    $data['owner_signature_path'] = $filename;
                    $data['owner_signature_updated_at'] = now();
                }
            }
        }

        // jangan simpan dataURL dalam DB
        unset($data['owner_signature_data']);

        $template->update($data);

        return redirect()
            ->route('agreement.template')
            ->with('success', 'Template updated.');
    }
    
    public function preview(AgreementTemplate $template)
    {
        return view('pages.agreement_template_preview', compact('template'));
    }

    public function destroy(AgreementTemplate $template)
    {
        $template->delete();
        return redirect()->route('agreement.template')->with('success', 'Template deleted.');
    }
}