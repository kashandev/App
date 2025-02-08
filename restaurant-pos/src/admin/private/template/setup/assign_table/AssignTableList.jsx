import React, { useState } from "react";
import AssignTableFilterBox from "./AssignTableFilterBox";
import Table from "../../common/Table";

const AssignTableList = () => {
  const [filterBox, setFilterBox] = useState(false);

  const handleFilterBox = () => {
    setFilterBox(!filterBox);
  };
  const dataList = [
    {
      assing_table_id: "1",
      sort_order: "1",
      table_no: "Table-01",
      waiter : 'Azhar'
    },
    {
      assing_table_id: "2",
      sort_order: "2",
      table_no: "Table-02",
      waiter : 'Tahir'
    },
    {
      assing_table_id: "3",
      sort_order: "3",
      table_no: "Table-03",
      waiter : 'Nasir'
    },
    {
      assing_table_id: "4",
      sort_order: "4",
      table_no: "Table-04",
      waiter : 'Salman'
    },
    {
      assing_table_id: "5",
      sort_order: "5",
      table_no: "Table-05",
      waiter : 'Shahid'
    },
    {
      assing_table_id: "6",
      sort_order: "6",
      table_no: "Table-06",
      waiter : 'Tanveer'
    },
    {
      assing_table_id: "7",
      sort_order: "7",
      table_no: "Table-07",
      waiter : 'Sarfraz'
    },
    {
      assing_table_id: "8",
      sort_order: "8",
      table_no: "Table-08",
      waiter : 'Saleem'
    },
  ];
  return (
    <>
      <div className="position-relative">
        <div className=" d-flex align-items-center gap-3 ">
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
          {/* <button
            style={{ height: "40px", fontSize: ".95rem" }}
            class="btn text-light  btn-purple rounded-1 dropdown-toggle"
            type="button"
            onClick={handleFilterBox}
          >
            <i className="fa-light fa-filter"></i> Filters
          </button> */}

          <div className="search-box w-100">
            <i className="fa-regular fa-magnifying-glass"></i>
            <input
              type="text"
              className="form-control input-control rounded-1"
              placeholder="Search in waiter, table no or something..."
            />
          </div>
          
        </div>
        {/* <AssignTableFilterBox isShow={filterBox} /> */}
        <div className="mt-3  table-wrapper">
        <Table
            rows={dataList}
            cols={[
              { checkbox: true },
              "SN",
              "Waiter",
              "Table No",
            ]}
            dataKeys={["sort_order","waiter","table_no"]}
            checkboxValKey={`assing_table_id`}
            swipe={false}
          />
        </div>
      </div>
    </>
  );
};

export default AssignTableList;
