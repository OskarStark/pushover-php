<?php

declare(strict_types=1);

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client\Response;

use Serhiy\Pushover\Client\Response\Base\Response;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 *
 * @final since 1.7.0, real final in 2.0
 */
class LicenseResponse extends Response
{
    /**
     * Number of license credits remaining.
     */
    private ?int $credits = null;

    public function __construct(string $curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    /**
     * @return null|int License credits or null if the request failed
     */
    public function getCredits(): ?int
    {
        return $this->credits;
    }

    private function processCurlResponse(string $curlResponse): void
    {
        $decodedCurlResponse = $this->processInitialCurlResponse($curlResponse);

        if ($this->getRequestStatus() === 1) {
            $this->credits = $decodedCurlResponse->credits;
        }
    }
}
