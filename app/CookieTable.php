<?php

namespace Otomaties\CookieConsent;

/**
 * Read and write the cookie tables (ACF repeaters) of all categories.
 * A cookie is identified by its name, which is unique across categories.
 */
class CookieTable
{
    public const FIELDS = ['name', 'domain', 'expiration', 'description', 'regex'];

    /**
     * Mirrors the field group name used in OptionsPage::addOptionsFields()
     */
    private const FIELD_GROUP = 'cookie-consent-category-settings';

    public function all(?string $category = null): array
    {
        $cookies = [];
        foreach (array_keys(Settings::categories()) as $categoryKey) {
            if ($category && $category !== $categoryKey) {
                continue;
            }
            foreach ($this->rows($categoryKey) as $row) {
                $cookies[] = ['category' => $categoryKey] + $row;
            }
        }

        return $cookies;
    }

    public function find(string $name): ?array
    {
        foreach ($this->all() as $cookie) {
            if ($cookie['name'] === $name) {
                return $cookie;
            }
        }

        return null;
    }

    public function create(array $cookie): array|\WP_Error
    {
        if ($this->find($cookie['name'])) {
            return $this->existsError($cookie['name']);
        }

        $rows = $this->rows($cookie['category']);
        $rows[] = $this->normalize($cookie);
        $saved = $this->save($cookie['category'], $rows);
        if (is_wp_error($saved)) {
            return $saved;
        }

        return $this->find($cookie['name']);
    }

    public function update(string $name, array $changes): array|\WP_Error
    {
        $existing = $this->find($name);
        if (! $existing) {
            return $this->notFoundError($name);
        }

        $cookie = array_merge($existing, array_intersect_key($changes, array_flip([...self::FIELDS, 'category'])));
        if ($cookie['name'] !== $name && $this->find($cookie['name'])) {
            return $this->existsError($cookie['name']);
        }

        if ($cookie['category'] === $existing['category']) {
            $rows = array_map(
                fn ($row) => $row['name'] === $name ? $this->normalize($cookie) : $row,
                $this->rows($existing['category'])
            );
            $saved = $this->save($existing['category'], $rows);
        } else {
            $rows = $this->rows($cookie['category']);
            $rows[] = $this->normalize($cookie);
            $saved = $this->save($cookie['category'], $rows);
            if (! is_wp_error($saved)) {
                $saved = $this->save($existing['category'], $this->withoutCookie($existing['category'], $name));
            }
        }

        if (is_wp_error($saved)) {
            return $saved;
        }

        return $this->find($cookie['name']);
    }

    public function delete(string $name): array|\WP_Error
    {
        $existing = $this->find($name);
        if (! $existing) {
            return $this->notFoundError($name);
        }

        $saved = $this->save($existing['category'], $this->withoutCookie($existing['category'], $name));
        if (is_wp_error($saved)) {
            return $saved;
        }

        return $existing;
    }

    private function rows(string $category): array
    {
        $rows = Settings::generalOptionField('occ_'.$category.'_cookie_table');
        if (! is_array($rows)) {
            return [];
        }

        return array_values(array_map(fn ($row) => $this->normalize($row), $rows));
    }

    private function withoutCookie(string $category, string $name): array
    {
        return array_values(array_filter($this->rows($category), fn ($row) => $row['name'] !== $name));
    }

    private function normalize(array $cookie): array
    {
        return [
            'name' => (string) ($cookie['name'] ?? ''),
            'domain' => (string) ($cookie['domain'] ?? ''),
            'expiration' => (string) ($cookie['expiration'] ?? ''),
            'description' => (string) ($cookie['description'] ?? ''),
            'regex' => (bool) ($cookie['regex'] ?? false),
        ];
    }

    private function save(string $category, array $rows): bool|\WP_Error
    {
        $fieldKey = 'field_'.self::FIELD_GROUP.'_occ_'.$category.'_cookie_table';

        // The repeater is only registered in the default language, see OptionsPage::addOptionsFields()
        if (! acf_get_field($fieldKey)) {
            return new \WP_Error(
                'occ_cookie_table_unavailable',
                sprintf(__('The cookie table for %s is not available.', 'otomaties-cookie-consent'), $category),
                ['status' => 500]
            );
        }

        if (! function_exists('bea_acf_options_for_polylang_load')) {
            add_filter('acf/settings/current_language', '__return_false');
        }

        update_field($fieldKey, $rows, 'option');

        if (! function_exists('bea_acf_options_for_polylang_load')) {
            remove_filter('acf/settings/current_language', '__return_false');
        }

        return true;
    }

    private function existsError(string $name): \WP_Error
    {
        return new \WP_Error(
            'occ_cookie_exists',
            sprintf(__('Cookie %s already exists.', 'otomaties-cookie-consent'), $name),
            ['status' => 409]
        );
    }

    private function notFoundError(string $name): \WP_Error
    {
        return new \WP_Error(
            'occ_cookie_not_found',
            sprintf(__('Cookie %s not found.', 'otomaties-cookie-consent'), $name),
            ['status' => 404]
        );
    }
}
