<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace craft\events;

/**
 * User Groups assign event class.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.0.0
 */
class UserGroupsAssignEvent extends CancelableEvent
{
    /**
     * @var int The user ID associated with this event
     */
    public int $userId;

    /**
     * @var int[] All of the user group IDs that the user belongs to now
     */
    public array $groupIds;

    /**
     * @var int[] The user group IDs that are being removed from the user
     */
    public array $removedGroupIds;

    /**
     * @var int[] The user group IDs that are being added to the user
     */
    public array $newGroupIds;
}
