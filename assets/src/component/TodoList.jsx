import React from "react";
import { useQuery, useMutation } from "react-apollo-hooks";
import gql from "graphql-tag";
import query from "../query/fetchTodoList";

const TodoList = props => {
  const { data, error, loading, refetch } = useQuery(query, {
    variables: {
      activeStatus: props.queryCondition
    },
    fetchPolicy: "network-only"
  });

  const deleteTodoHandler = todoId => {
    return deleteTodo({
      variables: {
        todoId
      }
    }).then(() => {
      refetch();
      props.countRefetch();
    });
  };

  const deleteTodo = useMutation(DELETE_TODO);

  const toggleTodoHandler = todoId => {
    return toggleTodo({
      variables: {
        todoId
      }
    }).then(() => {
      refetch();
      props.countRefetch();
    });
  };

  const toggleTodo = useMutation(UPDATE_TODO_STATUS);

  if (loading) {
    return <div>Loading...</div>;
  }
  if (error) {
    return <div>Error! {error.message}</div>;
  }

  return (
    <section className="main">
      <input type="checkbox" className="toggle-all" id="toggle-all" />
      <label htmlFor="toggle-all" />
      <ul className="todo-list">
        {data.nodeQuery.entities.map(todo => (
          <li
            className={"todo " + (todo.fieldActive ? "" : "completed")}
            key={todo.entityId}
          >
            <div className="view">
              <input
                type="checkbox"
                className="toggle"
                onClick={() => toggleTodoHandler(todo.entityId)}
                defaultChecked={!todo.fieldActive}
              />
              <label>{todo.title}</label>
              <button
                className="destroy"
                onClick={() => deleteTodoHandler(todo.entityId)}
              />
            </div>
            <input type="text" className="edit" />
          </li>
        ))}
      </ul>
    </section>
  );
};

const UPDATE_TODO_STATUS = gql`
  mutation CompleteTodo($todoId: Integer!) {
    completeTodo(todoId: $todoId) {
      entity {
        ... on NodeTodo {
          title
          entityId
        }
      }
    }
  }
`;

const DELETE_TODO = gql`
  mutation DeleteTodo($todoId: Integer!) {
    deleteTodo(todo_id: $todoId) {
      entity {
        ... on NodeTodo {
          title
          entityId
        }
      }
    }
  }
`;

export default TodoList;
