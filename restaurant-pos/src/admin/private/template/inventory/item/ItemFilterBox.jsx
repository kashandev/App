import React from "react";

const ItemFilterBox = ({isShow}) => {
  return (
    <div className={`filter-box ${isShow ? "active" : "hide"} `}>
      <div className="filter-grid-box">
        <div className="filter-grid-item">
          <h6>Status</h6>
          <ul>
            <li>
              <input type="checkbox" />
              <span>Active</span>
            </li>
            <li>
              <input type="checkbox" />
              <span>In Active</span>
            </li>
          </ul>
        </div>
        <div className="filter-grid-item">
          <div className="mb-3">
            <h6>Category ID</h6>
            <input
              type="text"
              className="form-control rounded-1 shadow-none placeholder:small"
              placeholder="..."
            />
          </div>
          <div className="mb-3">
            <h6>Product Name</h6>
            <input
              type="text"
              className="form-control rounded-1 shadow-none placeholder:small"
              placeholder="..."
            />
          </div>
        </div>
        <div className="filter-grid-item">
          <div className="mb-3">
            <h6>Category</h6>
            <input
              type="text"
              className="form-control rounded-1 shadow-none placeholder:small"
              placeholder="..."
            />
          </div>
          <div className="mb-3">
            <h6>Sub Category</h6>
            <input
              type="text"
              className="form-control rounded-1 shadow-none placeholder:small"
              placeholder="..."
            />
          </div>
        </div>
        <div className="filter-grid-item">
          <div className="d-flex flex-column justify-content-between h-100">
            <div className="">
              <h6>Items Between...</h6>
              <div className="d-flex gap-2 align-items-center">
                <input
                  type="date"
                  className="form-control rounded-1 shadow-none placeholder:small"
                  placeholder="..."
                />
                <i className="fa-regular text-dark fa-arrows-left-right"></i>
                <input
                  type="date"
                  className="form-control rounded-1 shadow-none placeholder:small"
                  placeholder="..."
                />
              </div>
            </div>
            <div className="mb-3 d-flex gap-2 justify-content-end">
              <button className="btn rounded-1">Reset</button>
              <button
                style={{ fontSize: ".95rem" }}
                className="btn bg-white border rounded-1"
              >
                <i className="fa-light fa-filter-circle-xmark"></i> Cancel
              </button>
              <button
                style={{ fontSize: ".95rem" }}
                className="btn btn-purple border-0 rounded-1 "
              >
                <i className="fa-light fa-filter"></i> Apply Filters
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ItemFilterBox;
