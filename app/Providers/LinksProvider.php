<?php
namespace Providers;

use DataAccess\Links;

final class LinksProvider {
    private const LOCATION = "storage/links";

    public static function provide(): Links {
        /** @var array<string, string> $entries */
        $entries = unserialize(file_get_contents(self::LOCATION) ?: "") ?: [];
        return new Links($entries, self::LOCATION);
    }
}
