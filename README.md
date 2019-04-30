# Decoupled Drupal with GraphQL example
[Drupal org doc](https://www.drupal.org/docs/8/modules/graphql)
## Install
### Required Install
- [graphql-php](https://github.com/webonyx/graphql-php)
- [GraphQL Module](https://www.drupal.org/project/graphql)

``` shell
composer require webonyx/graphql-php
```

### Conditional Install

- [graphql-metatag](https://www.drupal.org/project/graphql_metatag)
- [graphql-views](https://www.drupal.org/project/graphql_views)
- [graphql-twig](https://www.drupal.org/project/graphql_twig)

## GraphQL
### Example module integrate queries

```
# query tag
query {
	blogTagQuery {
    entities {
      entityId
      ... on BlogTag {
        tag
        createdAt
      }
    }
  }
}
```

```
# create blog
mutation {
  createBlog(input: {
    title: "GraphQLTest",
    content: "GraphQLTest Content",
    user: 1,
    tags: [1]
  }) {
    violations {
      code
      message
    }
    entity {
      ... on Blog {
        id
        title
        createdAt
      }
    }
    errors
  }
}
```

```
# create tag
mutation {
  createTag(input: {
    tag: "test_tag1"
  }) {
    entity {
      ... on BlogTag {
        id
        tag
        createdAt
      }
    }
    violations{
      message
      code
    }
  }
}
```

```angular2
mutation {
  createComment(input: {
    content: "commenttest",
    user: 1,
    blog: 3
  }) {
    errors
    violations{
      code
      message
    }
    entity {
      ... on BlogComment {
        content
        createdAt
        user {
        	entity {
            ... on User {
              uid
              name
            }
          }
        }
      }
    }
  }
}
```

``` updateblog
mutation {
  updateBlog(blog_id: 4, input: {
    title: "update title"
    tags: [3]
  }) {
    errors
    violations {
      message
      code
    }
    entity {
      ... on Blog {
        id
        title
        content
      }
    }
  }
}
```
