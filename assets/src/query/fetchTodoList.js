import gql from 'graphql-tag'

export default gql`
{
  nodeQuery {
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
