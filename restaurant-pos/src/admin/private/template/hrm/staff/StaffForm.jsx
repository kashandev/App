import React from "react";
import "../../../css/staff/staff.css";
const StaffForm = () => {
  return (
<div className="">
   <form action="#" method="post">
      <div className="row mt-4">
         <div className="col-4">
            <div class=" mb-4 col-12">
               <label htmlFor="" className="input-label">
               Staff Type
               </label>
               <select name="staff_type" id="staff_type" className="form-control form-input-control">
                  <option selected disabled value="">
                     ...
                  </option>
                  <option value="Manager">Manager</option>
                  <option value="Waiter">Waiter</option>
               </select>
            </div>
         </div>
         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               Staff Name
               </label>
               <input
                  type="text" name="staff_name" id="staff_name"
                  class="form-control form-input-control"
                  placeholder="..."
                  />
            </div>
         </div>
      </div>
      <div className="row">
         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               Email
               </label>
               <input
                  type="email" name="email" id="email"
                  class="form-control form-input-control"
                  placeholder="..."
                  />
            </div>
         </div>

         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               Cnic
               </label>
               <input
                  type="text" name="cnic" id="cnic"
                  class="form-control form-input-control"
                  placeholder="..."
                  />
            </div>
         </div>

      </div>
      <div className="row">
         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               Mobile No
               </label>
               <input
                  type="mobile" name="mobile_no" id="mobile_no"
                  class="form-control form-input-control"
                  placeholder="..."
                  />
            </div>
         </div>
         <div className="col-4">
            <div class=" mb-4 col-12">
               <label htmlFor="" className="input-label">
               Gender
               </label>
               <select name="gender" id="gender" className="form-control form-input-control">
                  <option selected disabled value="">
                     ...
                  </option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
               </select>
            </div>
         </div>
         </div>
         <div className="row">

         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               City
               </label>
               <input
                  type="text" name="cnic" id="cnic"
                  class="form-control form-input-control"
                  placeholder="..."
                  />
            </div>
         </div>
         <div class="col-4">
              <label htmlFor="" className="input-label">
               Address
              </label>
            <textarea placeholder="..." name="address" id="address"className="d-block form-control" rows="3"></textarea>
         </div>
         </div>

         <div className="row mt-1">
         <div className="col-6 d-flex gap-1">
              <button type="button" className="btn rounded-1 me-2 btn-danger">
              <i className="fa-solid fa-plus me-2"></i>Save
              </button>
              <button type="button"  className="btn rounded-1 btn-purple">
                <i className="fa-solid fa-remove me-2"></i>Cancel
              </button>
            </div>
          </div>
      <div className="row mt-4"></div>
   </form>
</div>
  );
};

export default StaffForm;
