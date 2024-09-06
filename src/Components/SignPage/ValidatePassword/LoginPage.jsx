import React from "react";
import Staffed from "../sign_up/Staffed";
import { useState } from "react";
// import { useUser } from "../../Context/userProvider";
import { useNavigate } from "react-router-dom";
import axios from "axios";

const LoginPage = () => {
  const navigate = useNavigate();
  // const { setIsSignedUp } = useUser();
  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };
  const handleSubmit = async () => {
    try {
      const response = await axios({
        url: "http://localhost/my-STAFFed/PHP/Signup_Login/api/login.php",
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlrncoded",
        },
        data: new URLSearchParams(formData),
      });
      console.log("Response data:", response.data);
    } catch (error) {
      if (condition) {
      }
    }
  };

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
        <form
          action=""
          method="post"
          className="grid gap-3 py-3 px-5"
          onChange={handleSubmit}
        >
          <input
            type="text"
            name="email"
            onChange={handleChange}
            placeholder="Email address"
            className="mt-4 border border-solid border-gray-500 w-full p-3 rounded-xl"
            required
          />
          <input
            type="password"
            name="password"
            onChange={handleChange}
            placeholder="Password"
            className="border border-gray-400 w-full p-3 rounded-xl font-semibold"
          />
          <div className="py-3 px-5 mt-3">
            <input
              type="submit"
              name="submit"
              style={linearStyle}
              className="p-3"
            />
            Sign In
          </div>
        </form>
        <p
          className="px-5 text-gray-700 cursor-pointer"
          onClick={handleOtpPage}
        >
          Forgot password?
        </p>
      </div>

      <div className="py-3 px-5">
        <p
          className="text-center border-[2px]  p-3 rounded-lg"
          onClick={handleOtpPage}
        >
          Get magic code to sign in
        </p>
      </div>
    </>
  );
};

export default LoginPage;
