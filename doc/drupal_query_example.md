## Query Article Node Content
```
{
  nodeQuery(limit: 10, offset: 0, filter: {conditions: [{operator: EQUAL, field: "type", value: ["article"]}]}) {
    entities {
      ... on NodeArticle {
        title
        body {
          value
        }
      }
    }
  }
}

```
## Get comment 

``` 
{
  commentQuery {
    entities {
      ... on CommentComment {
        commentBody {
          value
        }
      }
    }
  }
}
```

```
## query all node
query {
  nodeQuery {
    entities {
      entityId
      ... on NodeArticle {
        title
        created
      }
    }
  }
}

## query secific Content Type
query {
  nodeQuery(limit: 10, offset: 0, filter: {conditions: [{operator: EQUAL, field: "type", value: ["article"]}]}) {
    entities {
      entityId
      entityType
      __typename
      ... on NodeArticle {
        title
        created
      }
    }
  }
}

## query with alias
query {
  nodeQuery(limit: 10, offset: 0, filter: {conditions: [{operator: EQUAL, field: "type", value: ["article"]}]}) {
    article: entities {
      entityId
      entityType
      __typename
      ... on NodeArticle {
        title
        created
      }
    }
  }
}


## query with variables 
query Node($limit: Int, $ContentType: String) {
  nodeQuery(limit: $limit, offset: 0, filter: {conditions: [{operator: EQUAL, field: "type", value: [$ContentType]}]}) {
    article: entities {
      haha: entityId
      aa: entityType
      __typename
      ... on NodeArticle {
        title
        created
      }
      ... on NodeTodo {
        title
      }
    }
  }
}
## query varialbes 
{
  "limit": 1,
  "ContentType": "todo"
}


## mutation



## Introspection
query {
	__type(name: "Query") {
    name
    fields {
      name
    }
  }
}

query {
	__schema {
    types {
      name
    }
    directives {
      name
    }
 }
}
```
