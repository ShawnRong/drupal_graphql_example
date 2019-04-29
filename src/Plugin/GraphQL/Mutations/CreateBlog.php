<?php


namespace Drupal\graphql_example\Plugin\GraphQL\Mutations;


use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\graphql\Annotation\GraphQLMutation;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Mutations\MutationPluginBase;
use GraphQL\Type\Definition\ResolveInfo;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CreateBlog
 *
 * @package Drupal\graphql_example\Plugin\GraphQL\Mutations
 * @GraphQLMutation(
 *   id = "create_blog",
 *   entity_type = "blog",
 *   secure = true,
 *   name = "createBlog",
 *   type = "EntityCrudOutput!",
 *   arguments = {
 *     "input" = "BlogInput!"
 *   }
 * )
 */
class CreateBlog extends MutationPluginBase implements ContainerFactoryPluginInterface {

  use DependencySerializationTrait;

  /**
   * The entity type manager.
   */
  protected $entityTypeManager;

  /**
   * CreateBlog constructor.
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
   * @return \Drupal\Core\Plugin\ContainerFactoryPluginInterface|\Drupal\graphql_example\Plugin\GraphQL\Mutations\CreateBlog
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
    $title = $args['input']['title'];
    $content = $args['input']['content'];
    //@TODO create entity
  }

}
