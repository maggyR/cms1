<?php

namespace craft\conditions\elements;

use Craft;
use craft\base\BlockElementInterface;
use craft\base\ElementInterface;
use craft\conditions\BaseElementSelectConditionRule;
use craft\conditions\QueryConditionRuleInterface;
use craft\elements\db\ElementQueryInterface;
use craft\elements\Entry;
use craft\helpers\Cp;
use craft\helpers\Html;
use craft\helpers\UrlHelper;
use yii\db\QueryInterface;

/**
 * Relation condition rule.
 *
 * @property int[] $elementIds
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 4.0.0
 */
class RelatedToConditionRule extends BaseElementSelectConditionRule implements QueryConditionRuleInterface
{
    /**
     * @var string
     */
    public string $elementType = Entry::class;

    /**
     * @inheritdoc
     */
    public function getLabel(): string
    {
        return Craft::t('app', 'Related To');
    }

    /**
     * @inheritdoc
     */
    protected function elementType(): string
    {
        return $this->elementType;
    }

    /**
     * @inheritdoc
     */
    public function getExclusiveQueryParams(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function modifyQuery(QueryInterface $query): void
    {
        $elementId = $this->getElementId();
        if ($elementId !== null) {
            /** @var ElementQueryInterface $query */
            $query->andRelatedTo($elementId);
        }
    }

    /**
     * @inheritdochandleException
     */
    public function getHtml(array $options = []): string
    {
        return Html::tag('div',
            Cp::selectHtml([
                'name' => 'elementType',
                'options' => $this->_elementTypeOptions(),
                'value' => $this->elementType,
                'inputAttributes' => [
                    'hx' => [
                        'post' => UrlHelper::actionUrl('conditions/render'),
                    ],
                ],
            ]) .
            parent::getHtml($options),
            [
                'class' => ['flex', 'flex-nowrap'],
            ]
        );
    }

    /**
     * @return array
     */
    private function _elementTypeOptions(): array
    {
        $options = [];
        foreach (Craft::$app->getElements()->getAllElementTypes() as $elementType) {
            /** @var string|ElementInterface $elementType */
            if (!is_subclass_of($elementType, BlockElementInterface::class)) {
                $options[] = [
                    'value' => $elementType,
                    'label' => $elementType::displayName(),
                ];
            }
        }
        return $options;
    }

    /**
     * @inheritdoc
     */
    protected function defineRules(): array
    {
        return array_merge(parent::defineRules(), [
            [['elementType'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getConfig(): array
    {
        return array_merge(parent::getConfig(), [
            'elementType' => $this->elementType,
        ]);
    }
}