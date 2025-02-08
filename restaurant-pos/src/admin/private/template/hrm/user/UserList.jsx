import React, { useState } from 'react'
import Table from '../../common/Table';
import UserFilterBox from './UserFilterBox';

const UserList = () => {
    const [filterBox, setFilterBox] = useState(false);

    const handleFilterBox = () => {
      setFilterBox(!filterBox);
    };
    const userList = [
      {
        user_id: "1",
        sort_order: "1",
        user_name : 'Azhar',
        user_type : 'Administrator',
        email : 'azhar@gmail.com',
        status : 'Active'
      },
      {
        user_id: "2",
        sort_order: "2",
        user_name : 'Yasir',
        user_type : 'User',
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
                placeholder="Search in user type, name or something..."
              />
            </div>
          </div>
          <UserFilterBox isShow={filterBox} />
          <div className="mt-4  table-wrapper">
            <Table
              rows={userList}
              cols={[
                { checkbox: true },
                "SN",
                "User Name",
                "User Type",
                "Email",
                "Status"
              ]}
              dataKeys={["sort_order", "user_name", "user_type", "email", "status"]}
              checkboxValKey={`user_id`}
              swipe={false}
            />
          </div>
        </div>
      </>
    );
}

export default UserList