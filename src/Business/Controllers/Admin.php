<?php
namespace Business\Controllers;

use Business\BasicAuth;
use DataAccess\Links;
use DTO\AddLinkRequest;
use DTO\DeleteLinkRequest;
use Exception;
use Http\IRequest;
use Http\Response;
use ServiceLocator;
use Throwable;
use Presentation\Views\AdminPanel;

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

    public function get(): Response
    {
        return (new AdminPanel())->response();
    }

    public function post(IRequest $request): Response
    {
        $this->auth->authorise($request);

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
}
