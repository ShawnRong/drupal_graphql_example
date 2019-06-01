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
