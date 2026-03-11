<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\OwnerAgreement;
use App\Models\AgreementTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OwnerAgreementController extends Controller
{
    public function create(House $house)
    {
        $templates = AgreementTemplate::where('type', 'to_owner')->get();

        return view('owner_agreements.create', compact('house', 'templates'));
    }

    public function store(Request $request, House $house)
    {
        $data = $this->validateAgreement($request);

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $months = $start->diffInMonths($end) + 1;

        OwnerAgreement::create([
            'house_id' => $house->id,
            'agreement_template_id' => $data['agreement_template_id'],

            'agreement_date' => $data['agreement_date'],

            'owner_name' => $data['owner_name'] ?? null,
            'owner_ic' => $data['owner_ic'] ?? null,
            'owner_phone' => $data['owner_phone'] ?? null,

            'bank_name' => $data['bank_name'] ?? null,
            'bank_account_no' => $data['bank_account_no'] ?? null,

            'premise_address' => $data['premise_address'] ?? null,

            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'tenancy_period_month' => $months,

            'rent_price' => $data['rent_price'] ?? null,
            'deposit_amount' => $data['deposit_amount'] ?? null,
            'utility_deposit' => $data['utility_deposit'] ?? null,

            'inventory' => $data['inventory'] ?? null,
            'emergency_contact' => $data['emergency_contact'] ?? null,

            'sign_token' => (string) Str::uuid(),
            'status' => 'draft',
        ]);

        return redirect()
            ->route('units.edit', $house->id)
            ->with('success', 'Owner agreement created successfully.');
    }

    public function edit(House $house, OwnerAgreement $ownerAgreement)
    {
        if ($ownerAgreement->house_id != $house->id) {
            abort(404);
        }

        $templates = AgreementTemplate::where('type', 'to_owner')->get();

        return view('owner_agreements.edit', compact('house', 'ownerAgreement', 'templates'));
    }

    public function update(Request $request, House $house, OwnerAgreement $ownerAgreement)
    {
        if ($ownerAgreement->house_id != $house->id) {
            abort(404);
        }

        $data = $this->validateAgreement($request);

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $months = $start->diffInMonths($end) + 1;

        $ownerAgreement->update([
            'agreement_template_id' => $data['agreement_template_id'],

            'agreement_date' => $data['agreement_date'],

            'owner_name' => $data['owner_name'] ?? null,
            'owner_ic' => $data['owner_ic'] ?? null,
            'owner_phone' => $data['owner_phone'] ?? null,

            'bank_name' => $data['bank_name'] ?? null,
            'bank_account_no' => $data['bank_account_no'] ?? null,

            'premise_address' => $data['premise_address'] ?? null,

            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'tenancy_period_month' => $months,

            'rent_price' => $data['rent_price'] ?? null,
            'deposit_amount' => $data['deposit_amount'] ?? null,
            'utility_deposit' => $data['utility_deposit'] ?? null,

            'inventory' => $data['inventory'] ?? null,
            'emergency_contact' => $data['emergency_contact'] ?? null,
        ]);

        return redirect()
            ->route('units.edit', $house->id)
            ->with('success', 'Owner agreement updated successfully.');
    }

    public function preview(House $house, OwnerAgreement $ownerAgreement)
    {
        if ($ownerAgreement->house_id != $house->id) {
            abort(404);
        }

        $ownerAgreement->load('template');

        if (!$ownerAgreement->template) {
            abort(404, 'Agreement template not found.');
        }

        $renderedContent = $this->renderAgreementContent($ownerAgreement);

        return view('owner_agreements.preview', compact('house', 'ownerAgreement', 'renderedContent'));
    }

    public function signPage($token)
    {
        $ownerAgreement = OwnerAgreement::with('template', 'house')
            ->where('sign_token', $token)
            ->firstOrFail();

        if (!$ownerAgreement->template) {
            abort(404, 'Agreement template not found.');
        }

        $renderedContent = $this->renderAgreementContent($ownerAgreement);

        return view('owner_agreements.sign', compact('ownerAgreement', 'renderedContent'));
    }

    public function submitSignature(Request $request, $token)
    {
        $ownerAgreement = OwnerAgreement::where('sign_token', $token)->firstOrFail();

        $request->validate([
            'owner_signature_data' => ['required', 'string'],
        ]);

        $signatureData = $request->owner_signature_data;

        if (!preg_match('/^data:image\/png;base64,/', $signatureData)) {
            return back()->withErrors([
                'owner_signature_data' => 'Invalid signature format.'
            ]);
        }

        $signatureData = substr($signatureData, strpos($signatureData, ',') + 1);
        $signatureData = base64_decode($signatureData);

        if ($signatureData === false) {
            return back()->withErrors([
                'owner_signature_data' => 'Failed to decode signature image.'
            ]);
        }

        $fileName = 'owner-signatures/' . uniqid('owner_sig_') . '.png';
        Storage::disk('public')->put($fileName, $signatureData);

        if ($ownerAgreement->owner_signature_path) {
            Storage::disk('public')->delete($ownerAgreement->owner_signature_path);
        }

        $ownerAgreement->update([
            'owner_signature_path' => $fileName,
            'owner_signed_at' => now(),
            'status' => 'signed',
        ]);

        return redirect()
            ->route('owner-agreements.sign-page', ['token' => $ownerAgreement->sign_token])
            ->with('success', 'Agreement signed successfully.');
    }

    public function saveOwnerSignature(Request $request, House $house, OwnerAgreement $ownerAgreement)
    {
        if ($ownerAgreement->house_id != $house->id) {
            abort(404);
        }

        $request->validate([
            'owner_signature_data' => ['required', 'string'],
        ]);

        $signatureData = $request->owner_signature_data;

        if (!preg_match('/^data:image\/png;base64,/', $signatureData)) {
            return back()->withErrors([
                'owner_signature_data' => 'Invalid signature format.'
            ]);
        }

        $signatureData = substr($signatureData, strpos($signatureData, ',') + 1);
        $signatureData = base64_decode($signatureData);

        if ($signatureData === false) {
            return back()->withErrors([
                'owner_signature_data' => 'Failed to decode signature image.'
            ]);
        }

        $fileName = 'owner-signatures/' . uniqid('owner_sig_') . '.png';
        Storage::disk('public')->put($fileName, $signatureData);

        if ($ownerAgreement->owner_signature_path) {
            Storage::disk('public')->delete($ownerAgreement->owner_signature_path);
        }

        $ownerAgreement->update([
            'owner_signature_path' => $fileName,
        ]);

        return back()->with('success', 'Owner signature saved successfully.');
    }

    private function validateAgreement(Request $request): array
    {
        return $request->validate([
            'agreement_date' => 'required|date',
            'agreement_template_id' => 'required|exists:agreement_templates,id',

            'owner_name' => 'nullable|string|max:255',
            'owner_ic' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:255',

            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:255',

            'premise_address' => 'nullable|string',

            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',

            'rent_price' => 'required|numeric',
            'deposit_amount' => 'nullable|numeric',
            'utility_deposit' => 'nullable|numeric',

            'inventory' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
        ]);
    }

    private function renderAgreementContent(OwnerAgreement $ownerAgreement): string
    {
        $content = $ownerAgreement->template->content ?? '';

        $replacements = [
            '{{tarikh_perjanjian}}'   => optional($ownerAgreement->agreement_date)->format('d/m/Y') ?? '',
            '{{tuan_rumah_nama}}'     => $ownerAgreement->owner_name ?? '',
            '{{tuan_rumah_ic}}'       => $ownerAgreement->owner_ic ?? '',
            '{{tuan_rumah_telefon}}'  => $ownerAgreement->owner_phone ?? '',
            '{{bank_nama}}'           => $ownerAgreement->bank_name ?? '',
            '{{bank_akaun_no}}'       => $ownerAgreement->bank_account_no ?? '',
            '{{alamat_premis}}'       => nl2br(e($ownerAgreement->premise_address ?? '')),
            '{{tarikh_mula}}'         => optional($ownerAgreement->start_date)->format('d/m/Y') ?? '',
            '{{tarikh_tamat}}'        => optional($ownerAgreement->end_date)->format('d/m/Y') ?? '',
            '{{tempoh_sewaan}}'       => (int) $ownerAgreement->tenancy_period_month,
            '{{sewa_bulanan}}'        => number_format((float)($ownerAgreement->rent_price ?? 0), 2),
            '{{deposit_sekuriti}}'    => number_format((float)($ownerAgreement->deposit_amount ?? 0), 2),
            '{{deposit_utiliti}}'     => number_format((float)($ownerAgreement->utility_deposit ?? 0), 2),
            '{{senarai_inventori}}'   => nl2br(e($ownerAgreement->inventory ?? '')),
            '{{emergency_contact}}'   => nl2br(e($ownerAgreement->emergency_contact ?? '')),

            '{{tandatangan_tnrumah}}' => $ownerAgreement->owner_signature_path
                ? '<img src="' . asset('storage/' . $ownerAgreement->owner_signature_path) . '" style="max-height:100px;">'
                : '',

            '{{tandatangan_penyewa}}' => $ownerAgreement->template && $ownerAgreement->template->owner_signature_path
                ? '<img src="' . asset('storage/' . $ownerAgreement->template->owner_signature_path) . '" style="max-height:100px;">'
                : '',
        ];

        $renderedContent = strtr($content, $replacements);

        // buang placeholder yang masih tinggal
        $renderedContent = preg_replace('/{{.*?}}/', '', $renderedContent);

        // buang <p> kosong dari TinyMCE
        $renderedContent = preg_replace('/<p>\s*<\/p>/', '', $renderedContent);

        return $renderedContent;
    }
}