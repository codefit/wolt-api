<?php

namespace Wolt\Api;

use GuzzleHttp\Exception\GuzzleException;

class OrderClient extends Client
{
    /**
     * Get order details
     *
     * @throws GuzzleException
     */
    public function getOrder(string $orderId): array
    {
        return $this->request('GET', "/v2/orders/{$orderId}");
    }

    /**
     * Update order status
     *
     * @throws GuzzleException
     */
    public function updateOrderStatus(string $orderId, string $status): array
    {
        return $this->request('PUT', "/orders/{$orderId}/status", [
            'json' => ['status' => $status]
        ]);
    }

    /**
     * Mark order as ready
     *
     * @throws GuzzleException
     */
    public function markOrderReady(string $orderId): array
    {
        return $this->request('PUT', "/orders/{$orderId}/ready");
    }

    /**
     * Mark order as delivered
     *
     * @throws GuzzleException
     */
    public function markOrderDelivered(string $orderId): array
    {
        return $this->request('PUT', "/orders/{$orderId}/delivered");
    }

    /**
     * Reject order
     *
     * @throws GuzzleException
     */
    public function rejectOrder(string $orderId, string $reason): array
    {
        return $this->request('PUT', "/orders/{$orderId}/reject", [
            'json' => ['reason' => $reason]
        ]);
    }
} 