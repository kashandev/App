import React, { useState } from "react";
import ItemFilterBox from "./ItemFilterBox";
import Table from "../../common/Table";

const ItemList = () => {
  const [filterBox, setFilterBox] = useState(false);

  const handleFilterBox = () => {
    setFilterBox(!filterBox);
  };
  const ItemList = [
    {

      item_id: "1",
      category_id: "1",
      sub_category_id: "1",
      sort_order: "1",
      category_name : 'Pizza',
      sub_category_name : ' Fatija Pizza',
      item_name : 'Chicken Fajita Pizza',
      status : 'Active'
    },
    
  ]; 

  return (
    <>
      <div className="position-relative">
        <div className=" d-flex align-items-center gap-3 pt-3">
          <div class=" dropdown">
            <button
              style={{ height: "40px", fontSize: ".95rem" }}
              class="btn   btn-danger rounded-1 dropdown-toggle"
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
              placeholder="Search in item, category or something..."
            />
          </div>
          
        </div>
        <ItemFilterBox isShow={filterBox} />
        <div className="mt-4  table-wrapper">
          <Table
            rows={ItemList}
            cols={[
              { checkbox: true },
              "SN",
              "Category",
              "Sub Category",
              "Name",
              "Status",
            ]}
            dataKeys={["sort_order", "category_name", "sub_category_name", "item_name","status"]}
            checkboxValKey={`item_id`}
          />
        </div>
      </div>
    </>
  );
};

export default ItemList;
