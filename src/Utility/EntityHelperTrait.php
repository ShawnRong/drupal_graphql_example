<?php

namespace Drupal\graphql_example\Utility;


use Drupal\graphql_core\GraphQL\EntityCrudOutputWrapper;

trait EntityHelperTrait {
  /**
   * The entity type manager.
   */
  protected $entityTypeManager;

  protected function entityIsExist($entity_type, $id) {
    $storage = $this->entityTypeManager->getStorage($entity_type);
    if(!$loaded = $storage->load($id)) {
      return new EntityCrudOutputWrapper(NULL, NULL, [
        $this->t('%entity id %id does not exist', [
          '%entity' => $entity_type,
          '%id' => $id
        ])
      ]);
    }
  }

  protected function entitiesIsExist($entity_type, $ids) {
    $storage = $this->entityTypeManager->getStorage($entity_type);
    $loaded = $storage->loadMultiple($ids);
    if(count($loaded) !== count($ids)) {
      return new EntityCrudOutputWrapper(NULL, NULL, [
        $this->t('%entity id does not exist', [
          '%entity' => $entity_type,
        ])
      ]);
    }
  }

  protected function entityCreate($entity_type, $args) {
    $storage = $this->entityTypeManager->getStorage($entity_type);
    return $storage->create($args);
  }
}
