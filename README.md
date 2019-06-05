# Decoupled Drupal with GraphQL example
[Drupal org doc](https://www.drupal.org/docs/8/modules/graphql)
## Install
### Required Install
- [graphql-php](https://github.com/webonyx/graphql-php)
- [GraphQL Module](https://www.drupal.org/project/graphql)

``` shell
composer require webonyx/graphql-php
```

### React assets compile

``` shell
  yarn
  yarn build
```

### Optional Install

- [graphql-metatag](https://www.drupal.org/project/graphql_metatag)
- [graphql-views](https://www.drupal.org/project/graphql_views)
- [graphql-twig](https://www.drupal.org/project/graphql_twig)

## GraphQL
### Example module integrate queries

[Drupal Query Example](./doc/drupal_query_example.md)

[Drupal Custom Entity Operation Example](./doc/custom_operation_example.md)
