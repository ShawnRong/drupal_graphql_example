import React, { useState } from "react";
import gql from 'graphql-tag'
import { useMutation } from 'react-apollo-hooks'

const TodoInput = (props) => {
  const [todoName, setTodoName] = useState('')

  const todoInputHandler = (event) => {
    setTodoName(event.target.value)
  }

  const submitInputHandler = (event) => {
    if(event.key === 'Enter')  {
      addTodo().then(() => {
        props.refetch()
      })
    }
  }

  const addTodo = useMutation(CREATE_TODO, {
    variables: {
      description: todoName
    }
  })

  return (
    <header className="header">
      <input type="text" className="new-todo" value={todoName} onChange={todoInputHandler} onKeyUp={submitInputHandler}  />
    </header>
  )
}

const CREATE_TODO = gql`
mutation CreateTodo($description: String!) {
  createTodo (description: $description) {
    entity {
      ... on NodeTodo {
        entityId
        title
        fieldActive
      }
    }
  }
}
`

export default TodoInput
