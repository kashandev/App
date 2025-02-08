// import React, { useEffect, useRef, useState } from "react";
// import "../../css/common/sidebar.css";
// import { NavLink, Link, useLocation } from "react-router-dom";

// const Sidebar = () => {
//   const [activeButton, setActiveButton] = useState(null);
//   const location = useLocation();
//   const handleTabActive = (level) => {
//     setActiveButton(level === activeButton ? null : level);
//   };
//   const asideRef = useRef(null);
//   const handleClickOutside = (event) => {
//     if (asideRef.current && !asideRef.current.contains(event.target)) {
//       setActiveButton(null);
//     }
//   };
//   useEffect(() => {
//     document.addEventListener("click", handleClickOutside);

//     return () => {
//       document.removeEventListener("click", handleClickOutside);
//     };
//   }, []);

//   useEffect(() => {
//     const menuItems = document.querySelectorAll(
//       ".menu-dropdown > .menu-list > .menu-item"
//     );
//     menuItems.forEach((item, i) => {
//       item.children[0].classList.remove("active");
//     });

//     menuItems.forEach((item, i) => {
//       const parentPath = location.pathname.split("/")[1];
//       const childPath = item.children[0].dataset.route;
//       if (childPath == parentPath) {
//         item.children[0].classList.add("active");
//         // setActiveButton(i + 1 );
//       }
//     });
//   }, [location]);
//   const InventorySubMenu = [
//     {
//       icon: "fa-light fa-shopping-bag",
//       title: "Products",
//       url: "/inventory/products",
//     },
//     {
//       icon: "fa-light fa-list-timeline",
//       title: "Category",
//       url: "/inventory/category",
//     },
//     {
//       icon: "fa-light fa-weight-hanging",
//       title: "Units",
//       url: "/inventory/units",
//     },
//   ];
//   const UserSubMenu = [
//     {
//       icon: "fa-light fa-user",
//       title: " Users",
//       url: "/hrm/manage-users",
//     },
//     {
//       icon: "fa-light fa-users",
//       title: " Staff",
//       url: "/hrm/manage-staff",
//     },
//   ];
//   const OrderSubMenu = [
//     {
//       icon: "fa-light fa-grid-2",
//       title: "Create Order",
//       url: "/order/create-order",
//     },
//     {
//       icon: "fa-light fa-shopping-cart",
//       title: "Manage Order",
//       url: "/order/manage-orders",
//     },
//   ];

//   return (
//     <>
//       <div id="aside-overlayer"></div>
//       <aside id="aside-wrapper" ref={asideRef}>
//         <div className="aside-menu-container">
//           <div className="aside-logo">
//             <button>
//               <i className="fa-light fa-3x fa-user-chef"></i>
//             </button>
//           </div>
//           <div className="menu-dropdown">
//             <ul className="menu-list">
//               <li className="menu-item">
//                 <button
//                   data-route="home"
//                   onClick={() => handleTabActive(1)}
//                   className={`menu-toggle ${
//                     activeButton === 1 ? "active" : ""
//                   }`}
//                 >
//                   <i
//                     className={`${
//                       activeButton === 1 ? "fa-solid" : "fa-light"
//                     } fa-home`}
//                   ></i>
//                 </button>
//               </li>

//               <li className="menu-item">
//                 <button
//                   data-route="order"
//                   onClick={() => handleTabActive(2)}
//                   className={`menu-toggle position-relative ${
//                     activeButton === 2 ? "active" : ""
//                   }`}
//                 >
//                   <i
//                     className={` ${
//                       activeButton === 2 ? "fa-solid" : "fa-light"
//                     } fa-shopping-cart`}
//                   ></i>
//                   <i
//                     style={{
//                       right: "10px",
//                       top: "50%",
//                       transform: "translate(0,-50%)",
//                     }}
//                     className={`position-absolute ${
//                       activeButton === 2 ? "fa-solid" : "fa-light"
//                     } fa-angle-right`}
//                   ></i>
//                 </button>
//                 <div
//                   style={{ zIndex: "1" }}
//                   className={`menu-submenu ${
//                     activeButton === 2 ? "active" : ""
//                   }`}
//                 >
//                   <ul className="menu-list">
//                     <div className="menu-list-title">Order</div>
//                     {OrderSubMenu.map((submenu, index) => (
//                       <li
//                         onClick={() => {
//                           setActiveButton(null);
//                         }}
//                         key={index}
//                         className="menu-item"
//                       >
//                         <Link to={submenu.url} className="menu-link">
//                           <i className={submenu.icon}></i>
//                           <span>{submenu.title}</span>
//                         </Link>
//                       </li>
//                     ))}
//                   </ul>
//                 </div>
//               </li>

