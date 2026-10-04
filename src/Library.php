<?php

declare(strict_types=1);

namespace Sofoste\LibTech;

/**
 * Small, framework-free catalogue service.
 *
 * Keeping filtering in a dedicated class makes the PHP part easy to study and
 * test. JavaScript applies the same rules in the browser for instant feedback.
 */
final class Library
{
    /** @param array<int, array<string, mixed>> $resources */
    public function __construct(private readonly array $resources)
    {
    }

    /** @return array<int, array<string, mixed>> */
    public function all(): array
    {
        return $this->resources;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function filter(string $query = '', string $category = 'all'): array
    {
        $needle = self::normalise($query);

        return array_values(array_filter(
            $this->resources,
            static function (array $resource) use ($needle, $category): bool {
                if ($category !== 'all' && $resource['category'] !== $category) {
                    return false;
                }

                if ($needle === '') {
                    return true;
                }

                $haystack = implode(' ', [
                    $resource['title'],
                    $resource['description'],
                    $resource['provider'],
                    implode(' ', $resource['tags']),
                ]);

                return str_contains(self::normalise($haystack), $needle);
            }
        ));
    }

    private static function normalise(string $value): string
    {
        $value = trim($value);

        return function_exists('mb_strtolower')
            ? mb_strtolower($value, 'UTF-8')
            : strtolower($value);
    }
}

