<?php


namespace Drupal\graphql_example\Plugin\GraphQL\Mutations;


use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Mutations\MutationPluginBase;
use Drupal\graphql_core\GraphQL\EntityCrudOutputWrapper;
use Drupal\graphql_example\Utility\EntityHelperTrait;
use GraphQL\Type\Definition\ResolveInfo;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DeleteTag
 *
 * @package Drupal\graphql_example\Plugin\GraphQL\Mutations
 *
 * @GraphQLMutation(
 *  id = "delete_tag",
 *  description= "Delete blog tag with tag id.",
 *  entity_type = "blog_tag",
 *  secure = true,
 *  name = "deleteTag",
 *  type = "EntityCrudOutput!",
 *  arguments = {
 *    "tag_id" = "Integer!"
 *  }
 * )
 */
class DeleteTag extends MutationPluginBase implements ContainerFactoryPluginInterface {
  use DependencySerializationTrait;
  use StringTranslationTrait;
  use EntityHelperTrait;

  public function __construct(
    array $configuration,
    $pluginId,
    $pluginDefinition,
    EntityTypeManagerInterface $entityTypeManager
  ) {
    parent::__construct($configuration, $pluginId, $pluginDefinition);
    $this->entityTypeManager = $entityTypeManager;
  }

  public static function create(
    ContainerInterface $container,
    array $configuration,
    $pluginId,
    $pluginDefinition
  ) {
    return new static(
      $configuration,
      $pluginId,
      $pluginDefinition,
      $container->get('entity_type.manager')
    );
  }

  public function resolve(
    $value,
    array $args,
    ResolveContext $context,
    ResolveInfo $info
  ) {
    $tagId = $args['tag_id'];

    $storage = $this->entityTypeManager->getStorage('blog_tag');

    if (!$entity = $storage->load($tagId)) {
      return new EntityCrudOutputWrapper(NULL, NULL, [
        $this->t('The requested entities could not be loaded.'),
      ]);
    }

    try {
      $entity->delete();
    } catch (EntityStorageException $exception) {
      return new EntityCrudOutputWrapper(NULL, NULL, [
        $this->t('Entity deletion failed with exception: @exception.', [
          '@exception' => $exception->getMessage(),
        ]),
      ]);
    }

    return new EntityCrudOutputWrapper($entity);
  }
}
