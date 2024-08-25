import React from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { useUser } from "../Context/userProvider";

const LandingPage = () => {
  const setUserType = useUser();
  const navigate = useNavigate();
  const signup = (e) => {
    e.preventDefault();
    navigate("/onboarding");
  };
  const handlelogin = () => {
    setUserType(role);
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

  return (
    <div className="relative h-[150vh] pt-10">
      <div className="px-12">
        <svg
          width="192"
          height="93"
          viewBox="0 0 142 53"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M18.1619 22.1112C18.1683 22.1113 18.1675 22.1117 18.1611 22.1113C18.1613 22.1113 18.1614 22.1113 18.1615 22.1112C18.1621 22.1112 18.1623 22.1112 18.1619 22.1112ZM14.9707 24.9421C15.3129 24.4734 15.6595 24.0529 16.0101 23.6791C15.348 24.596 14.7705 25.5903 14.2771 26.6609C13.4631 28.367 12.8491 30.1914 12.4336 32.1322C12.0187 34.0701 11.8022 36.0303 11.784 38.0119C11.7624 40.3625 12.0996 42.432 12.8176 44.2038L12.8204 44.2108L12.8233 44.2177C13.5617 45.9271 14.5574 47.3539 15.8174 48.4824C17.0661 49.6397 18.496 50.4942 20.1022 51.0425C21.6913 51.5849 23.3531 51.8638 25.0843 51.8811C27.0113 51.9004 28.9115 51.6178 30.7827 51.035C32.6823 50.4523 34.4172 49.6054 35.9837 48.4934L35.9837 48.4934L35.9894 48.4893C38.3849 46.7504 40.2859 44.5828 41.6869 41.9914C43.1123 39.4065 43.8502 36.8087 43.8741 34.2048C43.8868 32.8191 43.6804 31.4868 43.2528 30.2114C42.8462 28.9158 42.1708 27.7449 41.2342 26.7022C40.5361 25.9152 39.6849 25.1771 38.6872 24.4853C37.7353 23.8065 36.7148 23.1479 35.6263 22.5095C34.5843 21.8826 33.5561 21.2558 32.5416 20.6292C31.5548 19.9814 30.6959 19.3019 29.9616 18.5921L29.9604 18.5909C28.9163 17.5869 28.1653 16.5283 27.6893 15.4175C27.2327 14.2871 27.0142 13.1714 27.0243 12.066C27.0366 10.7263 27.3197 9.42429 27.8779 8.15507C28.469 6.87446 29.2553 5.72518 30.2388 4.70486L30.2407 4.70286C31.2515 3.64529 32.3714 2.83542 33.6005 2.26546L33.6012 2.26513C34.6959 1.75595 35.8875 1.35679 37.178 1.06962C38.494 0.783244 39.7765 0.647476 41.0265 0.659969C42.0604 0.670302 43.0334 0.791142 43.9475 1.01977L43.9614 1.02324L43.9754 1.0261C44.8872 1.21252 45.6664 1.55334 46.3254 2.0407L46.3374 2.04958L46.3498 2.05791C47.1843 2.61835 47.8193 3.36435 48.2595 4.30963L48.2594 4.30966L48.2637 4.31846C48.7094 5.23955 48.9266 6.20722 48.9172 7.22925C48.9114 7.86386 48.8139 8.45794 48.6243 9.01426C48.6643 8.7361 48.6855 8.44981 48.6882 8.15584C48.6984 7.03896 48.4317 5.94911 47.902 4.89307C47.3865 3.76982 46.5796 2.84353 45.502 2.11551C44.3748 1.31412 42.9635 0.930216 41.3164 0.913755C40.3634 0.90423 39.3229 1.0393 38.1993 1.30926L38.1953 1.31024C37.0851 1.58428 35.8876 2.0362 34.605 2.6576C32.9707 3.42752 31.6014 4.57236 30.5008 6.08009L30.5007 6.08005L30.4958 6.087C29.4125 7.61197 28.851 9.26697 28.8347 11.039C28.8245 12.1519 29.0751 13.2731 29.5691 14.3975L29.574 14.4086L29.5793 14.4194C30.1163 15.5295 30.96 16.5737 32.0819 17.5575L32.0857 17.5608C33.0156 18.3639 34.0688 19.1644 35.2438 19.963L35.2502 19.9673L35.2567 19.9715C36.412 20.7177 37.5811 21.4835 38.764 22.2688L38.7703 22.2731L38.7768 22.2771C39.9337 23.0072 40.9779 23.7904 41.9109 24.6259L41.9149 24.6296C43.3703 25.9115 44.3861 27.2601 44.9915 28.6704C45.6084 30.1074 45.9072 31.5702 45.8935 33.0636C45.8774 34.8259 45.4804 36.6141 44.6903 38.4323L44.689 38.4354C43.9193 40.2321 42.9076 41.9349 41.6515 43.5445C40.3897 45.1229 39.0095 46.5274 37.5112 47.7594C35.787 49.1618 33.8377 50.2272 31.6583 50.9551L31.6583 50.9549L31.6463 50.9592C29.4909 51.7258 27.3183 52.0962 25.1252 52.0743C22.5025 52.0481 20.1134 51.4827 17.9472 50.3857C15.8218 49.2958 14.11 47.7151 12.8056 45.6313C11.5128 43.5272 10.7976 40.9257 10.6914 37.7975C10.6504 36.5498 10.807 35.1578 11.1715 33.617C11.5377 32.0696 12.0392 30.541 12.6769 29.0311C13.3396 27.4897 14.1051 26.1279 14.9707 24.9421ZM44.8196 12.57C44.8197 12.57 44.8209 12.5702 44.8232 12.5708C44.8207 12.5703 44.8196 12.57 44.8196 12.57Z"
            fill="#08B4E9"
          />
          <path
            d="M18.1619 22.1112C18.1683 22.1113 18.1675 22.1117 18.1611 22.1113C18.1613 22.1113 18.1614 22.1113 18.1615 22.1112C18.1621 22.1112 18.1623 22.1112 18.1619 22.1112ZM14.9707 24.9421C15.3129 24.4734 15.6595 24.0529 16.0101 23.6791C15.348 24.596 14.7705 25.5903 14.2771 26.6609C13.4631 28.367 12.8491 30.1914 12.4336 32.1322C12.0187 34.0701 11.8022 36.0303 11.784 38.0119C11.7624 40.3625 12.0996 42.432 12.8176 44.2038L12.8204 44.2108L12.8233 44.2177C13.5617 45.9271 14.5574 47.3539 15.8174 48.4824C17.0661 49.6397 18.496 50.4942 20.1022 51.0425C21.6913 51.5849 23.3531 51.8638 25.0843 51.8811C27.0113 51.9004 28.9115 51.6178 30.7827 51.035C32.6823 50.4523 34.4172 49.6054 35.9837 48.4934L35.9837 48.4934L35.9894 48.4893C38.3849 46.7504 40.2859 44.5828 41.6869 41.9914C43.1123 39.4065 43.8502 36.8087 43.8741 34.2048C43.8868 32.8191 43.6804 31.4868 43.2528 30.2114C42.8462 28.9158 42.1708 27.7449 41.2342 26.7022C40.5361 25.9152 39.6849 25.1771 38.6872 24.4853C37.7353 23.8065 36.7148 23.1479 35.6263 22.5095C34.5843 21.8826 33.5561 21.2558 32.5416 20.6292C31.5548 19.9814 30.6959 19.3019 29.9616 18.5921L29.9604 18.5909C28.9163 17.5869 28.1653 16.5283 27.6893 15.4175C27.2327 14.2871 27.0142 13.1714 27.0243 12.066C27.0366 10.7263 27.3197 9.42429 27.8779 8.15507C28.469 6.87446 29.2553 5.72518 30.2388 4.70486L30.2407 4.70286C31.2515 3.64529 32.3714 2.83542 33.6005 2.26546L33.6012 2.26513C34.6959 1.75595 35.8875 1.35679 37.178 1.06962C38.494 0.783244 39.7765 0.647476 41.0265 0.659969C42.0604 0.670302 43.0334 0.791142 43.9475 1.01977L43.9614 1.02324L43.9754 1.0261C44.8872 1.21252 45.6664 1.55334 46.3254 2.0407L46.3374 2.04958L46.3498 2.05791C47.1843 2.61835 47.8193 3.36435 48.2595 4.30963L48.2594 4.30966L48.2637 4.31846C48.7094 5.23955 48.9266 6.20722 48.9172 7.22925C48.9114 7.86386 48.8139 8.45794 48.6243 9.01426C48.6643 8.7361 48.6855 8.44981 48.6882 8.15584C48.6984 7.03896 48.4317 5.94911 47.902 4.89307C47.3865 3.76982 46.5796 2.84353 45.502 2.11551C44.3748 1.31412 42.9635 0.930216 41.3164 0.913755C40.3634 0.90423 39.3229 1.0393 38.1993 1.30926L38.1953 1.31024C37.0851 1.58428 35.8876 2.0362 34.605 2.6576C32.9707 3.42752 31.6014 4.57236 30.5008 6.08009L30.5007 6.08005L30.4958 6.087C29.4125 7.61197 28.851 9.26697 28.8347 11.039C28.8245 12.1519 29.0751 13.2731 29.5691 14.3975L29.574 14.4086L29.5793 14.4194C30.1163 15.5295 30.96 16.5737 32.0819 17.5575L32.0857 17.5608C33.0156 18.3639 34.0688 19.1644 35.2438 19.963L35.2502 19.9673L35.2567 19.9715C36.412 20.7177 37.5811 21.4835 38.764 22.2688L38.7703 22.2731L38.7768 22.2771C39.9337 23.0072 40.9779 23.7904 41.9109 24.6259L41.9149 24.6296C43.3703 25.9115 44.3861 27.2601 44.9915 28.6704C45.6084 30.1074 45.9072 31.5702 45.8935 33.0636C45.8774 34.8259 45.4804 36.6141 44.6903 38.4323L44.689 38.4354C43.9193 40.2321 42.9076 41.9349 41.6515 43.5445C40.3897 45.1229 39.0095 46.5274 37.5112 47.7594C35.787 49.1618 33.8377 50.2272 31.6583 50.9551L31.6583 50.9549L31.6463 50.9592C29.4909 51.7258 27.3183 52.0962 25.1252 52.0743C22.5025 52.0481 20.1134 51.4827 17.9472 50.3857C15.8218 49.2958 14.11 47.7151 12.8056 45.6313C11.5128 43.5272 10.7976 40.9257 10.6914 37.7975C10.6504 36.5498 10.807 35.1578 11.1715 33.617C11.5377 32.0696 12.0392 30.541 12.6769 29.0311C13.3396 27.4897 14.1051 26.1279 14.9707 24.9421ZM44.8196 12.57C44.8197 12.57 44.8209 12.5702 44.8232 12.5708C44.8207 12.5703 44.8196 12.57 44.8196 12.57Z"
            stroke="#524036"
            stroke-width="1.31836"
          />
          <path
            d="M18.1619 22.1112C18.1683 22.1113 18.1675 22.1117 18.1611 22.1113C18.1613 22.1113 18.1614 22.1113 18.1615 22.1112C18.1621 22.1112 18.1623 22.1112 18.1619 22.1112ZM14.9707 24.9421C15.3129 24.4734 15.6595 24.0529 16.0101 23.6791C15.348 24.596 14.7705 25.5903 14.2771 26.6609C13.4631 28.367 12.8491 30.1914 12.4336 32.1322C12.0187 34.0701 11.8022 36.0303 11.784 38.0119C11.7624 40.3625 12.0996 42.432 12.8176 44.2038L12.8204 44.2108L12.8233 44.2177C13.5617 45.9271 14.5574 47.3539 15.8174 48.4824C17.0661 49.6397 18.496 50.4942 20.1022 51.0425C21.6913 51.5849 23.3531 51.8638 25.0843 51.8811C27.0113 51.9004 28.9115 51.6178 30.7827 51.035C32.6823 50.4523 34.4172 49.6054 35.9837 48.4934L35.9837 48.4934L35.9894 48.4893C38.3849 46.7504 40.2859 44.5828 41.6869 41.9914C43.1123 39.4065 43.8502 36.8087 43.8741 34.2048C43.8868 32.8191 43.6804 31.4868 43.2528 30.2114C42.8462 28.9158 42.1708 27.7449 41.2342 26.7022C40.5361 25.9152 39.6849 25.1771 38.6872 24.4853C37.7353 23.8065 36.7148 23.1479 35.6263 22.5095C34.5843 21.8826 33.5561 21.2558 32.5416 20.6292C31.5548 19.9814 30.6959 19.3019 29.9616 18.5921L29.9604 18.5909C28.9163 17.5869 28.1653 16.5283 27.6893 15.4175C27.2327 14.2871 27.0142 13.1714 27.0243 12.066C27.0366 10.7263 27.3197 9.42429 27.8779 8.15507C28.469 6.87446 29.2553 5.72518 30.2388 4.70486L30.2407 4.70286C31.2515 3.64529 32.3714 2.83542 33.6005 2.26546L33.6012 2.26513C34.6959 1.75595 35.8875 1.35679 37.178 1.06962C38.494 0.783244 39.7765 0.647476 41.0265 0.659969C42.0604 0.670302 43.0334 0.791142 43.9475 1.01977L43.9614 1.02324L43.9754 1.0261C44.8872 1.21252 45.6664 1.55334 46.3254 2.0407L46.3374 2.04958L46.3498 2.05791C47.1843 2.61835 47.8193 3.36435 48.2595 4.30963L48.2594 4.30966L48.2637 4.31846C48.7094 5.23955 48.9266 6.20722 48.9172 7.22925C48.9114 7.86386 48.8139 8.45794 48.6243 9.01426C48.6643 8.7361 48.6855 8.44981 48.6882 8.15584C48.6984 7.03896 48.4317 5.94911 47.902 4.89307C47.3865 3.76982 46.5796 2.84353 45.502 2.11551C44.3748 1.31412 42.9635 0.930216 41.3164 0.913755C40.3634 0.90423 39.3229 1.0393 38.1993 1.30926L38.1953 1.31024C37.0851 1.58428 35.8876 2.0362 34.605 2.6576C32.9707 3.42752 31.6014 4.57236 30.5008 6.08009L30.5007 6.08005L30.4958 6.087C29.4125 7.61197 28.851 9.26697 28.8347 11.039C28.8245 12.1519 29.0751 13.2731 29.5691 14.3975L29.574 14.4086L29.5793 14.4194C30.1163 15.5295 30.96 16.5737 32.0819 17.5575L32.0857 17.5608C33.0156 18.3639 34.0688 19.1644 35.2438 19.963L35.2502 19.9673L35.2567 19.9715C36.412 20.7177 37.5811 21.4835 38.764 22.2688L38.7703 22.2731L38.7768 22.2771C39.9337 23.0072 40.9779 23.7904 41.9109 24.6259L41.9149 24.6296C43.3703 25.9115 44.3861 27.2601 44.9915 28.6704C45.6084 30.1074 45.9072 31.5702 45.8935 33.0636C45.8774 34.8259 45.4804 36.6141 44.6903 38.4323L44.689 38.4354C43.9193 40.2321 42.9076 41.9349 41.6515 43.5445C40.3897 45.1229 39.0095 46.5274 37.5112 47.7594C35.787 49.1618 33.8377 50.2272 31.6583 50.9551L31.6583 50.9549L31.6463 50.9592C29.4909 51.7258 27.3183 52.0962 25.1252 52.0743C22.5025 52.0481 20.1134 51.4827 17.9472 50.3857C15.8218 49.2958 14.11 47.7151 12.8056 45.6313C11.5128 43.5272 10.7976 40.9257 10.6914 37.7975C10.6504 36.5498 10.807 35.1578 11.1715 33.617C11.5377 32.0696 12.0392 30.541 12.6769 29.0311C13.3396 27.4897 14.1051 26.1279 14.9707 24.9421ZM44.8196 12.57C44.8197 12.57 44.8209 12.5702 44.8232 12.5708C44.8207 12.5703 44.8196 12.57 44.8196 12.57Z"
            stroke="url(#paint0_linear_1_2704)"
            stroke-width="1.31836"
          />
          <path
            d="M52.7196 46.9117C53.6056 46.7711 54.147 46.6305 54.3438 46.4898C54.5407 46.3352 54.6392 46.0398 54.6392 45.6039V34.2133C52.8251 34.2414 51.8548 34.2836 51.7282 34.3398C51.6017 34.3961 51.5032 34.4594 51.4329 34.5297C51.2642 34.7547 51.0603 35.5492 50.8212 36.9133L49.7454 36.8289C49.7313 36.618 49.7243 36.2102 49.7243 35.6055C49.7243 34.9867 49.7876 34.157 49.9142 33.1164H61.4103C61.5368 34.157 61.6001 34.9867 61.6001 35.6055C61.6001 36.2102 61.5931 36.618 61.579 36.8289L60.5032 36.9133C60.2642 35.5492 60.0532 34.7547 59.8704 34.5297C59.8142 34.4594 59.7228 34.3961 59.5962 34.3398C59.4696 34.2836 58.4993 34.2414 56.6853 34.2133V46.1102C56.6853 46.4336 56.8259 46.6164 57.1071 46.6586L58.7313 46.9117L58.647 47.7344H52.8462L52.7196 46.9117ZM64.1556 47.7344L64.0079 46.8906C64.5423 46.75 64.8657 46.6375 64.9782 46.5531C65.1048 46.4688 65.2243 46.2789 65.3368 45.9836L70.0618 32.9266H71.8126L76.6431 46.3211C76.7134 46.532 77.1282 46.7078 77.8876 46.8484L77.8032 47.7344H72.8884L72.7618 46.8906C73.7462 46.6938 74.2384 46.4617 74.2384 46.1945C74.2384 46.082 74.2103 45.9344 74.154 45.7516L73.2259 43.0094H67.7626L66.6868 46.0047C66.6306 46.1734 66.6024 46.293 66.6024 46.3633C66.6024 46.4195 66.6446 46.4547 66.729 46.4688L68.2267 46.8695L68.1423 47.7344H64.1556ZM68.1634 41.8914H72.8673L70.8001 35.9641C70.7017 35.6688 70.6524 35.4648 70.6524 35.3523H70.4415L68.1634 41.8914ZM81.1555 47.7344L81.0289 46.9117C81.7742 46.7852 82.2242 46.6445 82.3789 46.4898C82.5477 46.3352 82.632 46.0398 82.632 45.6039V35.2469C82.632 34.8109 82.5477 34.5156 82.3789 34.3609C82.2242 34.2063 81.7742 34.0656 81.0289 33.9391L81.1555 33.1164H90.9852C91.0695 33.6367 91.1117 34.157 91.1117 34.6773C91.1117 35.1836 91.0977 35.7602 91.0695 36.407L89.8672 36.5547C89.6703 35.5844 89.5297 34.9797 89.4453 34.7406C89.361 34.4875 89.2625 34.3539 89.15 34.3398C88.8125 34.2977 88.3836 34.2695 87.8633 34.2555L84.6781 34.1922V40.0563H87.9266C88.2781 40.0563 88.5875 39.557 88.8547 38.5586L89.5086 38.6219C89.5086 39.6484 89.5227 40.3656 89.5508 40.7734C89.593 41.1813 89.6141 41.4273 89.6141 41.5117C89.6281 41.5961 89.6563 41.8 89.6985 42.1234C89.7547 42.4469 89.7899 42.6719 89.8039 42.7984L89.0445 42.925C88.707 41.7578 88.3836 41.1742 88.0742 41.1742H84.6781V46.1102C84.6781 46.4477 84.8188 46.6305 85.1 46.6586L87.2305 46.9117L87.1461 47.7344H81.1555ZM94.7799 47.7344L94.6533 46.9117C95.3987 46.7852 95.8487 46.6445 96.0033 46.4898C96.1721 46.3352 96.2565 46.0398 96.2565 45.6039V35.2469C96.2565 34.8109 96.1721 34.5156 96.0033 34.3609C95.8487 34.2063 95.3987 34.0656 94.6533 33.9391L94.7799 33.1164H104.61C104.694 33.6367 104.736 34.157 104.736 34.6773C104.736 35.1836 104.722 35.7602 104.694 36.407L103.492 36.5547C103.295 35.5844 103.154 34.9797 103.07 34.7406C102.985 34.4875 102.887 34.3539 102.774 34.3398C102.437 34.2977 102.008 34.2695 101.488 34.2555L98.3026 34.1922V40.0563H101.551C101.903 40.0563 102.212 39.557 102.479 38.5586L103.133 38.6219C103.133 39.6484 103.147 40.3656 103.175 40.7734C103.217 41.1813 103.238 41.4273 103.238 41.5117C103.253 41.5961 103.281 41.8 103.323 42.1234C103.379 42.4469 103.414 42.6719 103.428 42.7984L102.669 42.925C102.331 41.7578 102.008 41.1742 101.699 41.1742H98.3026V46.1102C98.3026 46.4477 98.4432 46.6305 98.7244 46.6586L100.855 46.9117L100.771 47.7344H94.7799ZM112.539 47.9242C111.118 47.9242 110.014 47.4391 109.227 46.4688C108.454 45.4984 108.067 44.275 108.067 42.7984C108.067 41.3078 108.517 40.0422 109.417 39.0016C110.317 37.9609 111.505 37.4406 112.982 37.4406C115.372 37.4406 116.624 38.9102 116.736 41.8492L116.188 42.25L110.071 42.5875C110.071 45.1891 111.182 46.4898 113.404 46.4898C114.374 46.4898 115.323 46.2508 116.251 45.7727L116.694 46.4688C116.23 46.8484 115.625 47.1859 114.88 47.4813C114.135 47.7766 113.354 47.9242 112.539 47.9242ZM110.134 41.6172L114.5 41.2375C114.641 41.2234 114.711 41.0898 114.711 40.8367C114.711 40.218 114.543 39.6836 114.205 39.2336C113.882 38.7836 113.326 38.5586 112.539 38.5586C111.751 38.5586 111.175 38.8258 110.809 39.3602C110.457 39.8805 110.232 40.6328 110.134 41.6172ZM127.126 46.3422C126.31 47.3969 125.333 47.9242 124.194 47.9242C123.055 47.9242 122.12 47.4742 121.388 46.5742C120.657 45.6602 120.291 44.4156 120.291 42.8406C120.291 41.2656 120.706 39.9719 121.536 38.9594C122.366 37.9469 123.526 37.4406 125.016 37.4406C126.043 37.4406 126.802 37.6234 127.295 37.9891L127.442 37.9258C127.386 37.7008 127.358 37.3914 127.358 36.9977V33.4539C127.358 33.1586 127.21 32.9406 126.915 32.8C126.634 32.6453 126.12 32.5188 125.375 32.4203L125.502 31.7453C127.006 31.5484 128.181 31.45 129.024 31.45L129.256 31.6609V45.6672C129.256 46.0328 129.341 46.293 129.509 46.4477C129.692 46.5883 130.142 46.7289 130.859 46.8695L130.733 47.5445L128.202 47.8187C128.061 47.8187 127.906 47.6781 127.738 47.3969C127.569 47.1156 127.484 46.8625 127.484 46.6375C127.484 46.4125 127.491 46.2438 127.506 46.1313L127.337 46.068L127.126 46.3422ZM122.338 42.3344C122.338 43.7266 122.556 44.7531 122.991 45.4141C123.441 46.075 124.004 46.4055 124.679 46.4055C125.354 46.4055 126.057 46.1664 126.788 45.6883C127.168 45.4352 127.358 45.1117 127.358 44.718V39.6766C126.781 38.9875 125.881 38.643 124.658 38.643C124.053 38.643 123.575 38.8398 123.224 39.2336C122.633 39.8945 122.338 40.9281 122.338 42.3344Z"
            fill="#372B24"
          />
          <defs>
            <linearGradient
              id="paint0_linear_1_2704"
              x1="45.917"
              y1="14.1759"
              x2="13.0273"
              y2="44.5143"
              gradientUnits="userSpaceOnUse"
            >
              <stop stop-color="#45C0E4" stop-opacity="0.75" />
              <stop
                offset="0.556618"
                stop-color="#524036"
                stop-opacity="0.75"
              />
              <stop offset="1" stop-color="#2172EA" stop-opacity="0.75" />
            </linearGradient>
          </defs>
        </svg>
      </div>
      <div className="w-[500px] grid gap-12 absolute left-[50px] top-[200px] ">
        <h1 className="font-bold text-6xl">Start your 10 day free trial</h1>
        <p className="text-xl font-bold">
          Try our recruiting platform with no credit card required
        </p>
      </div>
      <div className="px-12">
        <form
          action="http://localhost/my-STAFFed/PHP/Signup_Login/api/index.php"
          method="POST"
          className="w-[550px] absolute bg-white right-[100px] top-[150px] z-20 rounded-lg p-3 border grid gap-3 border-gray-400 px-4"
        >
          <h1 className="text-right">
            Already have a STAFFed account{" "}
            <span className="text-blue-600 cursor-pointer " onClick={signup}>
              sign in{" "}
            </span>
          </h1>

          <div className="grid gap-3">
            <input
              type="text"
              className="border border-gray-700 w-full px-3 py-3 rounded-xl"
              placeholder="Your first and last name"
              name="username"
            />
            <h1></h1>
          </div>
          <input
            type="text"
            name="email"
            placeholder="Email address"
            className="border border-gray-700 w-full px-3 py-3 rounded-xl"
          />
          <input
            type="text"
            name="number"
            placeholder="Phone number"
            className="border border-gray-700 w-full px-3 py-3 rounded-xl"
          />
          <input
            type="text"
            name="country"
            placeholder="Country of residence"
            className="border border-gray-700 w-full px-3 py-3 rounded-xl"
          />
          <input
            type="text"
            name="password"
            placeholder="Create password"
            className="border border-gray-700 w-full px-3 py-3 rounded-xl"
          />
          <div className="grid place-content-center ">
            <input
              type="submit"
              name="submit"
              value="Start a Feee trial"
              className=" bg-red-400 p-3 rounded-md text-white font-semibold"
            />
          </div>

          <div className="flex items-center justify-center gap-2 mt-5">
            <div className="w-[50px] bg-gray-300 h-[2px]"></div>
            <p className="font-semibold">or Start with </p>
            <div className="w-[50px] bg-gray-300 h-[2px]"></div>
          </div>
          <p>
            By signing and using this services, you are confirm that you have
            accepted our Terms and Conditions and have read our Privacy Policy
          </p>
        </form>
      </div>
      <div className=" absolute bottom-0 z-10  w-full overflow-hidden">
        <svg
          width="full"
          height="496"
          viewBox="0 0 1449 496"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <g filter="url(#filter0_d_1_4433)">
            <path
              d="M494.126 26.4768C153.753 -36.9939 1 186.817 1 186.817V486.545H1440V236.013C1440 -73.2806 1345.89 -31.8288 1141.2 102.092C936.5 236.013 834.5 89.9475 494.126 26.4768Z"
              fill="url(#paint0_linear_1_4433)"
            />
            <path
              d="M494.126 26.4768C153.753 -36.9939 1 186.817 1 186.817V486.545H1440V236.013C1440 -73.2806 1345.89 -31.8288 1141.2 102.092C936.5 236.013 834.5 89.9475 494.126 26.4768Z"
              stroke="#2D65BD"
            />
          </g>
          <defs>
            <filter
              id="filter0_d_1_4433"
              x="0.5"
              y="0.500122"
              width=""
              height="494.545"
              filterUnits="userSpaceOnUse"
              color-interpolation-filters="sRGB"
            >
              <feFlood flood-opacity="0" result="BackgroundImageFix" />
              <feColorMatrix
                in="SourceAlpha"
                type="matrix"
                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                result="hardAlpha"
              />
              <feOffset dx="4" dy="4" />
              <feGaussianBlur stdDeviation="2" />
              <feComposite in2="hardAlpha" operator="out" />
              <feColorMatrix
                type="matrix"
                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"
              />
              <feBlend
                mode="normal"
                in2="BackgroundImageFix"
                result="effect1_dropShadow_1_4433"
              />
              <feBlend
                mode="normal"
                in="SourceGraphic"
                in2="effect1_dropShadow_1_4433"
                result="shape"
              />
            </filter>
            <linearGradient
              id="paint0_linear_1_4433"
              x1="1440"
              y1="246"
              x2="1"
              y2="246"
              gradientUnits="userSpaceOnUse"
            >
              <stop stop-color="#2D65BD" />
              <stop offset="1" stop-color="#035A74" />
            </linearGradient>
          </defs>
        </svg>

        <div>
          <button onClick={() => handlelogin("employer")}>Hire a Staff</button>
          <button onClick={() => handlelogin("employee")}>Find</button>
        </div>
      </div>
    </div>
  );
};

export default LandingPage;
