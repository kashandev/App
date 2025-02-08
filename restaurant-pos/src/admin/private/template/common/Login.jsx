import React, { useRef, useState, useEffect } from "react";
import Cookies from "js-cookie";
import { useNavigate } from "react-router-dom";
import Snackbar from "@mui/material/Snackbar";
import MuiAlert from "@mui/material/Alert";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faSpinner } from '@fortawesome/free-solid-svg-icons';

const Alert = React.forwardRef(function Alert(props, ref) {
  return <MuiAlert elevation={6} ref={ref} variant="filled" {...props} />;
});
const Spinner = () => (
  <div className="spinner-container">
    <FontAwesomeIcon icon={faSpinner} className="fa-light fa-spinner-third fa-spin spinner" />
  </div>
);

const Login = ({ setAuth }) => {
  const [isPasswordShow, setPasswordShow] = useState(false);
  const [isLoading, setLoading] = useState(false);

  const usernameRef = useRef(null);
  const passwordRef = useRef(null);

  const apiUrl = "http://127.0.0.1:8000/api/login";
  const logoutUrl = "http://127.0.0.1:8000/api/logout";
  const MessageUrl = "http://127.0.0.1:8000/api/showmessage";
  const hideMessageUrl = "http://127.0.0.1:8000/api/hidemessage";
  const Navigate = useNavigate();
  const [toastShown, setToastShown] = useState(false);
  const [open, setOpen] = useState(false);
  const [toastMessage, setToastMessage] = useState("");
  const [toastSeverity, setToastSeverity] = useState("info");
  const logoutCalledRef = useRef(false); // Ref to track if logout has been called


  useEffect(() => {
    const token = Cookies.get("api_token");

    const handleNavigation = () => {
      Navigate("/order/add-new-order");
    };

    const Logout = async () => {
      const formData = {
        user_name: Cookies.get("user_name"),
        user_type: Cookies.get("user_type"),
      };
      try {
        const response = await fetch(logoutUrl, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(formData),
        });

        const data = await response.json();
        if (data.success) {
          setTimeout(() => {
            showMessage();
          }, 100);

        }
      } catch (error) {
        // Handle error
      }
    };

    const showMessage = async () => {
      const formData = {
        message_type: 'Logout'
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
        showSnackbar('Logout! Successfully Logged out.', "success");
        setTimeout(() => {
          setOpen(false);
          hideMessage();
        }, 500);
      }
      } catch (error) {
        // Handle error
      }
    };

    const hideMessage = async () => {
      const formData = {
        message_type: 'Logout'
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

    if (token) {
      handleNavigation();
    } else if (!logoutCalledRef.current) { // Call handleLogout only if logout has not been called
      Logout();
      logoutCalledRef.current = true; // Set ref to true after calling logout
    }
    if (usernameRef.current) {
      usernameRef.current.focus();
    }
  }, [setAuth]);

  const togglePasswordVisibility = () => {
    setPasswordShow(!isPasswordShow);
  };

  const setCookieWithExpiry = (name, value) => {
    const expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + 1);
    expirationDate.setHours(0, 0, 0, 0);

    Cookies.set(name, value, {
      expires: expirationDate,
      secure: true,
      sameSite: "strict",
    });
  };

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

  const handleSubmit = async (e) => {
    e.preventDefault();
    const username = usernameRef.current.value;
    const password = passwordRef.current.value;
    if (username === "" && password === "") {
      showSnackbar("Empty fields! Username and Password are required.", "error");
        usernameRef.current.focus();
        setTimeout(() => {
          setOpen(false);
        }, 1500);
    } else if (username === "") {
      showSnackbar("Empty field! Username is required.", "error");
      usernameRef.current.focus();
      setTimeout(() => {
        setOpen(false);
      }, 1500);
    } else if (password === "") {
      showSnackbar("Empty field! Password is required.", "error");
      passwordRef.current.focus();
      setTimeout(() => {
        setOpen(false);
      }, 1500);
    } else {
      const formData = {
        login_name: username,
        password_hash: password,
      };
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
        if (data.success) {
          setCookieWithExpiry("user_id", JSON.stringify(data.user.user_id));
          setCookieWithExpiry("user_name", JSON.stringify(data.user.user_name));
          setCookieWithExpiry("user_type", JSON.stringify(data.user.user_type));
          setCookieWithExpiry("session_start", JSON.stringify(data.session_start));
          setCookieWithExpiry("session_end", JSON.stringify(data.session_end));
          setCookieWithExpiry("api_token", data.api_token);

          if (!toastShown) {
            setTimeout(() => {
              setLoading(false);
            }, 300);
            setTimeout(() => {
              showSnackbar(data.title + " " + data.success, "success");
            }, 500);
            setTimeout(() => {
              setOpen(false);
            }, 1500);
          }

          setTimeout(() => {
            setAuth(true);
          }, 2000);
        } else {
          setTimeout(() => {
            setLoading(false);
          }, 300)
          setTimeout(() => {
            showSnackbar(data.title + " " + data.error, "error");
          }, 500);
          setTimeout(() => {
            setOpen(false);
          }, 1500);
        }
      } catch (error) {
        setTimeout(() => {
          setLoading(false);
        }, 300)
        setTimeout(() => {
          showSnackbar("An unexpected error occurred", "error");
        }, 500);
        setTimeout(() => {
          setOpen(false);
        }, 1500);
  
        console.error(error);
      }
    }
  };

  return (
    <div className="col-12 vh-100 d-flex justify-content-center align-items-center">
      <div className="col-4 px-3">
        <div className="text-center">
          <div className="login-logo">
            <img
              src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
              height={60}
              width={60}
              alt=""
            />
          </div>
          <h1 className="text-dark fw-bold fs-2 my-4">Sign In</h1>
        </div>
        <form onSubmit={handleSubmit}>
          <div className="form-group mb-4">
            <label htmlFor="username" className="mb-1 text-dark">
              Username
            </label>
            <input
              type="text"
              id="username"
              ref={usernameRef}
              className="form-control input-control"
              autoComplete="off"
              placeholder="Username"
            />
          </div>

          <div className="form-group position-relative">
            <label htmlFor="password" className="mb-1 text-dark">
              Password
            </label>
            <input
              type={isPasswordShow ? "text" : "password"}
              ref={passwordRef}
              id="password"
              className="form-control input-control"
              autoComplete="off"
              placeholder="Password"
            />
            <span
              onClick={togglePasswordVisibility}
              className="position-absolute bottom-0 end-0 pt-2 px-3 "
              style={{ paddingBottom: "7px" }}
            >
              <i
                className={`fa-regular ${
                  isPasswordShow
                    ? "fa-eye text-dark"
                    : "fa-eye-slash text-secondary"
                }`}
              ></i>
            </span>
          </div>
          <div className="mt-4 pt-2">
            <button
              type="submit"
              className={`btn ${isLoading && "disable"} btn-purple col-12` }
            >
              {isLoading && isLoading == true  ? (
                <Spinner />
              ) : (
                "Login"
              )}
            </button>
          </div>
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
    </div>
  );
};

export default Login;
