<?php
namespace Views;

use Exception;
use Http\Respondable;
use Http\Response;

abstract class View implements Respondable
{
    protected string $view;

    private function contents(): string
    {
        ob_start();
        require "templates/" . $this->view . ".php";
        $results = ob_get_clean();
        if (!$results) {
            throw new Exception("Empty view");
        }
        return $results;
    }

    public function response(int $status = 200): Response
    {
        return new Response(
            $status,
            ["Content-Type" => "text/html"],
            $this->contents()
        );
    }
}
