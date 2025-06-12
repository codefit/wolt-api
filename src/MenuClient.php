<?php

namespace Wolt\Api;

use GuzzleHttp\Exception\GuzzleException;

class MenuClient extends Client
{
    /**
     * Get menu for a venue
     *
     * @throws GuzzleException
     */
    public function getMenu(string $venueId): array
    {
        return $this->request('GET', "/venues/{$venueId}/menu");
    }

    /**
     * Update menu for a venue
     *
     * @throws GuzzleException
     */
    public function updateMenu(string $venueId, array $menuData): array
    {
        return $this->request('PUT', "/venues/{$venueId}/menu", [
            'json' => $menuData
        ]);
    }

    /**
     * Update item availability
     *
     * @throws GuzzleException
     */
    public function updateItemAvailability(string $venueId, string $itemId, bool $available): array
    {
        return $this->request('PUT', "/venues/{$venueId}/items/{$itemId}/availability", [
            'json' => ['available' => $available]
        ]);
    }

    /**
     * Update item price
     *
     * @throws GuzzleException
     */
    public function updateItemPrice(string $venueId, string $itemId, float $price): array
    {
        return $this->request('PUT', "/venues/{$venueId}/items/{$itemId}/price", [
            'json' => ['price' => $price]
        ]);
    }
} 