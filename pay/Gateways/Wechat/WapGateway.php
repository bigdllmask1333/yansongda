<?php

namespace yansongda\pay\Gateways\Wechat;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use yansongda\pay\Log;

class WapGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws \yansongda\pay\Exceptions\GatewayException
     * @throws \yansongda\pay\Exceptions\InvalidArgumentException
     * @throws \yansongda\pay\Exceptions\InvalidSignException
     *
     * @return Response
     */
    public function pay($endpoint, array $payload): Response
    {
        $payload['trade_type'] = $this->getTradeType();

        Log::info('Starting To Pay A Wechat Wap Order', [$endpoint, $payload]);

        $data = $this->preOrder($payload);

        $url = is_null(Support::getInstance()->return_url) ? $data->mweb_url : $data->mweb_url.
                        '&redirect_url='.urlencode(Support::getInstance()->return_url);

        return RedirectResponse::create($url);
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    protected function getTradeType(): string
    {
        return 'MWEB';
    }
}
