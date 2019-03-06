<?php

namespace yansongda\pay\Contracts;

interface GatewayInterface
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @return \yansongda\supports\Collection|\Symfony\Component\HttpFoundation\Response
     */
    public function pay($endpoint, array $payload);
}
