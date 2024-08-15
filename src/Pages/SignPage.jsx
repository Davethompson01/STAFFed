import React from "react";
import Email from "../Components/SignPage/sign_up/Email";
import Staffed from "../Components/SignPage/sign_up/Staffed";
import Google from "../Components/SignPage/Otherauthentication/Google";
import Linkedin from "../Components/SignPage/Otherauthentication/Linkedin";
import SSO from "../Components/SignPage/Otherauthentication/SSO";
import Freetrial from "../Components/SignPage/Otherauthentication/Freetrial";

const Signpage = () => {
  return (
    <div>
      <Staffed />
      <Email />
      <Google />
      <Linkedin/>
      <SSO />
      <Freetrial  />
    </div>
  );
};

export default Signpage;
