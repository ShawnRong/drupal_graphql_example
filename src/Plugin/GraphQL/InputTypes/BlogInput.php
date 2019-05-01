<?php


namespace Drupal\graphql_example\Plugin\GraphQL\InputTypes;


use Drupal\graphql\Annotation\GraphQLInputType;
use Drupal\graphql\Plugin\GraphQL\InputTypes\InputTypePluginBase;


/**
 * Class BlogInput
 *
 * @package Drupal\graphql_example\Plugin\GraphQL\InputTypes
 * @GraphQLInputType(
 *   id = "blog_input",
 *   name = "BlogInput",
 *   description = "Blog input type",
 *   fields = {
 *     "title" = {
 *       "type" = "String",
 *       "nullable" = "FALSE"
 *     },
 *     "content" = {
 *       "type" = "String",
 *       "nullable" = "FALSE"
 *     },
 *     "user" = {
 *       "type" = "Integer",
 *       "nullable" = "FALSE"
 *     },
 *     "tags" = {
 *       "type" = "[Integer]",
 *       "nullable" = "TRUE"
 *     }
 *   }
 * )
 */
class BlogInput extends InputTypePluginBase {

}
