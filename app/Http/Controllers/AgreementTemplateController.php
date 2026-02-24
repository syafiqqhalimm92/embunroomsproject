<?php

namespace App\Http\Controllers;

use App\Models\AgreementTemplate;
use Illuminate\Http\Request;

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
            'content' => 'nullable|string', // TinyMCE HTML
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $template->update($data);

        return redirect()->route('agreement.template')->with('success', 'Template updated.');
    }

    public function destroy(AgreementTemplate $template)
    {
        $template->delete();
        return redirect()->route('agreement.template')->with('success', 'Template deleted.');
    }
}