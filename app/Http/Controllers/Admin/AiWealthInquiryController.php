<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiWealthInquiry;
use App\Services\AiWealthLeadImporter;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class AiWealthInquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = AiWealthInquiry::query();

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59',
            ]);
        } elseif ($request->filled('from_date')) {
            $query->where('created_at', '>=', $request->from_date . ' 00:00:00');
        } elseif ($request->filled('to_date')) {
            $query->where('created_at', '<=', $request->to_date . ' 23:59:59');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('mobile', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('profession')) {
            $query->where('profession', $request->profession);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('page')) {
            if ($request->page === 'ai-wealth-business-growth-accelerator') {
                $query->whereIn('page', [
                    'ai-wealth-business-growth-accelerator',
                    'ai-wealth-business',
                ]);
            } else {
                $query->where('page', $request->page);
            }
        }

        $inquiries = $query->latest()->get();

        return view('admin.ai-wealth-crm.inquiries', compact('inquiries'));
    }

    public function import(Request $request, AiWealthLeadImporter $importer)
    {
        $request->validate([
            'excel' => 'required|file|max:5120',
        ], [
            'excel.required' => 'Please choose an Excel / CSV file.',
        ]);

        try {
            $result = $importer->import($request->file('excel'));
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.ai-wealth-crm.inquiries')
                ->with('error', $e->getMessage());
        }

        $message = "Imported {$result['imported']} leads. "
            . "Skipped {$result['duplicates']} duplicates. "
            . "Invalid {$result['invalid']}. "
            . "WhatsApp sent {$result['whatsappSent']}.";

        return redirect()
            ->route('admin.ai-wealth-crm.inquiries')
            ->with('success', $message);
    }

    public function sendWhatsapp()
    {
        $result = WhatsAppService::sendCongratulationsToAll();

        $message = "WhatsApp sent {$result['sent']}. "
            . "Already sent {$result['skipped']}. "
            . "Failed {$result['failed']}.";

        return redirect()
            ->route('admin.ai-wealth-crm.inquiries')
            ->with('success', $message);
    }
}
