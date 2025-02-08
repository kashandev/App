import React, { useState } from "react";
import "../../css/common/table.css";

const Table = ({ cols = [], rows = [], dataKeys = [], checkboxValKey ,swipe=true}) => {
  const [swipedRows, setSwipedRows] = useState([]);

  let startX, startY, endX, endY;

  const handleSwipeRow = (index) => {
    const updatedSwipedRows = [...swipedRows];

    if (updatedSwipedRows.includes(index)) {
      updatedSwipedRows.splice(updatedSwipedRows.indexOf(index), 1);
    } else {
      updatedSwipedRows.length = 0;
      updatedSwipedRows.push(index);
    }
    setSwipedRows(updatedSwipedRows);
  };

  const handleTouchStart = (e) => {
    startX = e.touches[0].clientX;
    startY = e.touches[0].clientY;
  };

  const handleTouchEnd = (e, index) => {
    endX = e.changedTouches[0].clientX;
    endY = e.changedTouches[0].clientY;

    const deltaX = endX - startX;
    const deltaY = endY - startY;

    if (Math.abs(deltaX) > 150) {
      if (deltaX > 0) {
        handleSwipeRow(index);
      } else {
        handleSwipeRow(index);
      }
    }
  };
  return (
    <>
    <div className="table-responsive custom-scroll" style={{height:"50vh"}} >
      
    <table className="content-table table" >
      <thead>
        <tr>
          {cols.map((column, index) => {
            return (
              <>
                {column.checkbox == true ? (
                  <th scope="col" width={40} className="text-center">
                    <input type="checkbox" />
                  </th>
                ) : (
                  index != 0 && (
                    <th key={index} scope="col">
                      {column}
                    </th>
                  )
                )}
              </>
            );
          })}
        </tr>
      </thead>
      <tbody>
        {rows.map((row, i) => {
          const isSwiped = swipedRows.includes(i);

          return (
            <tr
            {...(swipe
              ? {
                  onTouchStart: (e) => handleTouchStart(e, i),
                  onTouchEnd: (e) => handleTouchEnd(e, i),
                }
              : { onClick: () => handleSwipeRow(i) })}
              key={i}
              className={`table-row ${isSwiped ? "swipe" : ""}`}
            >
              {cols[0].checkbox && (
                <td scope="col" width={40} className="text-center">
                  <input value={row[checkboxValKey]} type="checkbox" />
                </td>
              )}

              {dataKeys.map((key, index) => {
                return (
                  <td key={index} scope="col">
                    {row[key]}
                  </td>
                );
              })}

              <td className="row-actions-wrapper p-0 border">
                <div className="row-actions">
                  <button
                    data-value={row[checkboxValKey]}
                    className="btn btn-sm text-danger"
                  >
                    <i className="fa-solid fa-trash-can"></i>
                  </button>
                  <button
                    data-value={row[checkboxValKey]}
                    className="btn btn-sm text-success"
                  >
                    <i className="fa-solid fa-pen-nib"></i>
                  </button>
                </div>
              </td>
            </tr>
            
            );
          })}
      </tbody>
     
        </table>
        
   </div>
        
    <div className="tfoot">
     <div className="align-middle">
         <div className="d-flex align-items-center justify-content-between">
           <p className="mb-0 text-dark">
             1 to 8 results showing out of 10 results
           </p>
           <div className="table-footer">
             <button className="btn prev-btn btn-sm">
               <i className="fa-solid fa-arrow-left me-2"></i> Previous
             </button>
             <ul>
               <li>
                 <a href="">1</a>
               </li>
               <li>
                 <a href="">2</a>
               </li>
               <li>
                 <a href="" className="active">
                   3
                 </a>
               </li>
               <li>
                 <a href="">...</a>
               </li>
               <li>
                 <a href="">6</a>
               </li>
             </ul>
             <button className="btn next-btn btn-sm">
               Next <i className="fa-solid fa-arrow-right ms-2"></i>
             </button>
           </div>
         </div>
     </div>
   </div>
          </>
  );
};

export default Table;
