import React, { useState } from "react";
import "../../../css/common/form.css";
import { Tab, TabList, TabPanel, Tabs } from "react-tabs";
import CategoryList from "./CategoryList";
import SubCategoryList from "./SubCategoryList";
import CategoryForm from "./CategoryForm";
const CategoryContainer = () => {
  const [activeTabIndex, setActiveTabIndex] = useState(0);

  return (
    <div className="product-wrapper">
      <div className="product-container">
        <div  > 
          <h2 className="container-heading">Category & Sub Category</h2>
          {/* <p className="container-paragraph">
          Explore our diverse menu categories, each offering a delectable selection to satisfy your cravings.
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
              <Tab onClick={() => setActiveTabIndex([0,180,0])}>
                <div style={{width:"180px"}} className="tab">Category List</div>
              </Tab>
              <Tab onClick={() => setActiveTabIndex([1,200,180])}>
                <div style={{width:"200px"}} className="tab">
                  Sub Category List
                </div>
              </Tab>
              <Tab onClick={() => setActiveTabIndex([2,150,190])}>
                <div className="tab">
                  Add Categories
                </div>
              </Tab>
              <div
                className="bottom-line"
                style={{
                  width: `${activeTabIndex[1]+"px"}`,
                  transform: `translateX(${activeTabIndex[0] * (activeTabIndex[2] + 30)}px)`,
                }}
              />
            </TabList>

            <TabPanel>
             <CategoryList/>
            </TabPanel>
            <TabPanel>
             <SubCategoryList/>
            </TabPanel>
            <TabPanel>
              <CategoryForm/>
            </TabPanel>
          </Tabs>
        </div>
      </div>
    </div>
  );
};

export default CategoryContainer;
