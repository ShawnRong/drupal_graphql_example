import React, { useState } from "react";
import { useQuery } from "react-apollo-hooks";
import TodoInput from "./TodoInput";
import TodoList from "./TodoList";
import query from "../query/fetchTodoList";

const Todo = () => {
  const [queryStatus, setQueryStatus] = useState("All");
  const [queryCondition, setQueryCondition] = useState(["1", "0"]);

  const { data, error, loading, refetch } = useQuery(query, {
    variables: {
      activeStatus: queryCondition
    }
  });

  const queryAll = e => {
    e.preventDefault();
    setQueryStatus("All");
    setQueryCondition(["1", "0"]);
  };

  const queryActive = e => {
    e.preventDefault();
    setQueryStatus("Active");
    setQueryCondition(["1"]);
  };

  const queryCompleted = e => {
    e.preventDefault();
    setQueryStatus("Completed");
    setQueryCondition(["0"]);
  };

  if (loading) {
    return <div>Loading...</div>;
  }
  if (error) {
    return <div>Error! {error.message}</div>;
  }

  return (
    <section className="todoapp">
      <h1>todos</h1>
      <TodoInput refetch={refetch} />
      <TodoList countRefetch={refetch} queryCondition={queryCondition} />
      <footer className="footer">
        <span className="todo-count">
          <strong>{data.nodeQuery.count}</strong> left
        </span>
        <ul className="filters">
          <li>
            <a
              href="#"
              onClick={queryAll}
              className={queryStatus === "All" ? "selected" : null}
            >
              All
            </a>
          </li>
          <li>
            <a
              href="#"
              onClick={queryActive}
              className={queryStatus === "Active" ? "selected" : null}
            >
              Active
            </a>
          </li>
          <li>
            <a
              href="#"
              onClick={queryCompleted}
              className={queryStatus === "Completed" ? "selected" : null}
            >
              Completed
            </a>
          </li>
        </ul>
      </footer>
    </section>
  );
};

export default Todo;
