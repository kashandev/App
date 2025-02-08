import React, { useState } from "react";
import TableFilterBox from "./TableFilterBox";
import Table from "../../common/Table";

const TableList = () => {
  const [filterBox, setFilterBox] = useState(false);

  const handleFilterBox = () => {
    setFilterBox(!filterBox);
  };
  const dataList = [
    {
      table_id: "1",
      sort_order: "1",
      table_no: "Table-01",
      no_of_charis: "2",
      waiter : 'Azhar'
    },
    {
      table_id: "2",
      sort_order: "2",
      table_no: "Table-02",
      no_of_charis: "3",
      waiter : 'Tahir'
    },
    {
      table_id: "3",
      sort_order: "3",
      table_no: "Table-03",
      no_of_charis: "4",
      waiter : 'Nasir'
    },
    {
      table_id: "4",
      sort_order: "4",
      table_no: "Table-04",
      no_of_charis: "5",
      waiter : 'Salman'
    },
    {
      table_id: "5",
      sort_order: "5",
      table_no: "Table-05",
      no_of_charis: "6",
      waiter : 'Shahid'
    },
    {
      table_id: "6",
      sort_order: "6",
      table_no: "Table-06",
      no_of_charis: "7",
      waiter : 'Tanveer'
    },
    {
      table_id: "7",
      sort_order: "7",
      table_no: "Table-07",
      no_of_charis: "8",
      waiter : 'Sarfraz'
    },
    {
      table_id: "8",
      sort_order: "8",
      table_no: "Table-08",
      no_of_charis: "9",
      waiter : 'Saleem'
    }
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
              placeholder="Search in table no, waiter or something..."
            />
          </div>
          
        </div>
        {/* <TableFilterBox isShow={filterBox} /> */}
        <div className="mt-3  Table-wrapper">
          <Table
            rows={dataList}
            cols={[
              { checkbox: true },
              "SN",
              "Table No",
              "No of Chairs",
              "Waiter",
            ]}
            dataKeys={["sort_order","table_no", "no_of_charis", "waiter"]}
            checkboxValKey={`table_id`}
            swipe={false}
          />
        </div>
      </div>
    </>
  );
};

export default TableList;
