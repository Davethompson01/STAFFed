import { Route, Routes } from "react-router-dom";
import "./index.css";
import SignPage from "./Pages/SignPage";
import Validate from "./Pages/Validate";
import OtpPage from "./Components/ForgotPassword/Otp";

function App() {
  return (
    <>
      <Routes>
        <Route path="" element={<SignPage />} />
        <Route path="/ValidatePassword/LoginPage" element={<Validate />} />
        <Route path="/ForgotPassword/Otp" element={<OtpPage />} />
      </Routes>
    </>
  );
}

export default App;
