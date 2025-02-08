import React from "react";

const UnitForm = () => {
  return (
    <div className="">
   <form action="#" method="post">
      <div className="row mt-4">
         <div className="col-4">
            <div class=" mb-4 col-412">
               <label htmlFor="" className="input-label">
               Unit
               </label>
               <input
                  type="text" name="unit" id="unit"
                  class="form-control form-input-control"
                  placeholder="..."
                  />
            </div>
         </div>
      </div>
         <div className="row">
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

export default UnitForm;
