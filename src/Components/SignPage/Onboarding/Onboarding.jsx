import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { useUser } from "../../Context/userProvider";

const Carousel = () => {
  const { setUserType } = useUser();
  const navigate = useNavigate();
  const slides = [
    {
      id: 1,
      image: "onboarding.png",
      text: "Find the right staff or job by utilizing our talent risk outsourcing solutions",
    },
    {
      id: 2,
      image: "onboarding2.png",
      text: "Sign agreements efficiently with our digital solution",
    },
  ];

  const [currentSlide, setCurrentSlide] = useState(0);

  const handleLogin = (role) => {
    setUserType(role);
    switch (role) {
      case "Employer":
        navigate("/employer");
        break;
      case "Employee":
        navigate("/signin");
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
    <div style={linearStyle} className="h-screen flex flex-col">
      {/* Navigation Header */}
      <div className="flex items-center justify-between p-4">
        <h1 className="text-white text-xl">
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
      </div>

      {/* Carousel Container */}
      <div className="relative flex-grow w-full max-w-md mx-auto overflow-hidden">
        <div
          className="flex transition-transform duration-300"
          style={{ transform: `translateX(-${currentSlide * 100}%)` }}
        >
          {slides.map((slide) => (
            <div key={slide.id} className="flex-shrink-0 w-full flex flex-col items-center">
              <img
                src={slide.image}
                alt={slide.text}
                className="w-full h-64 object-cover"
              />
              <p className="text-center px-4 py-2 text-white  w-full">
                {slide.text}
              </p>
            </div>
          ))}
        </div>
      </div>

      {/* Slide Navigation Dots */}
      <div className="flex justify-center mt-2">
        {slides.map((_, index) => (
          <div
            key={index}
            className={`h-2 w-2 rounded-full mx-1 cursor-pointer ${
              index === currentSlide ? "bg-black" : "bg-gray-400"
            }`}
            onClick={() => setCurrentSlide(index)}
          />
        ))}
      </div>

      {/* Buttons */}
      <div className="flex justify-center mt-5 mb-4">
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
    </div>
  );
};

export default Carousel;
