import { Route, Routes } from "react-router-dom";
import "./index.css";
import SignPage from "./Pages/SignPage";
import Validate from "./Pages/Validate";

function App() {
  return (
    <>
      <Routes>
        <Route path="/" element={<SignPage />} />
        <Route path="/" element={<Validate />} />
      </Routes>
    </>
  );
}

export default App;
