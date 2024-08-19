import React from "react";
import Staffed from "../sign_up/Staffed";
import { useNavigate } from "react-router-dom";

const LoginPage = () => {
  const navigate = useNavigate();

  const handleOtpPage = (event) => {
    event.preventDefault();
    navigate("/MAGIC-CODE");
  };

  const linearStyle = {
    background: "linear-gradient(to left, #2D65BD, #035A74)",
    color: "white",
    textAlign: "center",
    borderRadius: "8px",
    cursor: "pointer",
  };

  const employee = (event) => {
    // const navigate = useNavigate();
    event.preventDefault();
    navigate("../Pages/Employee");
  };
  return (
    <>
      <div className="relative">
        <Staffed />
        <div className="absolute top-[30px] flex items-center bg-red-400 w-full">
          <p>Cancel</p>
          <p className="text-center flex-grow">Sign in with email</p>
        </div>
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
            className="border border-gray-400 w-full p-3 rounded-xl font-semibold"
          />
        </form>
        <p
          className="px-5 text-gray-700 cursor-pointer"
          onClick={handleOtpPage}
        >
          Forgot password?
        </p>
      </div>
      <div className="py-3 px-5 mt-3">
        <div style={linearStyle} className="p-3" onClick={employee}>
          Sign In
        </div>
      </div>
      <div className="py-3 px-5">
        <p className="text-center border-[2px]  p-3 rounded-lg" onClick={handleOtpPage}>
          Get magic code to sign in
        </p>
      </div>
    </>
  );
};

export default LoginPage;
