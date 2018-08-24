# Nova SystemInformation-Card
Simple Laravel Nova Card for displaying some useful information about disk-space, memory, loadavg, uptime and system time. 

## Installation

You can install the package in to a Laravel app that uses Nova via composer:
```
composer require nova-cards/system-information-card
```

## Usage:
```php
public function cards() {
    return [
	new SystemInformationCard(),
    ];
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.