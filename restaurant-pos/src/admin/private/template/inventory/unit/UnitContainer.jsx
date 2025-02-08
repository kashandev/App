import React, { useState } from "react";
import "../../../css/common/form.css";
import { Tab, TabList, TabPanel, Tabs } from "react-tabs";
import UnitList from "./UnitList";
import UnitForm from "./UnitForm";
const UnitContainer = () => {
  const [activeTabIndex, setActiveTabIndex] = useState(0);

  return (
    <div className="product-wrapper">
      <div className="product-container">
        <div  > 
          <h2 className="container-heading">Unit</h2>
          {/* <p className="container-paragraph">
            Managing restaurant items involves overseeing inventory, pricing,
            and menu optimization to ensure a successful dining experience for
            customers while maximizing profitability
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
              <Tab onClick={() => setActiveTabIndex(0)}>
                <div className="tab">Unit List</div>
              </Tab>
              <Tab onClick={() => setActiveTabIndex(1)}>
                <div className="tab">
                  Add New Unit
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

            <TabPanel>
             <UnitList/>
            </TabPanel>
            <TabPanel>
              <UnitForm />
            </TabPanel>
          </Tabs>
        </div>
      </div>
    </div>
  );
};

export default UnitContainer;
