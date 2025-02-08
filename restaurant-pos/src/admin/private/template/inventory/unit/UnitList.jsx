import React, { useState } from "react";
import UnitFilterBox from "./UnitFilterBox";
import Table from "../../common/Table";

const UnitList = () => {
  const [filterBox, setFilterBox] = useState(false);

  const handleFilterBox = () => {
    setFilterBox(!filterBox);
  };
  const UnitList = [
    {
      unit_id: "1",
      sort_order: "1",
      unit : 'Pcs',
    },

    {
      unit_id: "2",
      sort_order: "2",
      unit : 'Kg',
    },

    {
      category_id: "3",
      sort_order: "3",
      unit : 'Ltr',
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
              placeholder="Search unit"
            />
          </div>
        </div>
        <UnitFilterBox isShow={filterBox} />
        <div className="mt-4  table-wrapper">
          <Table
            rows={UnitList}
            cols={[
              { checkbox: true },
              "SN",
              "Unit",
  
            ]}
            dataKeys={["sort_order", "unit"]}
            checkboxValKey={`unit_id`}
          />
        </div>
      </div>
    </>
  );
};

export default UnitList;
