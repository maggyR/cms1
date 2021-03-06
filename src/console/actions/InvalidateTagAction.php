<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace craft\console\actions;

use Craft;
use craft\console\controllers\InvalidateTagsController;
use yii\base\Action;
use yii\caching\TagDependency;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * @inheritdoc
 * @property InvalidateTagsController $controller
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.5.0
 */
class InvalidateTagAction extends Action
{
    /**
     * @var string
     */
    public string $tag;

    /**
     * @var string
     */
    public string $label;

    /**
     * Invalidates caches with the configured tag.
     *
     * @return int
     */
    public function run(): int
    {
        $this->controller->stdout(Craft::t('app', 'Invalidating cache tag:') . ' ', Console::FG_GREEN);
        $this->controller->stdout($this->tag . PHP_EOL, Console::FG_YELLOW);

        TagDependency::invalidate(Craft::$app->getCache(), $this->tag);

        return ExitCode::OK;
    }
}
