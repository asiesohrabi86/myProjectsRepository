import React from 'react';

/**
 * یک کامپوننت اسکلتی جنریک برای ویجت‌های داشبورد.
 * از کلاس‌های placeholder بوت‌استرپ استفاده می‌کند.
 */
const WidgetSkeleton = ({ className = '' }) => {
  return (
    <div className={`card ${className}`} aria-hidden="true">
      <div className="card-body">
        <h5 className="card-title placeholder-glow">
          <span className="placeholder col-4"></span>
        </h5>
        
        <div className="mt-4 placeholder-glow">
          <span className="placeholder col-7" style={{ height: '35px' }}></span>
        </div>

        <div className="mt-3 placeholder-glow">
          <span className="placeholder col-5"></span>
        </div>

        <div className="mt-5 d-flex justify-content-around placeholder-glow">
          <span className="placeholder col-2 p-3"></span>
          <span className="placeholder col-2 p-3"></span>
          <span className="placeholder col-2 p-3"></span>
          <span className="placeholder col-2 p-3"></span>
        </div>
      </div>
    </div>
  );
};

export default WidgetSkeleton;