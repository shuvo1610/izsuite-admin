<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactMessages\StoreContactMessageRequest;
use App\Http\Resources\ContactMessages\ContactMessageResource;
use App\Services\Api\ContactMessages\ContactMessageService;
use Illuminate\Http\JsonResponse;

class ContactMessageController extends Controller
{
    public function __construct(
        protected ContactMessageService $contactMessageService,
    ) {}

    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        try {
            $contactMessage = $this->contactMessageService->create($request->validated(), $request->user());

            return response()->json([
                'message'         => 'Your message has been sent successfully.',
                'contact_message' => new ContactMessageResource($contactMessage),
            ], 201);

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
}
