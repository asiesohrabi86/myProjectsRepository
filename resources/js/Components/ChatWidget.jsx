// resources/js/components/ChatWidget.jsx

import React, { useState, useEffect, useRef } from 'react';
import axios from 'axios';

const ChatIcon = () => ( <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg> );

const ChatWidget = ({ userId }) => {
    const [isOpen, setIsOpen] = useState(false);
    const [messages, setMessages] = useState([]);
    const [newMessage, setNewMessage] = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [isSending, setIsSending] = useState(false);
    const chatBoxRef = useRef(null);

    useEffect(() => {
        if (isOpen && userId) {
            setLoading(true);
            setError(null);
            axios.get(route('chat.fetchMessages', { user:userId }))
                .then(response => setMessages(response.data || []))
                .catch(err => {
                    console.error("Error fetching messages:", err);
                    setError("خطا در دریافت پیام‌ها.");
                })
                .finally(() => setLoading(false));
        }
    }, [isOpen, userId]);

    useEffect(() => {
        if (chatBoxRef.current) chatBoxRef.current.scrollTop = chatBoxRef.current.scrollHeight;
    }, [messages]);

    useEffect(() => {
        if (userId && window.Echo) {
            const channel = window.Echo.private(`chat.user.${userId}`);
            channel.listen('\\App\\Events\\MessageSent', (e) => {
                if (e.message && e.message.user) {
                    const receivedMessage = { 
                        id: e.message.id, text: e.message.message, is_sender: false, 
                        user: { name: e.message.user.name }
                    };
                    setMessages(prev => [...prev, receivedMessage]);
                }
            });
            return () => window.Echo.leaveChannel(`chat.user.${userId}`);
        }
    }, [userId]);

    const handleSendMessage = (e) => {
        e.preventDefault();
        if (!newMessage.trim() || isSending) return;
        setIsSending(true);
        setError(null);

        axios.post(route('chat.sendMessage'), { message: newMessage })
            .then(response => {
                const sentMessage = {
                    id: response.data.message.id, text: response.data.message.message,
                    is_sender: true, user: { name: 'شما' }
                };
                setMessages(prev => [...prev, sentMessage]);
                setNewMessage('');
            })
            .catch(err => {
                console.error("Error sending message:", err);
                setError("ارسال پیام با خطا مواجه شد.");
            })
            .finally(() => setIsSending(false));
    };

    return (
        <div style={styles.container}>
            <div style={{ ...styles.chatWindow, display: isOpen ? 'flex' : 'none' }}>
                <div style={styles.header}>
                    <h6>پشتیبانی آنلاین</h6>
                    <button onClick={() => setIsOpen(false)} style={styles.closeButton}>×</button>
                </div>
                <div style={styles.messageArea} ref={chatBoxRef}>
                    {loading && <p>در حال بارگذاری...</p>}
                    {messages.map((msg, index) => (
                        <div key={msg.id || index} style={{ ...styles.messageBubble, ...(msg.is_sender ? styles.senderBubble : styles.receiverBubble) }}>
                            <span style={styles.messageSender}>{msg.user.name}</span>
                            <p style={styles.messageText}>{msg.text}</p>
                        </div>
                    ))}
                </div>
                {error && <div style={styles.errorBox}>{error}</div>}
                <form onSubmit={handleSendMessage} style={styles.inputArea}>
                    <input type="text" value={newMessage} onChange={(e) => setNewMessage(e.target.value)} placeholder="پیام خود را بنویسید..." style={styles.input} disabled={isSending} />
                    <button type="submit" style={styles.sendButton} disabled={isSending}>
                        {isSending ? '...' : 'ارسال'}
                    </button>
                </form>
            </div>
            <button onClick={() => setIsOpen(!isOpen)} style={styles.floatingButton}><ChatIcon /></button>
        </div>
    );
};
const styles = {
    // ... (تمام استایل‌های قبلی)
    messageStatus: {
        fontSize: '10px',
        textAlign: 'left',
        opacity: 0.7,
    },
    retryButton: {
        background: 'none',
        border: 'none',
        color: '#ffc107',
        cursor: 'pointer',
        padding: 0,
        fontSize: '10px',
        textDecoration: 'underline',
    },
    errorBox: {
        textAlign: 'center',
        padding: '10px',
        backgroundColor: '#f8d7da',
        color: '#721c24',
        borderRadius: '5px',
    },
     container: {
        position: 'fixed',
        bottom: '20px',
        left: '20px', // در سمت چپ پایین
        zIndex: 1000,
        fontFamily: 'IranSans, sans-serif',
    },
    chatWindow: {
        width: '350px',
        height: '500px',
        backgroundColor: '#fff',
        borderRadius: '10px',
        boxShadow: '0 5px 20px rgba(0,0,0,0.15)',
        display: 'flex',
        flexDirection: 'column',
        marginBottom: '10px',
    },
    header: {
        backgroundColor: '#f5f5f5',
        padding: '10px 15px',
        borderBottom: '1px solid #e8ebf1',
        borderTopLeftRadius: '10px',
        borderTopRightRadius: '10px',
        display: 'flex',
        justifyContent: 'space-between',
        alignItems: 'center',
    },
    closeButton: {
        background: 'none',
        border: 'none',
        fontSize: '24px',
        cursor: 'pointer',
    },
    messageArea: {
        flex: 1,
        padding: '15px',
        overflowY: 'auto',
    },
    messageBubble: {
        padding: '8px 12px',
        borderRadius: '15px',
        marginBottom: '10px',
        maxWidth: '80%',
        wordWrap: 'break-word',
    },
    senderBubble: {
        backgroundColor: '#04a9f5', // رنگ اصلی قالب شما
        color: '#fff',
        alignSelf: 'flex-end',
        marginLeft: 'auto',
    },
    receiverBubble: {
        backgroundColor: '#e8ebf1',
        color: '#333',
        alignSelf: 'flex-start',
    },
    messageSender: {
        fontSize: '12px',
        fontWeight: 'bold',
        display: 'block',
        marginBottom: '4px',
    },
    messageText: {
        margin: 0,
        fontSize: '14px',
    },
    inputArea: {
        display: 'flex',
        padding: '10px',
        borderTop: '1px solid #e8ebf1',
    },
    input: {
        flex: 1,
        border: '1px solid #dbdbdb',
        borderRadius: '20px',
        padding: '8px 15px',
        fontSize: '14px',
    },
    sendButton: {
        backgroundColor: '#04a9f5',
        color: '#fff',
        border: 'none',
        borderRadius: '20px',
        padding: '8px 15px',
        marginRight: '10px',
        cursor: 'pointer',
        fontWeight: '600',
    },
    floatingButton: {
        backgroundColor: '#04a9f5',
        color: '#fff',
        width: '60px',
        height: '60px',
        borderRadius: '50%',
        border: 'none',
        boxShadow: '0 4px 10px rgba(0,0,0,0.2)',
        cursor: 'pointer',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        marginLeft: 'auto', // برای قرارگیری در سمت راست container
    }
};

export default ChatWidget;









