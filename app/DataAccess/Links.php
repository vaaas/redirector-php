<?php
namespace DataAccess;

final class Links
{
    private const LOCATION = "storage/links";

    /** @param array<string, string> $entries */
    public function __construct(private array $entries) {}

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
        file_put_contents(self::LOCATION, serialize($this->entries));
    }

    /** @return array<string, string> $entries */
    public function all(): array
    {
        return $this->entries;
    }

    public static function provider(): self
    {
        /** @var array<string, string> $entries */
        $entries = unserialize(file_get_contents(self::LOCATION) ?: "") ?: [];
        return new self($entries);
    }
}
