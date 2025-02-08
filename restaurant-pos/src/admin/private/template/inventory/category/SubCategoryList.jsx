import React, { useState } from "react";
import SubCategoryFilterBox from "./SubCategoryFilterBox";
import Table from "../../common/Table";

const SubCategoryList = () => {
  const [filterBox, setFilterBox] = useState(false);
 
  const handleFilterBox = () => {
    setFilterBox(!filterBox);
  };
  const SubCategoryList = [
    {
      sub_category_id: "1",
      category_id: "1",
      sort_order: "1",
      category_name : 'Pizza',
      sub_category_name : ' Fajita Pizza',
      status : 'Active'
    },
    {
      sub_category_id: "2",
      category_id: "2",
      sort_order: "2",
      category_name : 'Burger',
      sub_category_name : 'Chicken Cheese Zinger',
      status : 'Active'
    },
    {
      sub_category_id: "3",
      category_id: "3",
      sort_order: "3",
      category_name : 'Sandwich',
      sub_category_name : 'Chicken Sandwich',
      status : 'Active'
    },
    {
      sub_category_id: "4",
      category_id: "4",
      sort_order: "4",
      category_name : 'Ice Cream',
      sub_category_name : 'Pista Kulfa',
      status : 'Active'
    },
    {
      sub_category_id: "5",
      category_id: "5",
      sort_order: "5",
      category_name : 'Beverages',
      sub_category_name : 'Cold Drink',
      status : 'Active'
    },
    {
      sub_category_id: "6",
      category_id: "6",
      sort_order: "6",
      category_name : 'Chinese',
      sub_category_name : 'Chowmein',
      status : 'Active'
    },
    {
      sub_category_id: "7",
      category_id: "7",
      sort_order: "7",
      category_name : 'Italian',
      sub_category_name : 'Pasta',
      status : 'Active'
    },
    {
      sub_category_id: "8",
      category_id: "8",
      sort_order: "8",
      category_name : 'Sea Food',
      sub_category_name : 'Grilled Fish',
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
              placeholder="Search in sub category or something..."
            />
          </div>
        </div>
        <SubCategoryFilterBox isShow={filterBox} />
        <div className="mt-4  table-wrapper">
          <Table
            rows={SubCategoryList}
            cols={[
              { checkbox: true },
              "SN",
              "Category",
              "Sub Category",
              "Status"
            ]}
            dataKeys={["sort_order", "category_name","sub_category_name","status"]}
            checkboxValKey={`sub_category_id`}
          />
        </div>
      </div>
    </>
  );
};
export default SubCategoryList;
