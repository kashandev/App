import "./App.css";
import React, { useState, useEffect } from "react";
import Cookies from "js-cookie";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import Login from "./admin/private/template/common/Login";
import Error from "./admin/private/template/common/Error";
import MainContent from "./MainContent";
import ProtectedRoute from "./ProtectedRoute";
import Logout from "./admin/private/template/common/Logout"; // Import the Logout component

function App() {
  const [auth, setAuth] = useState(null);

  useEffect(() => {
    const token = Cookies.get("api_token");
    if (token) {
      setAuth(true);
    } else {
      setAuth(false);
    }
  }, []);

  const handleLogout = () => {
    Cookies.remove("api_token");
    setAuth(false);
  };

  return (
    <Router>
      <Routes>
        <Route path="/login" element={<Login setAuth={() => setAuth(true)} />} />
        <Route path="/logout" element={<Logout onLogout={handleLogout} />} />

        {auth === false ? (
          <>
            <Route path="/" element={<Navigate to="/login" />} />
            <Route path="*" element={<Error />} />
          </>
        ) : (
          <Route
            path="*"
            element={
              <ProtectedRoute auth={auth}>
                <MainContent onLogout={handleLogout} />
              </ProtectedRoute>
            }
          />
        )}
      </Routes>
    </Router>
  );
}

export default App;
