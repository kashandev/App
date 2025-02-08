import React from 'react'

const CheckoutList = () => {
  return (
    // <div className=' px-2 bg-light vh-100'>
      <div className="checkout-form border vh-100">
        <div style={{ height: "calc(100vh - 240px)" }} className="py-2 bg-white">
          <div
            style={{ height: "80px" }}
            className="d-flex justify-content-between px-2 align-items-center"
        >
          <div className="row m-0">
            <div className="ps-0 col-6">
            <label htmlFor="" className="input-label mb-0">
              Select Table
            </label>
            <input type="text" className="form-control" placeholder="..." />
          </div>
          <div className="px-0 col-6">
            <label htmlFor="" className="input-label mb-0">
              Select Waiter
            </label>
            <input type="text" className="form-control" placeholder="..." />
          </div>
          
        </div>
            {/* <h5 className="mb-0 " style={{ fontWeight: "600" }}>
              Current Order
            </h5> */}
            {/* <button
            style={{ fontSize: ".9rem" }}
            className="btn btn-primary btn-sm   rounded-1 "
          >
            View Orders
          </button> */}
          </div>
          <ul
            style={{ height: "calc(100% - 80px)" }}
            className="item-list pb-3 custom-scroll"
          >
            <li>
              <div className="item-image">
                {/* <div className="action-icon">
                  <i className="fa-solid fa-xmark"></i>
                </div> */}
              </div>
              <div className="item-content">
                <div className="item-title">Item Title here...</div>
                <div className="pr-qty-container">
                  <div className="price">Rs 1200</div>
                  <div className="qty-selector">
                    <button className="bg-danger">
                      <i className="fa-solid fa-minus"></i>
                    </button>
                    <div className="qty-input">1</div>
                    <button>
                      <i className="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div className="item-image">
                {/* <div className="action-icon">
                  <i className="fa-solid fa-xmark"></i>
                </div> */}
              </div>
              <div className="item-content">
                <div className="item-title">Item Title here...</div>
                <div className="pr-qty-container">
                  <div className="price">Rs 1200</div>
                  <div className="qty-selector">
                    <button className="bg-danger">
                      <i className="fa-solid fa-minus"></i>
                    </button>
                    <div className="qty-input">1</div>
                    <button>
                      <i className="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div className="item-image">
                {/* <div className="action-icon">
                  <i className="fa-solid fa-xmark"></i>
                </div> */}
              </div>
              <div className="item-content">
                <div className="item-title">Item Title here...</div>
                <div className="pr-qty-container">
                  <div className="price">Rs 1200</div>
                  <div className="qty-selector">
                    <button className="bg-danger" >
                      <i className="fa-solid fa-minus"></i>
                    </button>
                    <div className="qty-input">1</div>
                    <button>
                      <i className="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div className="item-image">
                {/* <div className="action-icon">
                  <i className="fa-solid fa-xmark"></i>
                </div> */}
              </div>
              <div className="item-content">
                <div className="item-title">Item Title here...</div>
                <div className="pr-qty-container">
                  <div className="price">Rs 1200</div>
                  <div className="qty-selector">
                    <button className="bg-danger">
                      <i className="fa-solid fa-minus"></i>
                    </button>
                    <div className="qty-input">1</div>
                    <button>
                      <i className="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div className="item-image">
                {/* <div className="action-icon">
                  <i className="fa-solid fa-xmark"></i>
                </div> */}
              </div>
              <div className="item-content">
                <div className="item-title">Item Title here...</div>
                <div className="pr-qty-container">
                  <div className="price">Rs 1200</div>
                  <div className="qty-selector">
                    <button className="bg-danger">
                      <i className="fa-solid fa-minus"></i>
                    </button>
                    <div className="qty-input">1</div>
                    <button>
                      <i className="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div className="item-image">
                {/* <div className="action-icon">
                  <i className="fa-solid fa-xmark"></i>
                </div> */}
              </div>
              <div className="item-content">
                <div className="item-title">Item Title here...</div>
                <div className="pr-qty-container">
                  <div className="price">Rs 1200</div>
                  <div className="qty-selector">
                    <button className="bg-danger">
                      <i className="fa-solid fa-minus"></i>
                    </button>
                    <div className="qty-input">1</div>
                    <button>
                      <i className="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div className="item-image">
                {/* <div className="action-icon">
                  <i className="fa-solid fa-xmark"></i>
                </div> */}
              </div>
              <div className="item-content">
                <div className="item-title">Item Title here...</div>
                <div className="pr-qty-container">
                  <div className="price">Rs 1200</div>
                  <div className="qty-selector">
                    <button className="bg-danger">
                      <i className="fa-solid fa-minus"></i>
                    </button>
                    <div className="qty-input">1</div>
                    <button>
                      <i className="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>
            <li>
              <div className="item-image">
                {/* <div className="action-icon">
                  <i className="fa-solid fa-xmark"></i>
                </div> */}
              </div>
              <div className="item-content">
                <div className="item-title">Item Title here...</div>
                <div className="pr-qty-container">
                  <div className="price">Rs 1200</div>
                  <div className="qty-selector">
                    <button className="bg-danger">
                      <i className="fa-solid fa-minus"></i>
                    </button>
                    <div className="qty-input">1</div>
                    <button>
                      <i className="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>

            <li>
              <div className="item-image">
                {/* <div className="action-icon">
                  <i className="fa-solid fa-xmark"></i>
                </div> */}
              </div>
              <div className="item-content">
                <div className="item-title">Item Title here...</div>
                <div className="pr-qty-container">
                  <div className="price">Rs 1200</div>
                  <div className="qty-selector">
                    <button className="bg-danger">
                      <i className="fa-solid fa-minus"></i>
                    </button>
                    <div className="qty-input">1</div>
                    <button>
                      <i className="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>

        <div style={{ height: "240px" }}>
          <div className="total-calc ">
          <div className="extra-values">
            {/* <div className="d-flex gap-3"> */}

              <div>
                <span>Total Amount</span>
                <span>37.00</span>
              </div>
              
              <div>
                <span>tax %</span>
                <input type="number" className='border rounded-2 btn text-end pe-2' style={{width:"150px",height:"30px"}} />
              </div>
            {/* </div> */}
            {/* <div className="d-flex gap-3"> */}

              <div>
                <span>Discount %</span>
                <input type="number" className='border rounded-2 btn text-end pe-2' style={{width:"150px",height:"30px"}} />
              </div>
              
              {/* <div className="ex-value-box">
                <span>Net Amount</span>
                <span>37.00</span>
              </div> */}
            {/* </div> */}
              {/* <div className="ex-value-box">
                <span>Discount Sales</span>
                <span>Rs -50.00</span>
              </div>
              <div className="ex-value-box">
                <span>Total Sales Tax</span>
                <span>Rs 87.00</span>
              </div> */}

              {/* <span
                className=" d-block w-100 line-break"
                style={{ border: "1px dashed #8C8C8E" }}
              ></span> */}
              <div className="total-value">
                <span className="fs-6 text-dark">Grand Total</span>
                <span className="fs-6">Rs 137.00</span>
              </div>
            </div>
          </div>
          <div className="px-3 ">
            <button
              className="btn  btn-purple w-100 "
              style={{ fontSize: ".9rem", height: "40px" }}
            >
              Generate Receipt
            </button>
          </div>
        </div>
      </div>
    // </div>
    )
}

export default CheckoutList