import React from "react";

const Onboarding = () => {
  const linearStyle = {
    background: "linear-gradient(to left, #2D65BD, #035A74)",
  };
  return (
    <>
      <div style={linearStyle} className="h-[100vh] relative ">
        <h1 className="flex place-items-end pb-3 text-white gap-2 h-[70px] pl-3 left-[10px] ">
          {" "}
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
          <img src="/onboarding.png" alt="" />
        </div>
      </div>

      <div></div>
    </>
  );
};

export default Onboarding;
