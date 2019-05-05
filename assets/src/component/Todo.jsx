import React from "react";
import { useQuery } from "react-apollo-hooks"
import TodoInput from './TodoInput'
import TodoList from './TodoList'
import query from '../query/fetchTodoList'

const Todo = () => {

  const { data, error, loading, refetch} = useQuery(query)

  if (loading) {
    return <div>Loading...</div>
  }
  if (error) {
    return <div>Error! {error.message}</div>;
  };

  return (
    <section className="todoapp">
      <h1>todos</h1>
      <TodoInput refetch={refetch}/>
      <TodoList />
      <footer className="footer">
        <span className="todo-count">
          <strong>{data.nodeQuery.count}</strong> left
        </span>
        <ul className="filters">
          <li><a href="/">All</a></li>
          <li><a href="/">Active</a></li>
          <li><a href="/">Completed</a></li>
        </ul>
      </footer>
    </section>
  );
};

export default Todo;
