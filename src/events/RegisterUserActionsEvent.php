<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace craft\events;

use craft\elements\User;
use yii\base\Event;

/**
 * RegisterUserActionsEvent class.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.0.0
 */
class RegisterUserActionsEvent extends Event
{
    /**
     * @var User|null The user associated with the event
     */
    public ?User $user = null;

    /**
     * @var array Actions related to the user’s status
     */
    public array $statusActions = [];

    /**
     * @var array Actions related to the user’s authenticated session
     */
    public array $sessionActions = [];

    /**
     * @var array Destructive actions
     */
    public array $destructiveActions = [];

    /**
     * @var array Miscellaneous actions
     */
    public array $miscActions = [];
}
