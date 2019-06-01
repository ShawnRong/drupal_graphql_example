import gql from 'graphql-tag'

export default gql`
query TodoList($activeStatus: [String]){
  nodeQuery(filter:{conditions: {
    field: "field_active",
    value: $activeStatus
  }},
    sort: {
      field: "created",
      direction: DESC
    }
  ) {
    count
    entities {
      ... on NodeTodo {
        entityId
        title
        fieldActive
      }
    }
  }
}
`
