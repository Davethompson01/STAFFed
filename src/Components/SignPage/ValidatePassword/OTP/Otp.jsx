import React, { useState } from 'react';

const OtpInput = ({ length, onSubmit }) => {
  const [otp, setOtp] = useState(Array(length).fill(''));

  const handleChange = (e, index) => {
    const value = e.target.value;
    if (/^[0-9]$/.test(value)) { // Ensure only a single digit is entered
      const newOtp = [...otp];
      newOtp[index] = value;
      setOtp(newOtp);

      // Move focus to the next input field
      if (index < length - 1) {
        document.getElementById(`otp-${index + 1}`).focus();
      }
    }
  };

  const handleKeyDown = (e, index) => {
    if (e.key === 'Backspace') {
      if (otp[index]) {
        const newOtp = [...otp];
        newOtp[index] = ''; // Clear the current input
        setOtp(newOtp);
      } else if (index > 0) {
        document.getElementById(`otp-${index - 1}`).focus(); // Move focus to the previous input
      }
    }
  };

  const handleSubmit = () => {
    onSubmit(otp.join(''));
  };

  return (
    <div>
      <div className="flex space-x-2">
        {otp.map((_, index) => (
          <input
            key={index}
            id={`otp-${index}`}
            type="text"
            maxLength="1"
            value={otp[index]}
            onChange={(e) => handleChange(e, index)}
            onKeyDown={(e) => handleKeyDown(e, index)}
            className="border rounded p-2 text-center w-12"
          />
        ))}
      </div>
      <button onClick={handleSubmit} className="mt-4 bg-blue-500 text-white p-2 rounded">
        Submit OTP
      </button>
    </div>
  );
};

const OtpPage = () => {
  const handleOtpSubmit = (otp) => {
    console.log('Submitted OTP:', otp);
    // Here, you can validate the OTP or send it to your server
  };

  return (
    <div className="flex justify-center items-center h-screen">
      <div>
        <h2 className="text-2xl mb-4">Enter OTP</h2>
        <OtpInput length={6} onSubmit={handleOtpSubmit} />
      </div>
    </div>
  );
};

export default OtpPage;
