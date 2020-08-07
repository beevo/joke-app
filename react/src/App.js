import React from 'react';
import logo from './logo.svg';
import './App.css';

function App() {
  fetch("http://localhost/api/jokes")
  .then(res => res.json())
  .then(
    (result) => {
      console.log(result)
      debugger;
    },
    // Note: it's important to handle errors here
    // instead of a catch() block so that we don't swallow
    // exceptions from actual bugs in components.
    (error) => {
      debugger;
    }
  )
  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <p>
          Edit <code>src/App.js</code> and save to reload. AAS YES
        </p>
        <a
          className="App-link"
          href="https://reactjs.org"
          target="_blank"
          rel="noopener noreferrer"
        >
          Learn React
        </a>
      </header>
    </div>
  );
}

export default App;