//               <li className="menu-item">
//                 <button
//                   data-route="hrm"
//                   onClick={() => handleTabActive(3)}
//                   className={`menu-toggle position-relative ${
//                     activeButton === 3 ? "active" : ""
//                   }`}
//                 >
//                   <i
//                     className={` ${
//                       activeButton === 3 ? "fa-solid" : "fa-light"
//                     } fa-user`}
//                   ></i>
//                   <i
//                     style={{
//                       right: "10px",
//                       top: "50%",
//                       transform: "translate(0,-50%)",
//                     }}
//                     className={`position-absolute ${
//                       activeButton === 3 ? "fa-solid" : "fa-light"
//                     } fa-angle-right`}
//                   ></i>
//                 </button>
//                 <div
//                   style={{ zIndex: "1" }}
//                   className={`menu-submenu ${
//                     activeButton === 3 ? "active" : ""
//                   }`}
//                 >
//                   <ul className="menu-list">
//                     <div className="menu-list-title">HRM</div>
//                     {UserSubMenu.map((submenu, index) => (
//                       <li
//                         onClick={() => {
//                           setActiveButton(null);
//                         }}
//                         key={index}
//                         className="menu-item"
//                       >
//                         <Link to={submenu.url} className="menu-link">
//                           <i className={submenu.icon}></i>
//                           <span>{submenu.title}</span>
//                         </Link>
//                       </li>
//                     ))}
//                   </ul>
//                 </div>
//               </li>

//               <li className="menu-item">
//                 <button
//                   data-route="inventory"
//                   onClick={() => handleTabActive(4)}
//                   className={`menu-toggle position-relative ${
//                     activeButton === 4 ? "active" : ""
//                   }`}
//                 >
//                   <i
//                     className={` ${
//                       activeButton === 4 ? "fa-solid" : "fa-light"
//                     } fa-box`}
//                   ></i>
//                   <i
//                     style={{
//                       right: "10px",
//                       top: "50%",
//                       transform: "translate(0,-50%)",
//                     }}
//                     className={`position-absolute ${
//                       activeButton === 4 ? "fa-solid" : "fa-light"
//                     } fa-angle-right`}
//                   ></i>
//                 </button>
//                 <div
//                   style={{ zIndex: "1" }}
//                   className={`menu-submenu ${
//                     activeButton === 4 ? "active" : ""
//                   }`}
//                 >
//                   <ul className="menu-list">
//                     <div className="menu-list-title">Inventory</div>
//                     {InventorySubMenu.map((submenu, index) => (
//                       <li
//                         onClick={() => {
//                           setActiveButton(null);
//                         }}
//                         key={index}
//                         className="menu-item"
//                       >
//                         <Link to={submenu.url} className="menu-link">
//                           <i className={submenu.icon}></i>
//                           <span>{submenu.title}</span>
//                         </Link>
//                       </li>
//                     ))}
//                   </ul>
//                 </div>
//               </li>

//               <li className="menu-item">
//                 <button
//                   data-route="setting"
//                   onClick={() => handleTabActive(5)}
//                   className={`menu-toggle ${
//                     activeButton === 5 ? "active" : ""
//                   }`}
//                 >
//                   <i
//                     className={`${
//                       activeButton === 5 ? "fa-solid" : "fa-light"
//                     } fa-gear `}
//                   ></i>
//                 </button>
//               </li>
//             </ul>
//           </div>
//         </div>
//         <div className="aside-bottom">
//           <button>
//             <i className="fa-regular fa-arrow-right-to-bracket"></i>
//           </button>
//         </div>
//       </aside>
//     </>
//   );
// };

// export default Sidebar;
import React, { useState, useRef, useEffect } from "react";
import "../../css/common/sidebar.css";
import { NavLink, Link, useLocation } from "react-router-dom";

