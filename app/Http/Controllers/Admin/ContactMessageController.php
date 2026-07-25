<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReplyContactMessageRequest;
use App\Services\Admin\ContactMessageService;

class ContactMessageController extends Controller
{
    public function __construct(
        protected ContactMessageService $contactMessageService,
    ) {}

    public function index()
    {
        try {
            $messages = $this->contactMessageService->getPaginated();

            return view('admin.contact-messages.index', compact('messages'));

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function show(int $id)
    {
        try {
            $contactMessage = $this->contactMessageService->find($id);
            abort_unless($contactMessage, 404);

            return view('admin.contact-messages.show', compact('contactMessage'));

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function reply(ReplyContactMessageRequest $request, int $id)
    {
        try {
            $contactMessage = $this->contactMessageService->find($id);
            abort_unless($contactMessage, 404);

            $validated      = $request->validated();

            $this->contactMessageService->reply($contactMessage, $validated['reply'], $validated['subject']);

            return back()->with('success', 'Reply sent successfully.');

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
}
