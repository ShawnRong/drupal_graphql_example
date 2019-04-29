<?php


namespace Drupal\graphql_example\Plugin\GraphQL\InputTypes;


use Drupal\graphql\Plugin\GraphQL\InputTypes\InputTypePluginBase;


/**
 * Class CommentInput
 *
 * @package Drupal\graphql_example\Plugin\GraphQL\InputTypes
 *
 * @GraphQLInputType(
 *   id = "comment_input",
 *   name = "CommentInput",
 *   description = "Comment input type",
 *   fields = {
 *     "content" = {
 *       "type" = "String",
 *       "nullable" = "FALSE"
 *     },
 *     "user" = {
 *       "type" = "Integer",
 *       "nullable" = "FALSE"
 *     },
 *     "blog" = {
 *       "type" = "Integer",
 *       "nullable" = "FALSE"
 *     },
 *   }
 * )
 */
class CommentInput extends InputTypePluginBase {

}
