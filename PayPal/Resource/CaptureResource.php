<?php declare(strict_types=1);

namespace SwagPayPal\PayPal\Resource;

use Shopware\Core\Framework\Context;
use SwagPayPal\PayPal\Api\Refund;
use SwagPayPal\PayPal\Client\PayPalClientFactory;
use SwagPayPal\PayPal\RequestUri;

class CaptureResource
{
    /**
     * @var PayPalClientFactory
     */
    private $payPalClientFactory;

    public function __construct(PayPalClientFactory $payPalClientFactory)
    {
        $this->payPalClientFactory = $payPalClientFactory;
    }

    public function refund(string $paymentId, Refund $refund, Context $context): Refund
    {
        $response = $this->payPalClientFactory->createPaymentClient($context)->sendPostRequest(
            RequestUri::CAPTURE_RESOURCE . '/' . $paymentId . '/refund',
            $refund
        );

        $refundStruct = new Refund();
        $refundStruct->assign($response);

        return $refundStruct;
    }
}