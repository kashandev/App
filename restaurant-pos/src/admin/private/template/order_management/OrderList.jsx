import React, { useState } from "react";
import ProductFilterBox from "../inventory/category/CategoryFilterBox";
import Table from "../common/Table";

const OrderList = () => {
  const [filterBox, setFilterBox] = useState(false);

  const handleFilterBox = () => {
    setFilterBox(!filterBox);
  };
  const dataList = [
    {
      order_id: "1",
      order_no: "0001",
      order_date: "11-05-2023",
      waiter: "Azhar",
      table_no: "Table-01",
      item: "1 - chicken fatija-pizza-with-extra-cheese",
      status: "Pending",
    },
    {
      order_id: "2",
      order_no: "0002",
      order_date: "11-05-2023",
      waiter: "Tahir",
      table_no: "Table-02",
      item: "1 - chicken-cheese-burger",
      status: "Pending",
    },
    {
      order_id: "3",
      order_no: "0003",
      order_date: "11-05-2023",
      waiter: "Nasir",
      table_no: "Table-03",
      item: "2 - beef-burger",
      status: "Pending",
    },
    {
      order_id: "4",
      order_no: "0004",
      order_date: "11-05-2023",
      waiter: "Salman",
      table_no: "Table-04",
      item: "1 - club-sandwich",
      status: "Pending",
    },
    {
      order_id: "5",
      order_no: "0005",
      order_date: "11-05-2023",
      waiter: "Shahid",
      table_no: "Table-05",
      item: "2 - club-sandwich",
      status: "Pending",
    },
    {
      order_id: "6",
      order_no: "0006",
      order_date: "11-05-2023",
      waiter: "Tanveer",
      table_no: "Table-06",
      item: "1 - chicken fatija-pizza-with-extra-cheese & 2 - beef-burger",
      status: "Pending",
    },
    {
      order_id: "7",
      order_no: "0007",
      order_date: "11-05-2023",
      waiter: "Sarfraz",
      table_no: "Table-07",
      item: "1 - chicken fatija-pizza-with-extra-cheez & 2 - beef-burger",
      status: "Pending",
    },
    {
      order_id: "8",
      order_no: "0008",
      order_date: "11-05-2023",
      waiter: "Saleem",
      table_no: "Table-08",
      item: "1 - chicken fatija-pizza-with-extra-cheez",
      status: "Pending",
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
              placeholder="Search in order no, items or something..."
            />
          </div>
          
        </div>
        <ProductFilterBox isShow={filterBox} />
        <div className="mt-4  table-wrapper">
          <Table
            rows={dataList}
            cols={[
              { checkbox: true },
              "Order No",
              "Order Date",
              "Waiter",
              "Table No",
              "Item",
              "Status",
            ]}
            dataKeys={["order_no", "order_date", "waiter", "table_no", "item", "status"]}
            checkboxValKey={`order_id`}
          />
        </div>
      </div>
    </>
  );
};

export default OrderList;
