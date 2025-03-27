# Otomaties Cookie Consent

## Installation

`composer require tombroucke/otomaties-cookie-consent`

## Prerequisites

- ACF Pro

## Documentation

[orestbida/cookieconsent](https://github.com/orestbida/cookieconsent)

## Filters

Allow editors to change settings

```
add_filter('otomaties_cookie_consent_settings_capability', 'edit_posts'),
```

## Shortcodes

```
[cookie-table show="what,table,google-privacy-terms"]
```

## Datalayer events

After each consent update, the `cookie_consent_update` datalayer event is dispatched.
You can use this event as a custom trigger in GTM to trigger tags after consent has been updated.
