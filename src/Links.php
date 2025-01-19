<?php
class Links
{
    private static string $path = "storage/links";

    /** @param array<string, string> $entries */
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
        $this->save();
    }

    public function delete(string $from): void
    {
        unset($this->entries[$from]);
        $this->save();
    }

    public function save(): void
    {
        file_put_contents(self::$path, serialize($this->entries));
    }

    public static function provider(): self
    {
        /** @var array<string, string> $entries */
        $entries = unserialize(file_get_contents(self::$path) ?: "") ?: [];
        return new self($entries);
    }
}
