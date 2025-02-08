import React, { useState } from "react";
import CategoryFilterBox from "./CategoryFilterBox";
import Table from "../../common/Table";

const CategoryList = () => {
  const [filterBox, setFilterBox] = useState(false);
 
  const handleFilterBox = () => {
    setFilterBox(!filterBox);
  };
  const CategoryList = [
    {
      category_id: "1",
      sort_order: "1",
      category_name : 'Pizza',
      status : 'Active'
    },
    {
      category_id: "2",
      sort_order: "2",
      category_name : 'Burger',
      status : 'Active'
    },
    {
      category_id: "3",
      sort_order: "3",
      category_name : 'Sandwich',
      status : 'Active'
    },
    {
      category_id: "4",
      sort_order: "4",
      category_name : 'Ice Cream',
      status : 'Active'
    },
    {
      category_id: "5",
      sort_order: "5",
      category_name : 'Cold Drink',
      status : 'Active'
    },
    {
      category_id: "6",
      sort_order: "6",
      category_name : 'Chinese',
      status : 'Active'
    },
    {
      category_id: "7",
      sort_order: "7",
      category_name : 'Italian',
      status : 'Active'
    },
    {
      category_id: "8",
      sort_order: "8",
      category_name : 'Sea Food',
      status : 'Active'
    }
  ]; 
  
  return (
    <>
      <div className="position-relative">
        <div className=" d-flex align-items-center gap-3 pt-3">
          <div class=" dropdown">
            <button
              style={{ height: "40px", fontSize: ".95rem" }}
              class="btn  text-light btn-danger rounded-1 dropdown-toggle"
              type="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Bulk Actions
            </button>
            <ul class="dropdown-menu mt-2">
              <li>
                <a class="dropdown-item" href="#">
                  Delete
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  Disable
                </a>
              </li>
            </ul>
          </div>
          <button
            style={{ height: "40px", fontSize: ".95rem" }}
            class="btn text-light  btn-purple rounded-1 dropdown-toggle"
            type="button"
            onClick={handleFilterBox}
          >
            <i className="fa-light fa-filter"></i> Filters
          </button>

          <div className="search-box w-100">
            <i className="fa-regular fa-magnifying-glass"></i>
            <input
              type="text"
              className="form-control input-control rounded-1"
              placeholder="Search in category or something..."
            />
          </div>
        </div>
        <CategoryFilterBox isShow={filterBox} />
        <div className="mt-4  table-wrapper">
          <Table
            rows={CategoryList}
            cols={[
              { checkbox: true },
              "SN",
              "Category",
              "Status"
            ]}
            dataKeys={["sort_order", "category_name", "status"]}
            checkboxValKey={`category_id`}
          />
        </div>
      </div>
    </>
  );
};
export default CategoryList;
