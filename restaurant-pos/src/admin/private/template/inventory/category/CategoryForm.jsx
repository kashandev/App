import React from "react";

const CategoryForm = () => {
  return (
    <div className="">
      <form action="#" method="post">
        <div className="d-flex mt-2 gap-2">
          <div className="col-6 px-3 py-2  border rounded-3 d-flex flex-column justify-content-between">
            <div>
              <h5 className="text-purple ps-2 mb-4 pt-2">
                <i className="fa-regular fa-list"></i> Add Category
              </h5>
              <div class=" mb-4 col-12">
                <label htmlFor="" className="input-label">
                  Category Name
                </label>
                <input
                  type="text"
                  class="form-control form-input-control"
                  placeholder="..."
                />
              </div>
            </div>
            <div className="col-12  d-flex gap-1 align-items-center justify-content-end pb-4">
               <button type="button" className="btn rounded-1 me-2 btn-danger">
                <i className="fa-solid fa-plus me-2"></i> Save
                </button>
                <button className="btn rounded-1 btn-purple">
                  <i className="fa-solid fa-remove me-2"></i>Cancel
                </button>
            </div>
          </div>
          <div className="col-6 px-3 py-2  border rounded-3 ">
            <h5 className="text-purple ps-2 mb-4 pt-2">
              <i className="fa-regular fa-sitemap"></i> Add Sub Category
            </h5>

            <div className="row">
              <div class=" mb-4 col-6">
                <label htmlFor="" className="input-label">
                  Sub Category Name
                </label>
                <input
                  type="text"
                  class="form-control form-input-control"
                  placeholder="..."
                />
              </div>
              <div class=" mb-4 col-6">
                <label htmlFor="" className="input-label">
                  Category Name
                </label>
                <input
                  type="text"
                  class="form-control form-input-control"
                  placeholder="..."
                />
              </div>
            </div>

            <div className="row">
              <div class=" mb-4 col-6">
                <label htmlFor="" className="input-label">
                  Status
                </label>
                <select
                  name=""
                  className="form-control form-input-control"
                  id=""
                >
                  <option selected disabled value="">
                    ...
                  </option>
                  <option value="">Active</option>
                  <option value="">UnActive</option>
                </select>
              </div>
              <div className="col-6  d-flex gap-1 align-items-center justify-content-start ">
              <button type="button" className="btn rounded-1 me-2 btn-danger">
                <i className="fa-solid fa-plus me-2"></i> Save
                </button>
                <button className="btn rounded-1 btn-purple">
                  <i className="fa-solid fa-remove me-2"></i>Cancel
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  );
};

export default CategoryForm;
