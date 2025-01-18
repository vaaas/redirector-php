<?php
namespace Controllers;

use AddLinkRequest;
use AdminPanel;
use BasicAuth;
use Http\Request;
use Http\Response;
use Links;
use Throwable;

class Admin
{
    public static function handle(Request $request): Response
    {
        BasicAuth::authorise($request);
        return match ($request->method) {
            "POST" => self::post($request),
            default => self::get(),
        };
    }

    private static function post(Request $request): Response
    {
        $links = Links::load();
        try {
            $dto = AddLinkRequest::fromRequest($request);
            $links->set($dto->from, $dto->to);
            $links->save();
        } catch (Throwable $error) {
            error_log($error->getMessage());
        }
        return (new AdminPanel($links->entries))->response();
    }

    private static function get(): Response
    {
        $links = Links::load();
        return (new AdminPanel($links->entries))->response();
    }
}
