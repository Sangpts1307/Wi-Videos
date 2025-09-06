<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GoogleHangoutWebhook
{
    // Init Guzzle client
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Service method Report using google hangout webhook
     *
     * @param [string] $msgReport
     * @param [collection] $reporter
     * @return boolean | null
     */
    public function reportForWebHook($msgReport, $reporter)
    {
        $payload = [
            "cardsV2" => [
                [
                    "cardId" => "unique-card-id",
                    "card" => [
                        "header" => [
                            "title" => $$reporter . " tiến hành báo cáo",
                            "subtitle" => "Có báo cáo mới về video vi phạm quy tắc cộng đồng!",
                            "imageUrl" => "https://developers.google.com/workspace/chat/images/quickstart-app-avatar.png",
                            "imageType" => "CIRCLE",
                            "imageAltText" => "Avatar for reporter"
                        ],
                        "sections" => [
                            [
                                "header" => "------",
                                "collapsible" => true,
                                "uncollapsibleWidgetsCount" => 1,
                                "widgets" => [
                                    [
                                        "decoratedText" => [
                                            "startIcon" => [
                                                "knownIcon" => "BOOKMARK"
                                            ],
                                            "text" => $msgReport
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        try {
            $this->client->post(env('GOOGLE_HANGOUT_WEBHOOK'), [
                'json' => $payload,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
