<?php
namespace Controllers;

use AddLinkRequest;
use AdminPanel;
use BasicAuth;
use Http\Request;
use Http\Response;
use Links;
use ServiceLocator;
use Throwable;

class Admin
{
    private BasicAuth $auth;
    private Links $links;

    public function __construct()
    {
        $this->auth = ServiceLocator::get(BasicAuth::class);
        $this->links = ServiceLocator::get(Links::class);
    }

    public function handle(Request $request): Response
    {
        $this->auth->authorise($request);
        return match ($request->method) {
            "POST" => self::post($request),
            default => self::get(),
        };
    }

    private function post(Request $request): Response
    {
        try {
            $dto = AddLinkRequest::fromRequest($request);
            $this->links->set($dto->from, $dto->to);
            $this->links->save();
        } catch (Throwable $error) {
            error_log($error->getMessage());
        }
        return (new AdminPanel())->response();
    }

    private function get(): Response
    {
        return (new AdminPanel())->response();
    }
}
