import React from "react";

const ItemForm = () => {
  return (
    <div className="">
      <form action="#" method="post">
        <div className="row mt-4">
          <div className="col-4">
            <div class=" mb-4 col-412">
              <label htmlFor="" className="input-label">
                Item Name
              </label>
              <input
                type="text"
                class="form-control form-input-control"
                placeholder="..."
              />
            </div>
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
                Category
              </label>

              <select name="" className="form-control form-input-control" id="">
                <option selected disabled value="">
                  ...
                </option>
                <option value="burger">Burger</option>
              </select>
            </div>
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
                Sub Category
              </label>

              <select name="" className="form-control form-input-control" id="">
                <option selected disabled value="">
                  ...
                </option>
                <option value="chicken_burger">Chicken Burger</option>
              </select>
            </div>
          </div>
          <div className="col-4">
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
              Unit
              </label>
              <select name="" className="form-control form-input-control" id="">
                <option selected disabled value="">
                  ...
                </option>
                <option value="">s</option>
                <option value="">s</option>
                <option value="">s</option>
                <option value="">s</option>
              </select>
            </div>
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
                Rate
              </label>
              <input
                type="text"
                class="form-control form-input-control"
                placeholder="..."
              />
            </div>
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
                Status
              </label>
              <select name="" className="form-control form-input-control" id="">
                <option selected disabled value="">
                  ...
                </option>
                <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div className="col-4">
            <div class=" mb-4 col-12">
              <label htmlFor="" className="input-label">
                Select Image Here
              </label>
              <label htmlFor="image_cover" className="input-label image-box">
                {/* <div className="image-preview">
                </div> */}
                <div className="image-title">
                  <i className="fa-light fa-image fa-3x text-purple mb-2"></i>
                  <label htmlFor="image_cover" className="mb-0 d-block">
                    Drop Your Image Here...
                  </label>
                  <p className="mb-0 text-secondary small">
                    File limit should be 5mb
                  </p>
                </div>
              </label>
              <input type="file" class="d-none" id="image_cover" />
            </div>
          </div>

          <div className="row m-0">
          <div class="col-8 p-0">
              <label htmlFor="" className="input-label">
             Description
              </label>
            <textarea placeholder="..." name="" className="d-block form-control" rows="3"></textarea>
            </div>
            <div className="col-4  d-flex gap-1 align-items-end justify-content-end p-0">
              <button type="button" className="btn rounded-1 me-2 btn-danger">
              <i className="fa-solid fa-plus me-2"></i>Save
              </button>
              <button type="button" className="btn rounded-1 btn-purple">
              <i className="fa-solid fa-remove me-2"></i>Cancel
              </button>
            </div>
          </div>
          <div className="row mt-4"></div>
        </div>
      </form>
    </div>
  );
};

export default ItemForm;
