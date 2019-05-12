import gql from 'graphql-tag'

export default gql`
query TodoList($activeStatus: [String]){
  nodeQuery(filter:{conditions: {
    field: "field_active",
    value: $activeStatus
  }}) {
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
