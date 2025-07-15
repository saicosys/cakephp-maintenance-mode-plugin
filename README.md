# Saicosys Maintenance Plugin

*The **Saicosys CakePHP Maintenance Plugin** for CakePHP allows you to easily enable and manage maintenance mode for your application. Display a customizable maintenance page to users while allowing specific IPs to bypass restrictions. Maintenance mode can be toggled via configuration or CLI, making it suitable for both automated and manual workflows.*

## Features

- Enable/disable maintenance mode via config file or CLI
- Customizable maintenance page (logo, title, message, etc.)
- Allowlist for specific IP addresses
- Custom HTTP status code and Retry-After header
- Easy integration with CakePHP middleware
- No-downtime activation/deactivation
- Custom template configuration

## Use Cases

- Scheduled system upgrades or deployments
- Emergency downtime for bug fixes
- Restricting access to all but admin IPs during sensitive operations
- Displaying a branded message to users during outages

## Installation

1. **Require the plugin via Composer:**

   ```bash
   composer require saicosys/cakephp-maintenance
   ```

2. **Load the plugin in your `Application.php`:**

   ```bash
   bin/cake plugin load Saicosys/Maintenance
   ```

## Configuration

### 1. Using the Configuration File

Copy the example config to your app's config directory:

```bash
cp vendor/Saicosys/Maintenance/config/maintenance.example.php config/maintenance.php
```

Edit `config/maintenance.php` as needed:

```php
return [
    'maintenance' => [
        'enabled' => true, // Enable or disable maintenance mode
        'view' => [
            'layout' => 'default.php',
            'template' => null,
        ],
        'variables' => [
            'logo' => 'logo.png',
            'alt' => 'Company',
            'title' => 'System Maintenance',
            'message' => 'We are upgrading our systems. Please try again later.'
        ],
        'allowedIPs' => ['127.0.0.1', '::1'],
        'statusCode' => 503,
        'retryAfter' => 3600
    ],
];
```

Set `'enabled' => true` to activate maintenance mode, or `false` to deactivate.

### 2. Using the CLI (Flag File)

You can also enable maintenance mode by creating a flag file:

```bash
bin/cake maintenance enable
```

To disable maintenance mode:

```bash
bin/cake maintenance disable
```

If either the config `'enabled' => true` **or** the flag file exists, maintenance mode will be active.

## Example: Maintenance Page Output

When maintenance mode is active, users will see a page like:

```
+--------------------------+
|   [Your Logo Here]       |
|   System Maintenance     |
|   We are upgrading...    |
+--------------------------+
```

You can fully customize the logo, title, and message in the config file.

## Maintainer

**Saicosys Technologies Private Limited**  
[https://www.saicosys.com](https://www.saicosys.com)  
Contact: [info@saicosys.com](mailto:info@saicosys.com)

## Contributions

Contributions are welcome! Please fork the repository and submit a pull request. For major changes, open an issue first to discuss what you would like to change.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/mit-license.php).

Copyright (c) 2017-2025, Saicosys Technologies Private Limited
