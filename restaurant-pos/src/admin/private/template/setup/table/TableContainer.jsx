import React, { useState } from "react";
import "../../../css/common/form.css";
import { Tab, TabList, TabPanel, Tabs } from "react-tabs";
import TableForm from "./TableForm";
const TableContainer = () => {
  const [activeTabIndex, setActiveTabIndex] = useState(0);

  return (
    <div className="product-wrapper">
      <div className="product-container">
        <div className=""> 
          <h2 className="container-heading">Sitting Tables</h2>
          {/* <p className="container-paragraph">
          Assigning a waiter to tables is simple: Use our intuitive dashboard to select the tables, choose the waiter from your staff, and confirm the assignment.
          </p> */}
        </div>
        <div>
          <Tabs style={{ color: "#8C8C8E" }} selectedTabClassName="active-tab">
            <TabList
              style={{
                display: "flex",
                gap: "30px",
                listStyle: "none",
                padding: "0",
                position: "relative",
                borderBottom: "1px solid #eee",
              }}
            >
              {/* <Tab onClick={() => setActiveTabIndex(0)}>
                <div className="tab">List Overview</div>
              </Tab> */}
              <Tab onClick={() => setActiveTabIndex(0)}>
                <div className="tab">
                  Manage Tables
                </div>
              </Tab>
              <div
                className="bottom-line"
                style={{
                  width: `${"150px"}`,
                  transform: `translateX(${activeTabIndex * (150 + 30)}px)`,
                }}
              />
            </TabList>

            {/* <TabPanel>
             <ProductList/>
            </TabPanel> */}
            <TabPanel>
              <TableForm />
            </TabPanel>
          </Tabs>
        </div>
      </div>
    </div>
  );
};

export default TableContainer;
