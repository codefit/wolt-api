# Wolt API Client

PHP client for Wolt API integration. This package provides easy access to Wolt's Order API and Menu API.

## Installation

```bash
composer require codefit/wolt-api-client
```

## Usage

### Authentication

First, you'll need to obtain your client credentials from Wolt. Then you can initialize the clients:

```php
use Wolt\Api\OrderClient;
use Wolt\Api\MenuClient;

// Initialize Order client
$orderClient = new OrderClient('your-client-id', 'your-client-secret');

// Initialize Menu client
$menuClient = new MenuClient('your-client-id', 'your-client-secret');
```

### Order API Examples

```php
// Get order details
$order = $orderClient->getOrder('order-id');

// Mark order as ready
$orderClient->markOrderReady('order-id');

// Mark order as delivered
$orderClient->markOrderDelivered('order-id');

// Reject order
$orderClient->rejectOrder('order-id', 'Out of stock');
```

### Menu API Examples

```php
// Get menu for a venue
$menu = $menuClient->getMenu('venue-id');

// Update menu
$menuClient->updateMenu('venue-id', [
    // Menu data structure
]);

// Update item availability
$menuClient->updateItemAvailability('venue-id', 'item-id', false);

// Update item price
$menuClient->updateItemPrice('venue-id', 'item-id', 9.99);
```

## Error Handling

The client throws exceptions in case of errors:

```php
use Wolt\Api\Exception\AuthenticationException;
use GuzzleHttp\Exception\GuzzleException;

try {
    $order = $orderClient->getOrder('order-id');
} catch (AuthenticationException $e) {
    // Handle authentication errors
} catch (GuzzleException $e) {
    // Handle API request errors
}
```

## Requirements

- PHP 7.4 or higher
- Guzzle HTTP client
- JSON extension

## License

MIT
