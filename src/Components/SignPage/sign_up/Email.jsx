import React, { useState } from "react";
import { useNavigate } from "react-router-dom";

const Email = () => {
  const [email, setEmail] = useState("");
  const navigate = useNavigate(); // Use the useNavigate hook here

  const emailShow = () => {
    setEmail(true);
  };

  const emailBlur = () => {
    if (email === "") {
      setEmail(false);
    }
  };

  const emailChange = (e) => {
    setEmail(e.target.value);
  };

  const handleNavigate = (e) => {
    e.preventDefault();
    navigate("/Validate-password"); // Navigate to the login page
  };

const handlelogin = async (e)=>{
  try {
    // const response = await axios({
    //   url: "http://localhost/my-STAFFed/PHP/Signup_Login/api/Signup.php",
    //   method: "POST",
    //   headers: {
    //     "Content-Type": "application/x-www-form-urlencoded",
    //   },
    //   formData, // Convert formData to string
    // });

    const data = await axios.post(
      "http://localhost/my-STAFFed/PHP/Signup_Login/api/login.php",
      formData,
      //     "Content-Type": "application/x-www-form-urlencoded",
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );
    console.log("Response data:", response.data);

    if (response.data.status === 200) {
      navigate("/onboarding");
      console.log("Navigating to /onboarding");
      setMessage(response.message);
      console.log(response.status);
    } else if (response.data.status === "error") {
      console.log("Error:", response.data.message);
      setMessage(response.data.message);
    } else {
      // console.log("error hhh");
      setMessage(response.message);
    }
  } catch (error) {
    console.error("Error:", error);
    setMessage("An error occurred. Please try again.");
  }
};

  return (
    <div className="px-5 py-3">
      <form
        action=""
        method="post"
        className="grid gap-6"
        onSubmit={handleNavigate}
      >
        <input
          type="text"
          name="email"
          onChange={emailChange}
          onBlur={emailBlur}
          onFocus={emailShow}
          placeholder="Email address"
          className="mt-4 border border-solid border-gray-500 w-full p-3 rounded-xl"
          required
        />
        <input
          type="submit"
          
          value="Sign in with Email"
          className="border-[2px] border-blue-700 w-full p-3 rounded-xl font-semibold"
        />
      </form>

      <div className="flex items-center justify-center gap-2 mt-5">
        <div className="w-[50px] bg-gray-300 h-[2px]"></div>
        <p>or Sign in with</p>
        <div className="w-[50px] bg-gray-300 h-[2px]"></div>
      </div>
    </div>
  );
};

export default Email;
