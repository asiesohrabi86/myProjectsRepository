import React, { useState } from 'react';

const themes = [
  { id: 'sidebar-dark-theme', label: 'پیش فرض', className: 'sidebar-dark' },
  { id: 'sidebar-light-theme', label: 'روشن', className: 'sidebar-light' },
  { id: 'sidebar-color-theme', label: 'رنگارنگ', className: 'sidebar-color' },
];

const ThemeSettings = () => {
  const [open, setOpen] = useState(false);
  const [selected, setSelected] = useState('sidebar-dark-theme');

  const handleThemeChange = (id, className) => {
    setSelected(id);
    document.body.classList.remove('sidebar-dark', 'sidebar-light', 'sidebar-color');
    document.body.classList.add(className);
  };

  return (
    <div className="theme-setting-wrapper">
      <div id="settings-trigger" className="settings-trigger" onClick={() => setOpen(true)}>
        <i className=" fa fa-cog font-17"></i>
      </div>
      
      <div id="theme-settings" className={`settings-panel${open ? ' open' : ''}`}>
        <i className="settings-close zmdi zmdi-close font-18 font-weight-bold" onClick={() => setOpen(false)}></i>
        <p className="settings-heading font-18">رنگ منوی جانبی:</p>
        {themes.map(t => (
          <div key={t.id} className={`sidebar-bg-options${selected===t.id?' selected':''}`} id={t.id} onClick={()=>handleThemeChange(t.id, t.className)}>
            <span className="font-14 font-weight-bold">{t.label}</span>
          </div>
        ))}
      </div>
      
    </div>
  );
};

export default ThemeSettings; 