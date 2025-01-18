<?php
namespace Controllers;

use AddLinkRequest;
use Views\AdminPanel;
use BasicAuth;
use Http\IRequest;
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

    public function handle(IRequest $request): Response
    {
        $this->auth->authorise($request);
        return match ($request->method()) {
            "POST" => self::post($request),
            default => self::get(),
        };
    }

    private function post(IRequest $request): Response
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
