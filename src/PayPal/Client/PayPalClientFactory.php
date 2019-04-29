<?php declare(strict_types=1);
/**
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\PayPal\Client;

use Shopware\Core\Framework\Context;
use Swag\PayPal\PayPal\Exception\PayPalSettingsInvalidException;
use Swag\PayPal\PayPal\Resource\TokenResource;
use Swag\PayPal\Setting\Exception\PayPalSettingsNotFoundException;
use Swag\PayPal\Setting\Service\SettingsServiceInterface;

class PayPalClientFactory
{
    /**
     * @var TokenResource
     */
    private $tokenResource;

    /**
     * @var SettingsServiceInterface
     */
    private $settingsProvider;

    public function __construct(TokenResource $tokenResource, SettingsServiceInterface $settingsProvider)
    {
        $this->tokenResource = $tokenResource;
        $this->settingsProvider = $settingsProvider;
    }

    /**
     * @throws PayPalSettingsInvalidException
     * @throws PayPalSettingsNotFoundException
     */
    public function createPaymentClient(Context $context): PayPalClient
    {
        $settings = $this->settingsProvider->getSettings($context);

        return new PayPalClient($this->tokenResource, $settings, $context->getSalesChannelId());
    }
}