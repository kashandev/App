import React, { useState,useEffect} from "react";
import "../../css/order_management/order.css";
import CheckoutList from "./CheckoutList";
import Snackbar from "@mui/material/Snackbar";
import MuiAlert from "@mui/material/Alert";
import Cookies from "js-cookie";

const Alert = React.forwardRef(function Alert(props, ref) {
  return <MuiAlert elevation={6} ref={ref} variant="filled" {...props} />;
});

const OrderForm = () => {
const [toastShown, setToastShown] = useState(false);
const [open, setOpen] = useState(false);
const [toastMessage, setToastMessage] = useState("");
const [toastSeverity, setToastSeverity] = useState("info");
const MessageUrl = "http://127.0.0.1:8000/api/showmessage";
const hideMessageUrl = "http://127.0.0.1:8000/api/hidemessage";
const user_name = Cookies.get("user_name");
const new_user_name = user_name.replace(/^"(.*)"$/, '$1');

  useEffect(() => {

    const showMessage = async () => {
      const formData = {
        message_type: 'Welcome'
      };
      try {
        const response = await fetch(MessageUrl, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(formData),
        });

        const data = await response.json();
        if (data.success) {
          showSnackbar('Welcome! ' + ' ' + new_user_name, "success");
         setTimeout(() => {
          setOpen(false);
          hideMessage();
        }, 1000);
      }
      } catch (error) {
        // Handle error
      }
    };

    const hideMessage = async () => {
      const formData = {
        message_type: 'Welcome'
      };
      try {
        const response = await fetch(hideMessageUrl, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(formData),
        });

        const data = await response.json();
      } catch (error) {
        // Handle error
      }
    };

    showMessage();
  });

  const handleToastClose = (event, reason) => {
    if (reason === "clickaway") {
      return;
    }
    setOpen(false);
  };

  const showSnackbar = (message, severity) => {
    setToastMessage(message);
    setToastSeverity(severity);
    setOpen(true);
  };


  return (
    <div className="product-wrapper p-0 d-flex">
      {/* <div className="p-2"> */}
  

  {/* </div> */}
      <div
        className="product-container custom-scroll px-4  bg-transparent w-100 vh-100"
        style={{ overflow: "auto" }}
      >
        {/* <div className="mb-4"> */}

        {/* <div className="bg-white px-2 py-2 rounded-3"> */}
        {/* <h2 className="container-heading">Add New Order</h2> */}
        {/* <p className="container-paragraph mb-0">
            "Go ahead and place an order forto go!
          </p> */}
        {/* </div> */}
        {/* <div className="row  m-0">
          <div className="ps-0" style={{ width: "250px" }}>
            <label htmlFor="" className="input-label">
              Select Waiter
            </label>
            <input type="text" className="form-control" placeholder="..." />
          </div>
          <div className="ps-0" style={{ width: "250px" }}>
            <label htmlFor="" className="input-label">
              Select Table
            </label>
            <input type="text" className="form-control" placeholder="..." />
          </div>
        </div> */}
        <div className=" ps-0  position-relative">
          <label htmlFor="" className="search-icon">
            <i className="fa-regular fa-magnifying-glass"></i>
          </label>
          <input
            type="text"
            className="form-control rounded-1 ps-5 ms-auto placeholder:small"
            placeholder="Search in items, category or something"
          />
        </div>
        <div className="py-3">
          {/* <h5 className="">Product Details</h5> */}
          <div className="w-100 d-flex gap-2 flex-wrap">
            <button
              style={{ fontSize: ".95rem",height:"45px" }}
              className="btn rounded-3 btn-pink "
            >
              <i className="fa-light fa-fork-knife  me-1"></i> All
            </button>
            <button
              style={{ fontSize: ".95rem",height:"45px" }}
              className="btn rounded-3 border  bg-white"
            >
              <i className="fa-light fa-pizza  me-1"></i> Pizza
            </button>
            <button
              style={{ fontSize: ".95rem",height:"45px" }}
              className="btn rounded-3 border  bg-white"
            >
              <i className="fa-light fa-burger me-1 "></i> Burger
            </button>
            <button
              style={{ fontSize: ".95rem",height:"45px" }}
              className="btn rounded-3 border  bg-white"
            >
              <i className="fa-light fa-pizza  me-1"></i> Sandwich
            </button>
            <button
              style={{ fontSize: ".95rem",height:"45px" }}
              className="btn rounded-3 border  bg-white"
            >
              <i className="fa-light fa-burger me-1 "></i> Ice Cream
            </button>
            <button
              style={{ fontSize: ".95rem",height:"45px" }}
              className="btn rounded-3 border  bg-white"
            >
              <i className="fa-light fa-pizza  me-1"></i> Beverages
            </button>
            <button
              style={{ fontSize: ".95rem",height:"45px" }}
              className="btn rounded-3 border  bg-white"
            >
              <i className="fa-light fa-burger me-1 "></i> Chinese
            </button>
             <button style={{fontSize:".95rem"}} className="btn border rounded-1 bg-white"><i className="fa-light fa-pizza  me-1"></i> Italian</button>
            <button style={{fontSize:".95rem"}} className="btn border rounded-1 bg-white"><i className="fa-light fa-burger me-1 "></i> Sea Food</button>
            <button style={{ fontSize: ".95rem",height:"45px" }} className="btn border rounded-1 bg-white"><i className="fa-light fa-pizza  me-1"></i> Sweet</button>
          </div>
        </div>
        <div>
          {/* <h5 className="mt-3">Products</h5> */}
          <div className=" item-container ">
            <div className="item-card bg-white  rounded-4 shadow-sm">
              <div className="card-img"></div>
              <div className="card-body">
                <h6 className="card-title">Smoothie Brown Berry</h6>
                {/* <p className="card-category">Sweet Cakes</p> */}
                <div className="card-bottom">
                  <p>Rs 24.00 <span className="text-secondary small">/ kg</span></p>
                  {/* <button>Order</button> */}
                </div>
              </div>
            </div>
            <div className="item-card bg-white  rounded-4 shadow-sm">
              <div className="card-img"></div>
              <div className="card-body">
                <h6 className="card-title">Smoothie Brown Berry</h6>
                {/* <p className="card-category">Sweet Cakes</p> */}
                <div className="card-bottom">
                  <p>Rs 24.00 <span className="text-secondary small">/ kg</span></p>
                  {/* <button>Order</button> */}
                </div>
              </div>
            </div>
            <div className="item-card bg-white  rounded-4 shadow-sm">
              <div className="card-img"></div>
              <div className="card-body">
                <h6 className="card-title">Smoothie Brown Berry</h6>
                {/* <p className="card-category">Sweet Cakes</p> */}
                <div className="card-bottom">
                  {/* <div> */}
                  <p className="mb-0">Rs 24.00 <span className="text-secondary small">
                    / kg </span>
</p>
                  
                    {/* <span className="small position-absolute fw-bold">/ piece */}
                  {/* </div> */}
                  {/* <button>Order</button> */}
                </div>
              </div>
            </div>
            <div className="item-card bg-white  rounded-4 shadow-sm">
              <div className="card-img"></div>
              <div className="card-body">
                <h6 className="card-title">Smoothie Brown Berry</h6>
                {/* <p className="card-category">Sweet Cakes</p> */}
                <div className="card-bottom">
                  <p>Rs 24.00 <span className="text-secondary small">/ kg</span></p>
                  {/* <button>Order</button> */}
                </div>
              </div>
            </div>
            <div className="item-card bg-white  rounded-4 shadow-sm">
              <div className="card-img"></div>
              <div className="card-body">
                <h6 className="card-title">Smoothie Brown Berry</h6>
                {/* <p className="card-category">Sweet Cakes</p> */}
                <div className="card-bottom">
                  <p>Rs 24.00 <span className="text-secondary small">/ kg</span></p>
                  {/* <button>Order</button> */}
                </div>
              </div>
            </div>
            <div className="item-card bg-white  rounded-4 shadow-sm">
              <div className="card-img"></div>
              <div className="card-body">
                <h6 className="card-title">Smoothie Brown Berry</h6>
                {/* <p className="card-category">Sweet Cakes</p> */}
                <div className="card-bottom">
                  <p>Rs 24.00 <span className="text-secondary small">/ kg</span></p>
                  {/* <button>Order</button> */}
                </div>
              </div>
            </div>
            <div className="item-card bg-white  rounded-4 shadow-sm">
              <div className="card-img"></div>
              <div className="card-body">
                <h6 className="card-title">Smoothie Brown Berry</h6>
                {/* <p className="card-category">Sweet Cakes</p> */}
                <div className="card-bottom">
                  <p>Rs 24.00 <span className="text-secondary small">/ kg</span></p>
                  {/* <button>Order</button> */}
                </div>
              </div>
            </div>
            <div className="item-card bg-white  rounded-4 shadow-sm">
              <div className="card-img"></div>
              <div className="card-body">
                <h6 className="card-title">Smoothie Brown Berry</h6>
                {/* <p className="card-category">Sweet Cakes</p> */}
                <div className="card-bottom">
                  <p>Rs 24.00 <span className="text-secondary small">/ kg</span></p>
                  {/* <button>Order</button> */}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <CheckoutList />
      <Snackbar
          open={open}
          autoHideDuration={6000}
          onClose={handleToastClose}
          anchorOrigin={{ vertical: "top", horizontal: "right" }}
        >
          <Alert onClose={handleToastClose} severity={toastSeverity}>
            {toastMessage}
          </Alert>
        </Snackbar>
    </div>
  );
};

export default OrderForm;
