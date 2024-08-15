import React, { useState } from "react";

const Form = () => {
  const [email, setEmail] = useState("");
  const [isClick, setIsClick] = useState(false);
  const [emailClick, setemailClick] = useState(false);
  const handleClick = () => {
    setIsClick(true);
  };
  const emailShow = () => {
    setemailClick(true);
  };

  const handleBlur = () => {
    if (email === "") {
      setIsClick(false);
    }
  };
  const emailBlur = () => {
    if (email === "") {
      setemailClick(false);
    }
  };

  const handleChange = (e) => {
    setEmail(e.target.value);
  };
  const emailChange = (e) => {
    setEmail(e.target.value);
  };

  return (
    <div className="px-5 py-3">
      <form action="" method="post">
        <div>
          <input
            className="border border-solid border-gray-500 w-full p-3 rounded-xl"
            type="text"
            onChange={handleChange}
            onBlur={handleBlur}
            onFocus={handleClick}
            name="user_name"
            placeholder="Your first and last name"
          />
          <br />
          <label htmlFor="" className={isClick ? "text-red-700" : "hidden"}>
            As it appears on your identification
          </label>
        </div>
        <div>
          <input
            type="text"
            name="email"
            onChange={emailChange}
            onBlur={emailBlur}
            onFocus={emailShow}
            placeholder="Email address"
            className="mt-4 border border-solid border-gray-500 w-full p-3 rounded-xl"
          
             required />
          <label htmlFor="" className={emailClick ? "text-red-700" : "hidden"}>
            Your personal email address
          </label>
        </div>
        <input
          type="number"
          name="number"
          placeholder="Phone number"
          className="mt-4 border border-solid border-gray-500 w-full p-3 rounded-xl"
          required
        />
        <input
          type="text"
          name="country"
          placeholder="Country of residence"
          className="mt-4 border border-solid border-gray-500 w-full p-3 rounded-xl"
          required
        />
        <input
          type="password"
          name="pwd"
          placeholder="Create password"
          className="mt-4 border border-solid border-gray-500 w-full p-3 rounded-xl"
          required
        />
        <div className="flex justify-center items-center mt-4  ">
          <input type="submit" value="start free trial" className="p-4 bg-black text-white" />
        </div>
      </form>
    </div>
  );
};

export default Form;
