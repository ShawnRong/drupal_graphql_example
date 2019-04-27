<?php


namespace Drupal\graphql_example\Entity;


use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Define the BlogComment entity.
 *
 * @ContentEntityType(
 *   id = "blog_comment",
 *   label = @Translation("Blog Comment"),
 *   base_table = "blog_comment",
 *   entity_keys={
 *      "id" = "id",
 *   },
 * )
 */
class BlogComment extends ContentEntityBase implements ContentEntityInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type ) {
    $fields['id'] = BaseFieldDefinition::create('integer')
                                       ->setLabel(t('ID'))
                                       ->setDescription(t('The ID of Comment'))
                                       ->setReadOnly(TRUE);

    $fields['content'] = BaseFieldDefinition::create('string')
                                            ->setlabel(t('content'))
                                            ->setRequired(TRUE)
                                            ->setdescription(t('the content of Comment'));

    $fields['user'] = BaseFieldDefinition::create('entity_reference')
                                         ->setSetting('target_type', 'user')
                                         ->setLabel(t('User'))
                                         ->setDescription(t('Created User'));

    $fields['blog'] = BaseFieldDefinition::create('entity_reference')
                                         ->setSetting('target_type', 'blog')
                                         ->setLabel(t('Blog'))
                                         ->setDescription(t('Blog ID'));

    $fields['created_at'] = BaseFieldDefinition::create('created')
                                               ->setLabel(t('Created'))
                                               ->setDescription(t('The Comment created time'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
                                            ->setLabel(t('Changed'))
                                            ->setDescription(t('The Comment changed time'));

    return $fields;
  }
}
