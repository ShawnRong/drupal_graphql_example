<?php


namespace Drupal\graphql_example\Plugin\GraphQL\Mutations;


use Drupal\Core\Database\Driver\pgsql\NativeUpsert;
use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\graphql\Annotation\GraphQLMutation;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Mutations\MutationPluginBase;
use Drupal\graphql_core\GraphQL\EntityCrudOutputWrapper;
use Drupal\graphql_example\Utility\EntityHelperTrait;
use GraphQL\Type\Definition\ResolveInfo;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CompleteTodo
 *
 * @package Drupal\graphql_example\Plugin\GraphQL\Mutations
 * @GraphQLMutation(
 *   id = "complete_todo",
 *   description = "Complete todo",
 *   entity_type = "node",
 *   secure = true,
 *   name = "completeTodo",
 *   type = "EntityCrudOutput!",
 *   arguments =
 *   {
 *     "todoId" = "Integer!"
 *   }
 * )
 */
class CompleteTodo extends MutationPluginBase implements ContainerFactoryPluginInterface {

  use DependencySerializationTrait;
  use StringTranslationTrait;
  use EntityHelperTrait;

  /**
   * CompleteTodo constructor.
   *
   * @param array $configuration
   * @param string $pluginId
   * @param \Drupal\graphql_example\Plugin\GraphQL\Mutations\mixed $pluginDefinition
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManger
   */
  public function __construct(
    array $configuration,
    $pluginId,
    $pluginDefinition,
    EntityTypeManagerInterface $entityTypeManger
  ) {
    parent::__construct($configuration, $pluginId, $pluginDefinition);
    $this->entityTypeManager = $entityTypeManger;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $pluginId
   * @param mixed $pluginDefinition
   *
   * @return \Drupal\Core\Plugin\ContainerFactoryPluginInterface|\Drupal\graphql_example\Plugin\GraphQL\Mutations\CompleteTodo
   */
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
    $todoId = $args['todoId'];
    $todo = $this->entityTypeManager->getStorage('node')->load($todoId);
    $todo->field_active->value = FALSE;

    if (($violations = $todo->validate()) && $violations->count()) {
      return new EntityCrudOutputWrapper(NULL, $violations);
    }

    if (($status = $todo->save()) && $status === SAVED_UPDATED) {
      return new EntityCrudOutputWrapper($todo);
    }

    return NULL;
  }

}
