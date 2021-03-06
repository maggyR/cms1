<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace craft\models;

use craft\base\Model;

/**
 * Stores all of the available update info.
 *
 * @property bool $hasCritical Whether any of the updates have a critical release available
 * @property int $total The total number of available updates
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.0.0
 */
class Updates extends Model
{
    /**
     * @var Update CMS update info
     */
    public Update $cms;

    /**
     * @var Update[] Plugin update info
     */
    public array $plugins;

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        // Config normalization
        if (!($config['cms'] ?? null) instanceof Update) {
            $config['cms'] = new Update($config['cms'] ?? []);
        }

        if (!isset($config['plugins'])) {
            $config['plugins'] = [];
        } else {
            foreach ($config['plugins'] as $handle => $plugin) {
                if (!$plugin instanceof Update) {
                    $config['plugins'][$handle] = new Update($plugin);
                }
            }
        }

        parent::__construct($config);
    }

    /**
     * Returns the total number of available updates.
     *
     * @return int
     */
    public function getTotal(): int
    {
        $count = 0;

        if ($this->cms->getHasReleases()) {
            $count++;
        }

        foreach ($this->plugins as $update) {
            if ($update->getHasReleases()) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Returns whether any of the updates have a critical release available.
     *
     * @return bool
     */
    public function getHasCritical(): bool
    {
        if ($this->cms->getHasCritical()) {
            return true;
        }
        foreach ($this->plugins as $plugin) {
            if ($plugin->getHasCritical()) {
                return true;
            }
        }
        return false;
    }
}
