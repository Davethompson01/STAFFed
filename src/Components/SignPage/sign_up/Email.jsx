import React, { useState } from "react";

const Email = () => {
  const [email, setEmail] = useState("");
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

  return (
    <div className="px-5 py-3">
      <form action="" method="post" className="grid gap-6">
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
          value="Sign in with Email "
          className="border border-blue-500 w-full p-3 rounded-xl font-semibold"
        />
      </form>

      <div className="flex items-center justify-center gap-2 mt-5">
        <div className="w-[50px] bg-gray-300 h-[2px]"></div>
        <p>or Sign in with </p>
        <div className="w-[50px] bg-gray-300 h-[2px]"></div>
      </div>
    </div>
  );
};

export default Email;
