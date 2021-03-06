<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace craft\gql\base;

use craft\elements\db\ElementQueryInterface;
use craft\errors\GqlException;
use craft\helpers\Gql as GqlHelper;
use GraphQL\Type\Definition\ObjectType as GqlObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use Throwable;

/**
 * Class ObjectType
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.3.0
 */
abstract class ObjectType extends GqlObjectType
{
    /**
     * @inheritdoc
     */
    public function __construct(array $config)
    {
        $config['resolveField'] = [$this, 'resolveWithDirectives'];
        parent::__construct($config);
    }

    /**
     * Resolve a value with the directives that apply to it.
     *
     * @param mixed $source The parent data source to use for resolving this field
     * @param array $arguments arguments for resolving this field.
     * @param mixed $context The context shared between all resolvers
     * @param ResolveInfo $resolveInfo The resolve information
     * @return mixed $result
     * @throws GqlException if an error occurs
     */
    public function resolveWithDirectives(mixed $source, array $arguments, mixed $context, ResolveInfo $resolveInfo): mixed
    {
        try {
            $value = $this->resolve($source, $arguments, $context, $resolveInfo);
            $value = GqlHelper::applyDirectives($source, $resolveInfo, $value);
        } catch (Throwable $exception) {
            throw new GqlException($exception->getMessage(), 0, $exception);
        }

        return $value;
    }

    /**
     * Resolve a field value with arguments, context and resolve information.
     *
     * @param mixed $source The parent data source to use for resolving this field
     * @param array $arguments arguments for resolving this field.
     * @param mixed $context The context shared between all resolvers
     * @param ResolveInfo $resolveInfo The resolve information
     * @return mixed $result
     */
    protected function resolve(mixed $source, array $arguments, mixed $context, ResolveInfo $resolveInfo): mixed
    {
        $fieldName = GqlHelper::getFieldNameWithAlias($resolveInfo, $source, $context);

        $result = null;

        if (is_object($source)) {
            $result = $source->$fieldName;
        } elseif (is_array($source)) {
            $result = $source[$fieldName] ?? null;
        }

        return $result instanceof ElementQueryInterface ? $result->all() : $result;
    }
}
