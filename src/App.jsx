import { Route, Routes } from "react-router-dom";
import "./index.css";
import SignPage from "./Pages/SignPage";
import Validate from "./Pages/Validate";
import OtpPage from "./Components/SignPage/ValidatePassword/OTP/Otp";
import Employee from "./Pages/Employee";
import SignUp from "./Pages/SignUp";

function App() {
  return (
    <>
      <Routes>
        <Route path="/" element={<SignUp />} />
        <Route path="/Sign-in" element={<SignPage />} />
        <Route path="/Validate-password" element={<Validate />} />
        <Route path="/MAGIC-CODE" element={<OtpPage />} />
        <Route path="/Pages/Employee" element={<Employee />} />
      </Routes>
    </>
  );
}

export default App;
