import React from "react";
import { useNavigate } from "react-router-dom";
import { useUser } from "../../Context/userProvider";

const Onboarding = () => {
  const { setUserType } = useUser(); // Destructure setUserType from useUser
  const navigate = useNavigate();

  const handleLogin = (role) => {
    setUserType(role); // Set the user type based on the selected role
    switch (role) {
      case "Employer":
        navigate("/employer");
        break;
      case "Employee":
        navigate("/employee");
        break;
      default:
        navigate("/");
        break;
    }
  };

  const linearStyle = {
    background: "linear-gradient(to left, #2D65BD, #035A74)",
  };

  return (
    <>
      <div style={linearStyle} className="h-[100vh] relative">
        <h1 className="flex place-items-end pb-3 text-white gap-2 h-[70px] pl-3 left-[10px]">
          <svg
            width="9"
            height="19"
            viewBox="0 0 9 19"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M8 1L1.33333 10.5238L8 18.1429" stroke="white" />
          </svg>
          Back
        </h1>
        <div>
          <img src="/onboarding.png" alt="Onboarding" />
        </div>
      </div>
      <div className="flex justify-center mt-4">
        <button
          onClick={() => handleLogin("Employer")}
          className="mr-2 p-2 bg-blue-500 text-white rounded"
        >
          Hire a Staff
        </button>
        <button
          onClick={() => handleLogin("Employee")}
          className="p-2 bg-green-500 text-white rounded"
        >
          Find a Job
        </button>
      </div>
    </>
  );
};

export default Onboarding;
