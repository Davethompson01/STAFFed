import React, { useState } from "react";
import Staffed from "../sign_up/Staffed";
import { useNavigate } from "react-router-dom";
import axios from "axios";

const LoginPage = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });
  const [message, setMessage] = useState("");

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleLogin = async (e) => {
    e.preventDefault(); // Prevent form refresh
    try {
      // No need for URLSearchParams, send the formData directly
      const response = await axios.post(
        "http://localhost/my-STAFFed/PHP/Signup_Login/api/login.php",
        formData, // Send formData directly as JSON
        {
          headers: {
            "Content-Type": "application/json", // JSON content-type header
          },
        }
      );
  
      console.log("Response data:", response.data);
  
      if (response.data.status === 'success') {
        // Store token if needed
        console.log("Navigating to /onboarding");
        navigate("/onboarding");
        setMessage(response.data.message);
      } else if (response.data.status === "error") {
        console.log("Error:", response.data.message);
        setMessage(response.data.message);
      } else {
        setMessage("An unexpected error occurred.");
      }
    } catch (error) {
      console.error("Error:", error);
      setMessage("An error occurred. Please try again.");
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
          className="grid gap-3 py-3 px-5"
          onSubmit={handleLogin}
        >
          <input
            type="text"
            name="email"
            onChange={handleChange} // Capture email input
            placeholder="Email address"
            className="mt-4 border border-solid border-gray-500 w-full p-3 rounded-xl"
            required
          />
          <input
            type="password"
            name="password"
            onChange={handleChange} // Capture password input
            placeholder="Password"
            className="border border-gray-400 w-full p-3 rounded-xl font-semibold"
            required
          />
          <div className="py-3 px-5 mt-3">
            <input
              type="submit"
              value="Sign In"
              style={linearStyle}
              className="p-3"
            />
          </div>
        </form>
        {message && <p>{message}</p>}
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