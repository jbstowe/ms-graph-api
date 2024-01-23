<?php

namespace Joeystowe\MsGraphApi;

class MsGraphCurrentUserApi
{
    public function __construct(protected String $token)
    {
        $this->token = $token;
    }


    public function me()
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => $this->token,
        ])->get('https://graph.microsoft.com/v1.0/me');

        return $response->json();
    }

    public function groups()
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => $this->token,
        ])->get('https://graph.microsoft.com/v1.0/me/memberOf');

        return $response->json()['value'] ?? [];
    }

    public function inGroup(String $groupId)
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => $this->token,
        ])->get("https://graph.microsoft.com/v1.0/me/memberOf?\$filter=id eq '$groupId'");

        if ($response->failed()) {
            \Illuminate\Support\Facades\Log::warning("invalid request to graph api", [
                'response' => $response->json(),
            ]);
            return false;
        }

        return !empty($response->json()['value'][0] ?? []);
    }
}
