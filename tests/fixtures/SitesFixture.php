<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace crafttests\fixtures;

use Craft;
use craft\records\Site;
use craft\services\Sites;
use craft\test\ActiveFixture;

/**
 * Class SitesFixture
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @author Global Network Group | Giel Tettelaar <giel@yellowflash.net>
 * @since 3.2
 */
class SitesFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = Site::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/sites.php';

    /**
     * @inheritdoc
     */
    public function load(): void
    {
        parent::load();

        // Because the Sites() class memoizes on initialization we need to set() a new sites class
        // with the updated fixture data
        Craft::$app->set('sites', new Sites());
    }
}
