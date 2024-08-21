// import { Route, Routes } from "react-router-dom";
// import "./index.css";
// import SignPage from "./Pages/SignPage";
// import Validate from "./Pages/Validate";
// import OtpPage from "./Components/SignPage/ValidatePassword/OTP/Otp";
// import Employee from "./Pages/Employee";
// import SignUp from "./Pages/SignUp";
// import OnboardingPage from "./Pages/OnboardingPage";
// import { userProvider } from "./Components/Context/userProvider";

// function App() {
//   return (
//     <>
//       <Routes>
//         <userProvider>
//           <Route path="/" element={<OnboardingPage />} />
//           {/* <Route path="/" element={<SignUp />} /> */}
//           <Route path="/Sign-in" element={<SignPage />} />
//           <Route path="/Validate-password" element={<Validate />} />
//           <Route path="/MAGIC-CODE" element={<OtpPage />} />
//           <Route path="/Pages/Employee" element={<Employee />} />
//         </userProvider>
//       </Routes>
//     </>
//   );
// }

// export default App;

import React from "react";
import { Route, Routes } from "react-router-dom";
import "./index.css";
import SignPage from "./Pages/SignPage";
import Validate from "./Pages/Validate";
import OtpPage from "./Components/SignPage/ValidatePassword/OTP/Otp";
import Employee from "./Pages/Employee";
import SignUp from "./Pages/SignUp";
import OnboardingPage from "./Pages/OnboardingPage";
import { UserProvider } from "./Components/Context/userProvider"; // Ensure this is the correct import

function App() {
  return (
    <UserProvider>
      <Routes>
        <Route path="/Pages/Employee" element={<Employee />} />
        <Route element={<OnboardingPage />}>
          <Route path="/SignUp" element={<SignUp />} />
          <Route path="/Sign-in" element={<SignPage />} />
          <Route path="/Validate-password" element={<Validate />} />
          <Route path="/MAGIC-CODE" element={<OtpPage />} />
        </Route>
        <Route element={<OnboardingPage />} />
      </Routes>
    </UserProvider>
  );
}

export default App;
