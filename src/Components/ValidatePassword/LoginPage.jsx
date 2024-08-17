import React from "react";
import Staffed from "../SignPage/sign_up/Staffed";
import { useNavigate } from "react-router-dom";
// import OtpPage from "../ForgotPassword/Otp";

const LoginPage = () => {
  const Navigate = useNavigate();
  const Otppage = (d) => {
    d.preventDefault();
    Navigate("../ForgotPassword/Otp");
  };
  return (
    <>
      <div>
        <Staffed />
      </div>
      <div>
        <form action="" method="post" className="grid gap-3 py-3 px-5">
          <input
            type="text"
            name="email"
            placeholder="Email address"
            className="mt-4 border border-solid border-gray-500 w-full p-3 rounded-xl"
            required
          />
          <input
            type="password"
            placeholder="Password"
            value=""
            className="border border-gray-400 w-full p-3 rounded-xl font-semibold"
          />
        </form>
        <p className=" px-5 text-gray-400 cursor-pointer " onClick={Otppage}>
          Forgot password?
        </p>
      </div>
    </>
  );
};

export default LoginPage;
