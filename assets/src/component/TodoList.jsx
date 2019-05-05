import React from "react";
import { useQuery } from "react-apollo-hooks"
import query from '../query/fetchTodoList'

const TodoList = () => {
  const { data, error, loading} = useQuery(query)

  if (loading) {
    return <div>Loading...</div>
  }
  if (error) {
    return <div>Error! {error.message}</div>;
  };

  return (
    <section className="main">
      <input type="checkbox" className="toggle-all" id="toggle-all" />
      <label htmlFor="toggle-all" />
      <ul className="todo-list">
        {
          data.nodeQuery.entities.map(todo => (
            <li className="todo" key={todo.entityId}>
              <div className="view">
                <input type="checkbox" className="toggle" />
                <label>{todo.title}</label>
                <button className="destroy" />
              </div>
              <input type="text" className="edit" />
            </li>
          ))
        }
      </ul>
    </section>
  )
}

export default TodoList;
