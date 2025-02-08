import React, { useRef, useState, useEffect } from "react";
import Cookies from "js-cookie";
import Snackbar from "@mui/material/Snackbar";
import MuiAlert from "@mui/material/Alert";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faSpinner } from '@fortawesome/free-solid-svg-icons';
import { faPlus } from '@fortawesome/free-solid-svg-icons';
import "../../../css/hrm/user.css";

const Alert = React.forwardRef(function Alert(props, ref) {
   return <MuiAlert elevation={6} ref={ref} variant="filled" {...props} />;
 });
 const Spinner = () => (
   <div className="spinner-container">
     <FontAwesomeIcon icon={faSpinner} className="fa-light fa-spinner-third fa-spin spinner" />
   </div>
 );

 const Plus = () => (
   <div className="spinner-container">
     <FontAwesomeIcon icon={faPlus}  className="fa-solid fa-plus me-2" />Save
   </div>
 );


const UserForm = () => {
   const apiUrl = "http://127.0.0.1:8000/api/adduser";
   const MessageUrl = "http://127.0.0.1:8000/api/showmessage";
   const hideMessageUrl = "http://127.0.0.1:8000/api/hidemessage";
   const [isLoading, setLoading] = useState(false);
   const [isShowTypeError, setTypeError] = useState(false);
   const [isShowUserError, setUserError] = useState(false);
   const [isShowLoginError, setLoginError] = useState(false);
   const [isShowEmailError, setEmailError] = useState(false);
   const [isShowPasswordError, setPasswordError] = useState(false);
   const [isShowUserValidError, setUserValidError] = useState(false);
   const [isShowLoginValidError, setLoginValidError] = useState(false);
   const [isShowEmailValidError, setEmailValidError] = useState(false);
   const [isShowPasswordValidError, setPasswordValidError] = useState(false);
   const [isPasswordMatchError, setPasswordMatchError] = useState(false);
   const [open, setOpen] = useState(false);
   const [toastMessage, setToastMessage] = useState("");
   const [toastSeverity, setToastSeverity] = useState("info");
   const usertypeRef = useRef(null);
   const usernameRef = useRef(null);
   const loginNameRef = useRef(null);
   const emailRef = useRef(null);
   const passwordhashRef = useRef(null);
   const confirmpasswordhashRef = useRef(null);

   useEffect(() => {
      const handleNavigation = () => {
        Navigate("/order/add-new-order");
      };
          if (usernameRef.current) {
            usernameRef.current.focus();
      }
    }, []);

    
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

   // Alphanumeric regex: allows letters (both uppercase and lowercase) and numbers
   const alphanumericRegex = /^[a-zA-Z]+[a-zA-Z0-9. ]*$/;
   const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
   const passwordRegex = /^(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z0-9@$!%*?&]{8,}$/;

   const handleValidUser = (e) => {
       const username = usernameRef.current.value;
       if(username == ''){
        setUserValidError(false);
       }
       else {
       if(!alphanumericRegex.test(username)){
        setUserValidError(true);
       }
       else {
        setUserValidError(false);
       }
      }
   };

   const handleValidLogin = (e) => {
    const loginname = loginNameRef.current.value;
    if(loginname == ''){
      setLoginValidError(false);
     }
     else {
    if(!alphanumericRegex.test(loginname)){
      setLoginValidError(true);
    }
    else {
      setLoginValidError(false);
    }
  }
};

const handleValidEmail = (e) => {
  const email = emailRef.current.value;
  if(email == ''){
    setEmailValidError(false);
   }
   else {
  if(!emailRegex.test(email)){
    setEmailValidError(true);
}
else {
    setEmailValidError(false);
}
}
};

   const handleValidPassword = (e) => {
      const password = passwordhashRef.current.value;
      if(password == ''){
        setPasswordValidError(false);
       }
       else {
      if(!passwordRegex.test(password)){
        setPasswordValidError(true);
    }
    else {
        setPasswordValidError(false);
    }
  }
};

const handleMatchPassword = (e) => {
  const password = passwordhashRef.current.value;
  const confirmpassword = confirmpasswordhashRef.current.value;
  if(confirmpassword == ''){
    setPasswordMatchError(false);
   }
   else {
  if(password != confirmpassword){
    setPasswordMatchError(true);
   }
   else {
    setPasswordMatchError(false);
}
   }
};



    const showMessage = async (message) => {
      const formData = {
         message_type: 'Create User'
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
          showSnackbar(message.title + " " + message.message, "success");
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
        message_type: 'Create User'
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

    const AddUser = async (e) => {
      e.preventDefault();
 

       const formData = {
         created_by: Cookies.get("user_name"),
         user_type: usertypeRef.current.value,
         user_name: usernameRef.current.value,
         login_name: loginNameRef.current.value,
         email: emailRef.current.value,
         password_hash: passwordhashRef.current.value,
       };

       if(usertypeRef.current.value == ''){
        setTypeError(true);
       }
       if(usernameRef.current.value == ''){
        setUserError(true);
       }
       if(loginNameRef.current.value == ''){
        setLoginError(true);
       }
       if(emailRef.current.value == ''){
        setEmailError(true);
       }
       if(passwordhashRef.current.value == ''){
        setPasswordError(true);
       }  
       else{
        resetError();
        setLoading(true);
      try {
        const response = await fetch(apiUrl, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(formData),
        });

        const data = await response.json();

         if(data.success == true){
          setTimeout(() => {
            setLoading(false);
          }, 400);
          setTimeout(() => {
            showMessage(data);
            resetForm();
          }, 500);

         }
         else {
          setTimeout(() => {
            setLoading(false);
          }, 400);
          setTimeout(() => {
          showSnackbar(data.title + " " + data.message, "error");
          }, 500);
          setTimeout(() => {
            setOpen(false);
          }, 1500);
         }
      } catch (error) {
        // Handle error
      }
     }
    };

    const resetError = async () => {
      setTypeError(false);
      setUserError(false); 
      setLoginError(false);
      setEmailError(false);
      setPasswordError(false);
      setUserValidError(false);
      setLoginValidError(false);
      setPasswordValidError(false);
      setPasswordMatchError(false);
    };
  
    const resetForm = async () => {
      usertypeRef.current.value = '';
      usernameRef.current.value = '';
      loginNameRef.current.value = '';
      emailRef.current.value = '';
      passwordhashRef.current.value = '';
      confirmpasswordhashRef.current.value = '';
      usernameRef.current.focus();
    };
    const Reset = async (e) => {
      resetError();
      resetForm();
      setLoading(false);

    };
  return (
<div className="">
   <form onSubmit={AddUser}>
      <div className="row mt-4">
         <div className="col-4">
            <div class=" mb-4 col-12">
               <label htmlFor="" className="input-label">
               User Type
               </label>
               <select name="user_type" id="user_type" className="form-control form-input-control" ref={usertypeRef}>
                  <option selected disabled value="">
                     User-Type
                  </option>
                  <option value="Administrator">Administrator</option>
                  <option value="Staff">Staff</option>
               </select>
                {isShowTypeError == true  ? (
                  <label htmlFor="" className="error">User Type is required !</label>
                 ) : (
                 ''
                )}
            </div>
         </div>
         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               User Name
               </label>
               <input
                  type="text" name="user_name" id="user_name"
                  class="form-control form-input-control"
                  ref={usernameRef}
                  placeholder="Username"
                   autoComplete="off"
                   onChange={handleValidUser}
                  />
                  {isShowUserError == true  ? (
                  <label htmlFor="" className="error">User Name is required !</label>
                 ) : (
                 ''
                )}
                {isShowUserValidError == true  ? (
                  <label htmlFor="" className="error">Invalid User Name !</label>
                 ) : (
                 ''
                )}
            </div>
         </div>
      </div>
      <div className="row">
         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               Login Name
               </label>
               <input
                  type="text" name="login_name" id="login_name"
                  class="form-control form-input-control" ref={loginNameRef}
                  placeholder="Login Name"
                   autoComplete="off"
                   onChange={handleValidLogin}
                  />
                  {isShowLoginError == true  ? (
                  <label htmlFor="" className="error">Login Name is required !</label>
                 ) : (
                 ''
                )}
                {isShowLoginValidError == true  ? (
                  <label htmlFor="" className="error">Invalid Login Name !</label>
                 ) : (
                 ''
                )}
            </div>
         </div>
         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               Email
               </label>
               <input
                  type="email" name="email" id="email"
                  class="form-control form-input-control" ref={emailRef}
                  placeholder="Email"
                   autoComplete="off"
                   onChange={handleValidEmail}

                  />
                  {isShowEmailError == true  ? (
                  <label htmlFor="" className="error">Email is required !</label>
                 ) : (
                 ''
                )}

                  {isShowEmailValidError == true  ? (
                  <label htmlFor="" className="error"> Invalid Email !</label>
                 ) : (
                 ''
                )}
                  
            </div>
         </div>
      </div>
      <div className="row">
         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               Password
               </label>
               <input
                  type="password" name="password_hash" id="password_hash"
                  class="form-control form-input-control" ref={passwordhashRef}
                  placeholder="Password"
                  autoComplete="off"
                  onChange={handleValidPassword}
                  />
                   {isShowPasswordError == true  ? (
                  <label htmlFor="" className="error">Password is required !</label>
                 ) : (
                 ''
                )}
                 {isShowPasswordValidError == true  ? (
                  <label htmlFor="" className="error">Password must be at leat 8 characters !</label>
                 ) : (
                 ''
                )}
            </div>
         </div>
         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               Confirm Password
               </label>
               <input
                  type="password" name="confirm_password_hash" id="confirm_password_hash"
                  class="form-control form-input-control" ref={confirmpasswordhashRef}
                  placeholder="Confirm Password"
                   autoComplete="off"
                   onChange={handleMatchPassword}
                  />
                  {isPasswordMatchError == true  ? (
                  <label htmlFor="" className="error"> Confirm Password not matched by password !</label>
                 ) : (
                 ''
                )}
            </div>
         </div>
         <div className="row">
         <div className="col-6 d-flex gap-1">
         <button
              type="submit"
              className={`btn ${isLoading && "disable"}  rounded-1 me-2 btn-danger` }
            >
              {isLoading && isLoading == true  ? (
                <Spinner />
              ) : (
               <Plus />
              )}
            </button>
              <button type="button" className="btn rounded-1 btn-purple"  onClick={Reset}>
                <i className="fa-solid fa-remove me-2"></i>Cancel
              </button>
            </div>
          </div>
      </div>
      <div className="row mt-4"></div>
   </form>
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
export default UserForm;
