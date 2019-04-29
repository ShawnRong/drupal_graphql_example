<?php


namespace Drupal\graphql_example\Plugin\GraphQL\InputTypes;


use Drupal\graphql\Plugin\GraphQL\InputTypes\InputTypePluginBase;

/**
 * Class TagInput
 *
 * @package Drupal\graphql_example\Plugin\GraphQL\InputTypes
 *
 * @GraphQLInputType(
 *   id = "tag_input",
 *   name = "TagInput",
 *   description = "Tag input type",
 *   fields = {
 *     "tag" = {
 *       "type" = "String",
 *       "nullable" = "FALSE"
 *     },
 *   }
 * )
 */
class TagInput extends InputTypePluginBase {

}
