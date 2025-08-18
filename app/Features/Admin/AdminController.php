<?php
namespace Features\Admin;

use DataAccess\Links;
use Exception;
use Http\BasicAuth;
use Http\IRequest;
use Http\Response;
use Throwable;
use Presentation\Views\AdminPanel;

/** @immutable */
final class AdminController
{
    public function __construct(
        private readonly BasicAuth $auth,
        private readonly Links $links,
    ) { }

    public function get(IRequest $request): Response
    {
        $this->auth->authorise($request);
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
