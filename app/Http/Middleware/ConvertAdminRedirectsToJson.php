<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Symfony\Component\HttpFoundation\Response;

/**
 * For AJAX writes in admin panel, convert redirect+flash responses into JSON.
 *
 * This lets the frontend show validation/business errors without a full reload
 * while preserving legacy controller return patterns (redirect()->with(...)).
 */
class ConvertAdminRedirectsToJson
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldConvert($request, $response)) {
            return $response;
        }

        if (! $request->hasSession()) {
            return response()->json($this->successPayload($request, $response));
        }

        $session  = $request->session();
        $flashed  = $this->flashedKeys($session->get('_flash.new'));

        if (in_array('errors', $flashed, true)) {
            $errors = $this->extractValidationErrors($session->get('errors'));

            return response()->json([
                'message' => $session->get('error') ?: 'Please fix the highlighted fields.',
                'errors'  => $errors,
            ], 422);
        }

        if (in_array('error', $flashed, true)) {
            $errorMessage = $session->get('error');

            return response()->json([
                'message' => is_string($errorMessage) && $errorMessage !== ''
                    ? $errorMessage
                    : 'Request failed.',
            ], 400);
        }

        $payload  = $this->successPayload($request, $response);

        if (in_array('success', $flashed, true)) {
            $successMessage = $session->get('success');
            if (is_string($successMessage) && $successMessage !== '') {
                $payload['message'] = $successMessage;
            }
        }

        return response()->json($payload);
    }

    private function shouldConvert(Request $request, Response $response): bool
    {
        $isAdminRoute = $request->is('admin') || $request->is('admin/*');

        if (! $request->isMethod('post') || ! $isAdminRoute) {
            return false;
        }

        if (! ($request->ajax() || $request->expectsJson())) {
            return false;
        }

        return $response instanceof RedirectResponse;
    }

    private function successPayload(Request $request, RedirectResponse $response): array
    {
        $target = $response->getTargetUrl();

        return [
            'success'  => true,
            'message'  => 'Request completed successfully.',
            // Always return controller-intended redirect target.
            'redirect' => $target ?: null,
        ];
    }

    /**
     * @param  mixed  $value
     */
    private function flashedKeys($value): array
    {
        return is_array($value) ? $value : [];
    }

    /**
     * @param  mixed  $errors
     */
    private function extractValidationErrors($errors): array
    {
        if (! $errors instanceof ViewErrorBag) {
            return [];
        }

        $messages = [];

        foreach ($errors->getBags() as $bag) {
            if (! $bag instanceof MessageBag) {
                continue;
            }

            foreach ($bag->getMessages() as $field => $fieldMessages) {
                if (! isset($messages[$field])) {
                    $messages[$field] = [];
                }

                foreach ((array) $fieldMessages as $message) {
                    $messages[$field][] = (string) $message;
                }
            }
        }

        return $messages;
    }
}
