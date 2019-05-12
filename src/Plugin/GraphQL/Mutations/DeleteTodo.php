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
 * Class DeleteTodo
 *
 * @package Drupal\graphql_example\Plugin\GraphQL\Mutations
 *
 * @GraphQLMutation(
 *  id = "delete_todo",
 *  description= "Delete node todo with node id.",
 *  entity_type = "node",
 *  secure = true,
 *  name = "deleteTodo",
 *  type = "EntityCrudOutput!",
 *  arguments = {
 *    "todo_id" = "Integer!"
 *  }
 * )
 */
class DeleteTodo extends MutationPluginBase implements ContainerFactoryPluginInterface {

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
    $todoId = $args['todo_id'];

    $storage = $this->entityTypeManager->getStorage('node');

    if (!$entity = $storage->load($todoId)) {
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
