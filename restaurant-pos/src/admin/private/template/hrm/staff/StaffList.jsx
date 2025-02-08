import React, { useState } from 'react'
import Table from '../../common/Table';
import StaffFilterBox from './StaffFilterBox';

const StaffList = () => {
    const [filterBox, setFilterBox] = useState(false);

    const handleFilterBox = () => {
      setFilterBox(!filterBox);
    };
    const StaffList = [
      {
        staff_id: "1",
        sort_order: "1",
        staff_name : 'Azhar',
        staff_type : 'Manager',
        email : 'azhar@gmail.com',
        status : 'Active'
      },
      {
        staff_id: "2",
        sort_order: "2",
        staff_name : 'Yasir',
        staff_type : 'Waiter',
        email : 'yasir@gmail.com',
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
                placeholder="Search in staff type, name or something..."
              />
            </div>
          </div>
          <StaffFilterBox isShow={filterBox} />
          <div className="mt-4  table-wrapper">
            <Table
              rows={StaffList}
              cols={[
                { checkbox: true },
                "SN",
                "Staff Name",
                "Staff Type",
                "Email",
                "Status"
              ]}
              dataKeys={["sort_order", "staff_name", "staff_type", "email", "status"]}
              checkboxValKey={`staff_id`}
              swipe={false}
            />
          </div>
        </div>
      </>
    );
}

export default StaffList