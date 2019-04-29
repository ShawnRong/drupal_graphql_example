<?php


namespace Drupal\graphql_example\Entity;


use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Define the Blog entity.
 *
 * @ContentEntityType(
 *   id = "blog",
 *   label = @Translation("Blog"),
 *   base_table = "blog",
 *   admin_permission = "administer graphql test entities",
 *   entity_keys={
 *      "id" = "id",
 *   },
 * )
 */
class Blog extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type
  ) {
    $fields['id'] = BaseFieldDefinition::create('integer')
                                       ->setLabel(t('ID'))
                                       ->setDescription(t('The ID of Blog'))
                                       ->setReadOnly(TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
                                          ->setLabel(t('title'))
                                          ->setRequired(TRUE)
                                          ->setDescription(t('the title of Blog'));

    $fields['content'] = BaseFieldDefinition::create('string')
                                            ->setLabel(t('content'))
                                            ->setRequired(TRUE)
                                            ->setDescription(t('the content of Blog'));

    $fields['tags'] = BaseFieldDefinition::create('entity_reference')
                                         ->setSetting('target_type', 'blog_tag')
                                         ->setLabel(t('Tags'))
                                         ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
                                         ->setDescription(t('The Tags of Blog'));

    $fields['user'] = BaseFieldDefinition::create('entity_reference')
                                         ->setSetting('target_type', 'user')
                                         ->setLabel(t('User'))
                                         ->setDescription(t('The User of Blog'));

    $fields['created_at'] = BaseFieldDefinition::create('created')
                                               ->setLabel(t('Created'))
                                               ->setDescription(t('The Blog created time'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
                                            ->setLabel(t('Changed'))
                                            ->setDescription(t('The Blog changed time'));

    return $fields;
  }

}
