<?php
class AdminPanel extends View
{
    /** @param array(string, string) $links */
    public function __construct(public array $links)
    {
        $this->view = "admin-panel";
    }
}
