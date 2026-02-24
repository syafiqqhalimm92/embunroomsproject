<?php

namespace App\Http\Controllers;

use App\Models\AgreementTemplate;
use Illuminate\Http\Request;

class AgreementTemplateController extends Controller
{
    public function index()
    {
        // Pastikan 2 rekod default wujud
        AgreementTemplate::firstOrCreate(
            ['type' => 'owner_to_business'],
            ['title' => 'Template Tn Rumah', 'content' => '', 'is_active' => true]
        );

        AgreementTemplate::firstOrCreate(
            ['type' => 'business_to_tenant'],
            ['title' => 'Template Our Tenants', 'content' => '', 'is_active' => true]
        );

        $templates = AgreementTemplate::orderBy('id')->get();

        return view('pages.agreement_template', compact('templates'));
    }

    public function edit(AgreementTemplate $template)
    {
        return view('pages.agreement_template_edit', compact('template'));
    }

    public function update(Request $request, AgreementTemplate $template)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string', // TinyMCE HTML
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $template->update($data);

        return redirect()->route('agreement.template')->with('success', 'Template updated.');
    }
}