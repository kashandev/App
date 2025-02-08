import React from "react";
import TableList from "./TableList";
import { Link } from "react-router-dom";

const TableForm = () => {
  return (
    <div className="">
      <form action="#" method="post">
        <div className="row mt-4">
          <div className="col-4">
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
                Table Name
              <code> (Auto)</code>
                
              </label>
                <input
                  disabled
                  type="text"
                  class="form-control form-input-control"
                  placeholder="TABLE-01"
                />
           
            </div>
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
               No. of chairs <code> (optional)</code>
              </label>
              <input
                type="text"
                class="form-control form-input-control"
                placeholder="..."
              />
          
            </div>
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
             Select Waiter <code> (optional)</code>
              </label>
              <input
                type="text"
                class="form-control form-input-control"
                placeholder="..."
              />
              <span  className="small"> Assign a table to the waiter</span>
         
            </div>

            <div className="col-12 d-flex gap-1 align-items-end justify-content-start p-0">
              <button type="button" className="btn rounded-1 btn-danger">
                <i className="fa-solid fa-plus me-2"></i>Create table
              </button>
            </div>
          </div>
          <div className="col-8">
            <TableList />
          </div>
        </div>
      </form>
    </div>
  );
};

export default TableForm;
