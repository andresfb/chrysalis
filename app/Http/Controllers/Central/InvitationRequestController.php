<?php

namespace App\Http\Controllers\Central;

use App\DataTransferObjects\InvitationRequestDto;
use App\Helpers\ClientIp;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationRequest;
use App\Services\Central\InvitationService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

// TODO test all the invitation processes
// TODO run migration fresh

class InvitationRequestController extends Controller
{
    public function __construct(private readonly ClientIp $clientIp)
    {
    }

    public function show()
    {
        return view('central.invitation.show')
            ->with('hasCaptcha', $this->hasCaptchaFlag())
            ->with('message', session('message'));
    }

    public function store(InvitationRequest $request, InvitationService $service)
    {
        if ($this->hasCaptchaFlag()) {
            $validator = Validator::make($request->all(), [
                'h-captcha-response' => 'required|HCaptcha',
            ]);

            if ($validator->fails()) {
                return redirect('post/create')->withErrors($validator);
            }
        }

        $dto = InvitationRequestDto::fromRequest($request);
        [$result, $link] = $service->check($dto);
        if (!$result) {
            $this->setCaptchaFlag();

            return redirect($link);
        }

        $service->sendRequest($dto);

        $this->removeCaptchaFlag();
        session()->flash('message', 'Your request has been sent. We will contact you shortly.');

        return redirect()->route('invitation.show');
    }

    private function setCaptchaFlag(): void
    {
        $key = $this->getCaptchaKey();
        Cache::put($key, true, now()->addMinutes(15));
        session()->put('captcha', true);
    }

    private function removeCaptchaFlag(): void
    {
        session()->remove('captcha');
        $key = $this->getCaptchaKey();
        Cache::forget($key);
    }

    private function hasCaptchaFlag(): bool
    {
        if (session()->has('captcha')) {
            return true;
        }

        $key = $this->getCaptchaKey();

        return Cache::has($key);
    }

    private function getCaptchaKey(): string
    {
        return md5('LOGIN:CAPTCHA:'.$this->clientIp->getClientIp());
    }
}
