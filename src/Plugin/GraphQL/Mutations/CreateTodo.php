<?php


namespace Drupal\graphql_example\Plugin\GraphQL\Mutations;


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
 * Class CreateTodo
 *
 * @package Drupal\graphql_example\Plugin\GraphQL\Mutations
 * @GraphQLMutation(
 *   id = "create_todo",
 *   description = "Create todo item.",
 *   entity_type = "node",
 *   secure = true,
 *   name = "createTodo",
 *   type = "EntityCrudOutput!",
 *   arguments =
 *   {
 *     "description" = "String!"
 *   }
 * )
 */
class CreateTodo extends MutationPluginBase implements ContainerFactoryPluginInterface {

  use DependencySerializationTrait;
  use StringTranslationTrait;
  use EntityHelperTrait;

  /**
   * CreateTodo constructor.
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
   * @return \Drupal\Core\Plugin\ContainerFactoryPluginInterface|\Drupal\graphql_example\Plugin\GraphQL\Mutations\CreateTodo
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
    $description = $args['description'];
    $todo = $this->entityTypeManager->getStorage('node')->create([
      'type' => 'todo'
    ]);
    $todo->title->value = $description;

    if (($violations = $todo->validate()) && $violations->count()) {
      return new EntityCrudOutputWrapper(NULL, $violations);
    }

    if (($status = $todo->save()) && $status === SAVED_NEW) {
      return new EntityCrudOutputWrapper($todo);
    }

    return NULL;
  }

}
