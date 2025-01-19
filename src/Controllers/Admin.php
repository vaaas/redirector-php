<?php
namespace Controllers;

use BasicAuth;
use DTO\AddLinkRequest;
use DTO\DeleteLinkRequest;
use Exception;
use Http\IRequest;
use Http\Response;
use Links;
use ServiceLocator;
use Throwable;
use Views\AdminPanel;

/** @immutable */
final class Admin
{
    private readonly BasicAuth $auth;
    private readonly Links $links;

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
            if ($request->query("add") === "") {
                $this->add($request);
            } elseif ($request->query("delete") === "") {
                $this->delete($request);
            } else {
                throw new Exception();
            }
        } catch (Throwable $error) {
            error_log($error->getMessage());
        }
        return Response::redirect("/");
    }

    private function add(IRequest $request): void
    {
        $dto = AddLinkRequest::fromRequest($request);
        $this->links->set($dto->from, $dto->to);
    }

    private function delete(IRequest $request): void
    {
        $dto = DeleteLinkRequest::fromRequest($request);
        $this->links->delete($dto->entry);
    }

    private function get(): Response
    {
        return (new AdminPanel())->response();
    }
}
