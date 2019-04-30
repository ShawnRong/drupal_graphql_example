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
 * Class CreateBlog
 *
 * @package Drupal\graphql_example\Plugin\GraphQL\Mutations
 * @GraphQLMutation(
 *   id = "create_blog",
 *   description = "Create blog.",
 *   entity_type = "blog",
 *   secure = true,
 *   name = "createBlog",
 *   type = "EntityCrudOutput!",
 *   arguments =
 *   {
 *     "input" = "BlogInput!"
 *   }
 * )
 */
class CreateBlog extends MutationPluginBase implements ContainerFactoryPluginInterface {

  use DependencySerializationTrait;
  use StringTranslationTrait;
  use EntityHelperTrait;

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
    $userId = $args['input']['user'];
    $tags = $args['input']['tags'];

    // Check if user exists
    if($validate = $this->entityIsExist('user', $userId))  {
      return $validate;
    }

    // Tags validate
    if($validate = $this->entitiesIsExist('blog_tag', $tags))  {
      return $validate;
    }

    $entity  = $this->entityCreate('blog', $args['input']);

    // Validate the entity values.
    if (($violations = $entity->validate()) && $violations->count()) {
      return new EntityCrudOutputWrapper(NULL, $violations);
    }

    if (($status = $entity->save()) && $status === SAVED_NEW) {
      return new EntityCrudOutputWrapper($entity);
    }
    return NULL;

  }

}
