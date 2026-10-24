<?php

namespace App\Http\Controllers;

use App\Models\AiWealthInquiry;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class AiWealthInquiryController extends Controller
{
    public function save(Request $request)
    {
        $profession = $request->input('profession', $request->input('Profession'));
        $request->merge([
            'profession' => $profession ?: null,
            'email' => $request->filled('email') ? $request->email : null,
            'inquiry_id' => $request->filled('inquiry_id') ? $request->inquiry_id : null,
        ]);

        $request->validate([
            'fullName' => 'required|string|min:3|max:80',
            'mobile' => 'required|digits:10',
            'email' => 'nullable|email|max:120',
            'profession' => 'nullable|string|max:50',
            'ageGroup' => 'nullable|string|max:20',
            'challenge' => 'nullable|string|max:50',
            'currentIncome' => 'nullable|string|max:50',
            'source' => 'nullable|string|max:30',
            'page' => 'nullable|string|max:120',
            'inquiry_id' => 'nullable|integer',
        ]);

        $isSubmitted = $request->boolean('submitted');
        $mobile = $request->mobile;
        $page = $request->input('page', 'ai-wealth-business-growth-accelerator');
        $inquiry = null;

        if ($request->filled('inquiry_id')) {
            $inquiry = AiWealthInquiry::where('id', $request->inquiry_id)->first();
        }

        if (!$inquiry) {
            $inquiry = AiWealthInquiry::where('page', $page)
                ->where('mobile', $mobile)
                ->latest('id')
                ->first();
        }

        $payload = [
            'name' => trim($request->fullName),
            'mobile' => $mobile,
            'page' => $page,
            'source' => $request->source,
            'ip_address' => $request->ip(),
        ];

        if ($isSubmitted) {
            $payload['email'] = $request->email;
            $payload['profession'] = $request->profession;
            $payload['age_group'] = $request->ageGroup;
            $payload['challenge'] = $request->challenge;
            $payload['current_income'] = $request->currentIncome;
            $payload['status'] = 'submitted';
        } elseif (!$inquiry || $inquiry->status !== 'submitted') {
            $payload['status'] = 'partial';
        }

        if ($inquiry) {
            $inquiry->update($payload);
        } else {
            $payload['status'] = $payload['status'] ?? ($isSubmitted ? 'submitted' : 'partial');
            $inquiry = AiWealthInquiry::create($payload);
        }

        $inquiry->refresh();

        if ($isSubmitted) {
            WhatsAppService::sendInquiryMessage($inquiry);
        }

        return response()->json([
            'success' => true,
            'inquiry_id' => $inquiry->id,
            'status' => $inquiry->status,
        ]);
    }
}
