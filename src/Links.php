<?php
class Links
{
    private static string $path = "storage/links";

    /** @param array(string, string) $links */
    public function __construct(public array $entries)
    {
    }

    public function get(string $link): ?string
    {
        return array_key_exists($link, $this->entries)
            ? $this->entries[$link]
            : null;
    }

    public function set(string $from, string $to): void
    {
        $this->entries[$from] = $to;
    }

    public function delete(string $from): void
    {
        unset($this->entries[$from]);
    }

    public function save(): void
    {
        file_put_contents(self::$path, serialize($this->entries));
    }

    public static function provider(): self
    {
        /** @var array(string, string) $links */
        $entries = unserialize(file_get_contents(self::$path)) ?: [];
        return new self($entries);
    }
}
