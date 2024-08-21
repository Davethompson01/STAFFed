import React, { createContext, useState, useContext } from 'react';


const UserContext = createContext(undefined);

export const userProvider = ({ children }) => {
  const [userType, setUserType] = useState(null);

  return (
    <UserContext.Provider value={{ userType, setUserType }}>
      {children}
    </UserContext.Provider>
  );
};

export const useUser = () => {
  const context = useContext(UserContext);
  if (context === undefined) {
    throw new Error('useUser must be used within a UserProvider');
  }
  return context;
};