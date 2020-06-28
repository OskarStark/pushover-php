<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Example;

use Serhiy\Pushover\Api\UserGroupValidation\Validation;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Recipient;

/**
 * Validation Example.
 *
 * @author Serhiy Lunak
 */
class UserGroupValidationExample
{
    public function userGroupValidationExample()
    {
        // instantiate pushover application and recipient to verify (can be injected into service using Dependency Injection)
        $application = new Application("replace_with_pushover_application_api_token");
        $recipient = new Recipient("replace_with_pushover_user_key");

        // if required, specify devices to verify
        $recipient->addDevice("android");

        // create new validation
        $validation = new Validation($application);

        // validate the recipient
        $response = $validation->validate($recipient);

        // or loop over recipients
        $recipients = array(); // array of Recipient objects
        foreach ($recipients as $recipient) {
            $validation->validate($recipient);
        }

        // work with response
        if ($response->isSuccessful()) {
            // ...
            var_dump($response);
        }
    }
}