const Sidebar = () => {
  const [activeButton, setActiveButton] = useState(null);
  const location = useLocation();
  const asideRef = useRef(null);
  const InventorySubMenu = [
    {
      icon: "fa-light fa-shopping-bag",
      title: "Item",
      url: "/inventory/item",
    },
    {
      icon: "fa-light fa-list-timeline",
      title: "Category",
      url: "/inventory/category",
    },
    {
      icon: "fa-light fa-weight-hanging",
      title: "Unit",
      url: "/inventory/unit",
    },
  ];
  const UserSubMenu = [
    {
      icon: "fa-light fa-user",
      title: " Users",
      url: "/hrm/manage-users",
    },
    {
      icon: "fa-light fa-users",
      title: " Staff",
      url: "/hrm/manage-staff",
    },
  ];
  const OrderSubMenu = [
    {
      icon: "fa-light fa-grid-2",
      title: "Add New Order",
      url: "/order/add-new-order",
    },
    {
      icon: "fa-light fa-shopping-cart",
      title: "Manage Order",
      url: "/order/manage-orders",
    },
  ];
  const SetupSubMenu = [
   
    {
      icon: "fa-light fa-table-picnic",
      title: "Assign Table",
      url: "/setup/assign-table",
    },
     {
      icon: "fa-light fa-chair",
      title: "Manage Table",
      url: "/setup/manage-table",
    },
  ];
  const navItems = [
    {
      route: "setup",
      icon: "fa-home",

      submenu: SetupSubMenu,
    },

    {
      route: "hrm",
      icon: "fa-user",
      submenu: UserSubMenu,
    },
    {
      route: "order",
      icon: "fa-shopping-cart",
      submenu: OrderSubMenu,
    },
    {
      route: "inventory",
      icon: "fa-box",
      submenu: InventorySubMenu,
    },
    {
      route: "setting",
      icon: "fa-gear",
    },
    {
      route: "logout",
      icon: "fa-sign-out",
    },
  ];

  const handleTabActive = (level) => {
    setActiveButton((prevLevel) => (prevLevel === level ? null : level));
  };

  const handleClickOutside = (event) => {
    if (asideRef.current && !asideRef.current.contains(event.target)) {
      setActiveButton(null);
    }
  };
  function capitalizeFirstLetter(sentence) {
    return sentence.charAt(0).toUpperCase() + sentence.slice(1);
  }
  useEffect(() => {
    document.addEventListener("click", handleClickOutside);

    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
  }, []);

  useEffect(() => {
    const menuItems = document.querySelectorAll(
      ".menu-dropdown > .menu-list > .menu-item"
    );
    menuItems.forEach((item) => {
      item.children[0].classList.remove("active");
    });

    const parentPath = location.pathname.split("/")[1];

    menuItems.forEach((item, index) => {
      const childPath = item.children[0].dataset.route;
      console.log(item);

      if (childPath === parentPath) {
        item.children[0].classList.add("active");
      }
    });
  }, [location]);

  return (
    <>
      <div id="aside-overlayer"></div>
      <aside id="aside-wrapper" ref={asideRef}>
        <div className="aside-menu-container">
          <div className="aside-logo">
            <button>
              <i className="fa-light fa-3x fa-user-chef"></i>
            </button>
          </div>
          <div className="menu-dropdown">
            <ul className="menu-list">
              {navItems.map((item, index) => (
                <li key={index} className="menu-item">
                  {item.submenu ? (
                    <button
                      data-route={item.route}
                      onClick={() => handleTabActive(index)}
                      className={`menu-toggle position-relative ${
                        activeButton === index ? "active" : ""
                      }`}
                    >
                      <i
                        className={` ${
                          activeButton === index ? "fa-solid" : "fa-light"
                        } ${item.icon}`}
                      ></i>
                      {/* <i
                        style={{
                          right: "10px",
                          top: "50%",
                          transform: "translate(0,-50%)",
                        }}
                        className={`position-absolute ${
                          activeButton === index ? "fa-solid" : "fa-light"
                        } fa-angle-right`}
                      ></i> */}
                    </button>
                  ) : (
                    <NavLink
                      onClick={() => {
                        setActiveButton(null);
                      }}
                      data-route={item.route}
                      to={`/${item.route}`}
                      className={`menu-link menu-toggle ${
                        activeButton === index ? "active" : ""
                      }`}
                    >
                      <i className={`fa-light ${item.icon}`}></i>
                    </NavLink>
                  )}
                  {item.submenu && (
                    <div
                      style={{ zIndex: "1" }}
                      className={`menu-submenu ${
                        activeButton === index ? "active" : ""
                      }`}
                    >
                      <ul className="menu-list">
                        <div className="menu-list-title">{capitalizeFirstLetter(item.route)}</div>
                        {item.submenu.map((submenuItem, subIndex) => (
                          <li
                            key={subIndex}
                            onClick={() => {
                              setActiveButton(null);
                            }}
                            className="menu-item"
                          >
                            <Link to={submenuItem.url} className="menu-link">
                              <i className={submenuItem.icon}></i>
                              <span>{submenuItem.title}</span>
                            </Link>
                          </li>
                        ))}
                      </ul>
                    </div>
                  )}
                </li>
              ))}
            </ul>
          </div>
        </div>
        {/* <div className="aside-bottom">
          <button>
            <i className="fa-regular fa-arrow-right-to-bracket"></i>
          </button>
        </div> */}
      </aside>
    </>
  );
};

export default Sidebar;
