<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Search by name, email, subject, or message content
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by status (read/unread)
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'read') {
                $query->where('is_read', true);
            } elseif ($status === 'unread') {
                $query->where('is_read', false);
            }
        }

        $messages = $query->latest()->paginate(15);
        return view('admin.contacts.index', compact('messages'));
    }

    public function show(ContactMessage $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
            ActivityLog::log("قرأ رسالة التواصل الواردة من العميل: {$contact->name}");
        }
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(ContactMessage $contact)
    {
        $sender = $contact->name;
        $contact->delete();

        ActivityLog::log("حذف رسالة التواصل الواردة من العميل: {$sender}");

        return redirect()->route('admin.contacts.index')->with('success', __('messages.message_deleted'));
    }
}
