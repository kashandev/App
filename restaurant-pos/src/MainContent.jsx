import React from "react";
import { Routes, Route, Navigate } from "react-router-dom";
import ItemContainer from "./admin/private/template/inventory/item/ItemContainer";
import Sidebar from "./admin/private/template/common/Sidebar";
import CategoryContainer from "./admin/private/template/inventory/category/CategoryContainer";
import UnitContainer from "./admin/private/template/inventory/unit/UnitContainer";
import UserContainer from "./admin/private/template/hrm/user/UserContainer";
import OrderForm from "./admin/private/template/order_management/OrderForm";
import OrderContainer from "./admin/private/template/order_management/OrderContainer";
import StaffContainer from "./admin/private/template/hrm/staff/StaffContainer";
import AssignTableContainer from "./admin/private/template/setup/assign_table/AssignTableContainer";
import TableContainer from "./admin/private/template/setup/table/TableContainer";
import Logout from "./admin/private/template/common/Logout";
// ... other route components

const MainContent = () => {
  return (
    <div className="main-wrapper">
      <Sidebar />
      <Routes>
        {/* assign table */}
        <Route path="/setup/assign-table" element={<AssignTableContainer />} />
        <Route path="/setup/manage-table" element={<TableContainer />} />
        {/* order */}
        <Route path="/" element={<Navigate to="/order/add-new-order" />} />
        <Route path="/order/add-new-order" element={<OrderForm />} />
        <Route path="/order/manage-orders" element={<OrderContainer />} />
        {/* inventory */}
        <Route path="/inventory/item" element={<ItemContainer />} />
        <Route path="/inventory/category" element={<CategoryContainer />} />
        <Route path="/inventory/unit" element={<UnitContainer />} />
        {/* user */}
        <Route path="/hrm/manage-users" element={<UserContainer />} />
        <Route path="/hrm/manage-staff" element={<StaffContainer />} />
        <Route path="/logout" element={<Logout />} />
      </Routes>
    </div>
  );
};

export default MainContent;
