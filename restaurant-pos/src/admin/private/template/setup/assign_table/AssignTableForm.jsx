import React from "react";
import AssignTableList from "./AssignTableList";
import { Link } from "react-router-dom";

const AssignTableForm = () => {
  return (
    <div className="">
      <form action="#" method="post">
        <div className="row mt-4">
        <div className="col-4">
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
                Select Waiter
              </label>
              <input
                type="text"
                class="form-control form-input-control"
                placeholder="..."
              />
              <Link to={`/hrm/manage-staff`} className="input-label text-success small " style={{textDecoration:"none"}}>
                <i className="fa-solid fa-plus"></i> create new waiter
              </Link>
            </div>
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
                Select Table
              </label>
              <input
                type="text"
                class="form-control form-input-control"
                placeholder="..."
              />
              <Link to={`/setup/manage-table`} className="input-label text-success small " style={{textDecoration:"none"}}>
                <i className="fa-solid fa-plus"></i> create new table
              </Link>
            </div>
    
            <div className="col-12 d-flex gap-1 align-items-end justify-content-start p-0">
              <button type="button" className="btn rounded-1 btn-danger">
                <i className="fa-solid fa-plus me-2"></i>Assign Now
              </button>
            </div>
          </div>
        <div className="col-8">
          <AssignTableList/>
          </div>
          
      
      
      
       
        </div>
      </form>
    </div>
  );
};

export default AssignTableForm;
