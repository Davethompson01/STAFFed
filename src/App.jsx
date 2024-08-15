import { Route, Routes } from "react-router-dom";
import "./index.css" 
import SignPage from "./Pages/Signupage";

function App() {
  return (
    <>
      <Routes>
        <Route path="/" element={<SignPage />} />
      </Routes>
    </>
  );
}

export default App;
