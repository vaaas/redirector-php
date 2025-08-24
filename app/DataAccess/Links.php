<?php
namespace DataAccess;

final class Links
{
    /** @param array<string, string> $entries */
    public function __construct(
        private array $entries,
        private readonly string $location,
        private readonly IFileSystem $fs,
    ) {}

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
        $this->fs->set($this->location, serialize($this->entries));
    }

    /** @return array<string, string> $entries */
    public function all(): array
    {
        return $this->entries;
    }
}
