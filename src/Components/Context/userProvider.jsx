// Components/Context/userProvider.js
import React, { createContext, useContext, useState } from "react";

const UserContext = createContext();

export const UserProvider = ({ children }) => {
  const [userType, setUserType] = useState(null);
  const [isSignedUp, setIsSignedUp] = useState(false); 

  return (
    <UserContext.Provider
      value={{ userType, setUserType, isSignedUp, setIsSignedUp }}
    >
      {children}
    </UserContext.Provider>
  );
};

export const useUser = () => useContext(UserContext);
