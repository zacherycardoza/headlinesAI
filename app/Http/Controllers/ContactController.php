<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            Mail::to('zachary@cardoza.ca')->send(new ContactFormMail($validated));

            return redirect()->to(url()->previous() . '#contact')
                ->with('success', 'Your message has been sent!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->to(url()->previous() . '#contact')
                ->with('error', 'Failed to send message. Please try again.');
        }
    }
}
