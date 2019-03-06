<?php

namespace yansongda\pay\Contracts;

interface GatewayApplicationInterface
{
    /**
     * To pay.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @param string $gateway
     * @param array  $params
     *
     * @return \yansongda\supports\Collection|\Symfony\Component\HttpFoundation\Response
     */
    public function pay($gateway, $params);

    /**
     * Query an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|array $order
     * @param bool         $refund
     *
     * @return \yansongda\supports\Collection
     */
    public function find($order, $refund);

    /**
     * Refund an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $order
     *
     * @return \yansongda\supports\Collection
     */
    public function refund($order);

    /**
     * Cancel an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|array $order
     *
     * @return \yansongda\supports\Collection
     */
    public function cancel($order);

    /**
     * Close an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|array $order
     *
     * @return \yansongda\supports\Collection
     */
    public function close($order);

    /**
     * Verify a request.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|null $content
     * @param bool        $refund
     *
     * @return \yansongda\supports\Collection
     */
    public function verify($content, $refund);

    /**
     * Echo success to server.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function success();
}
