// resources/js/chat.js

// bootstrap.js را وارد می‌کنیم تا از Echo و Axios پیکربندی شده استفاده کنیم
import './bootstrap'; 

import React from 'react';
import { createRoot } from 'react-dom/client';
import ChatWidget from './components/ChatWidget'; // مسیر کامپوننت ویجت

const element = document.getElementById('chat-widget-container');
if (element) {
    const userId = element.getAttribute('data-user-id');
    const root = createRoot(element);
    root.render(<ChatWidget userId={userId} />);
}