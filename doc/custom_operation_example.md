# Custom Entity Query Example

## query tag

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

## create blog

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

## create tag

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

## create comment

```
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

## update blog
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

## create todo

```
mutation {
  createTodo(description: "123") {
    entity {
      ... on NodeTodo {
        entityId
        title
        created
      }
    }
  }
}


```
