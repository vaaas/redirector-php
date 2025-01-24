<?php
namespace Presentation\Layouts;

final class DefaultLayout extends AbstractLayout
{
    public const template = "layouts/default-layout";

    public function __construct(public readonly string $title) {}
}
