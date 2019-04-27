<?php


namespace Drupal\graphql_example\Entity;


use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Define the BlogTag entity.
 *
 * @ContentEntityType(
 *   id = "blog_tag",
 *   label = @Translation("Blog Tag"),
 *   base_table = "blog_tag",
 *   entity_keys={
 *      "id" = "id",
 *   },
 * )
 */
class BlogTag extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
                                       ->setLabel(t('ID'))
                                       ->setDescription(t('The ID of Tag'))
                                       ->setReadOnly(TRUE);

    $fields['tag'] = BaseFieldDefinition::create('string')
                                            ->setlabel(t('tag'))
                                            ->setRequired(TRUE)
                                            ->setdescription(t('the content of Tag'));


    $fields['created_at'] = BaseFieldDefinition::create('created')
                                               ->setLabel(t('Created'))
                                               ->setDescription(t('The Tag created time'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
                                            ->setLabel(t('Changed'))
                                            ->setDescription(t('The Tag changed time'));

    return $fields;
  }
}
