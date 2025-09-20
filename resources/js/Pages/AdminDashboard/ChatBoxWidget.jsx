import React, { useState, useEffect, useRef } from 'react';
import { usePage, router } from '@inertiajs/react';
import axios from 'axios';

// کامپوننت آیتم مکالمه (بدون تغییر)
const ConversationItem = ({ conversation, onClick, isActive }) => (
    <div
        onClick={onClick}
        style={{ 
            display: 'flex', alignItems: 'center', padding: '10px', cursor: 'pointer',
            backgroundColor: isActive ? '#f1f3fa' : (conversation.unread_count > 0 ? '#e6fffa' : 'transparent'),
            borderBottom: '1px solid #e8ebf1',
            position: 'relative',
        }}
    >
        <img src={conversation.user.avatar} alt={conversation.user.name} style={{ width: 40, height: 40, borderRadius: '50%', marginLeft: '10px' }}/>
        <div style={{ overflow: 'hidden', flex: 1 }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <h6 style={{ margin: 0, fontWeight: conversation.unread_count > 0 ? '900' : 'bold', fontSize: '14px' }}>
                    {conversation.user.name}
                </h6>
                <span style={{ fontSize: '11px', color: '#98a6ad' }}>{conversation.last_message_time}</span>
            </div>
            <p style={{ margin: 0, fontSize: '12px', color: '#6c757d', whiteSpace: 'nowrap', textOverflow: 'ellipsis', overflow: 'hidden' }}>
                {conversation.last_message}
            </p>
        </div>
        {conversation.unread_count > 0 && (
            <span style={{
                position: 'absolute', left: '10px', top: '50%', transform: 'translateY(-50%)',
                backgroundColor: '#00d97e', color: 'white', borderRadius: '50%',
                width: '22px', height: '22px', display: 'flex', alignItems: 'center',
                justifyContent: 'center', fontSize: '11px', fontWeight: 'bold'
            }}>
                {conversation.unread_count}
            </span>
        )}
    </div>
);


const ChatBoxWidget = () => {
    const { props } = usePage();
    const conversations = props.chatData || [];
    
    // **شروع اصلاحیه اصلی: یکپارچه‌سازی State**
    // ما فقط به ID مکالمه فعال نیاز داریم. خود آبجکت را از `conversations` پیدا می‌کنیم.
    const [activeConversationId, setActiveConversationId] = useState(null);
    const [newMessage, setNewMessage] = useState('');
    const [isSending, setIsSending] = useState(false);
    const [searchTerm, setSearchTerm] = useState('');
    const chatBoxRef = useRef(null);

    // آبجکت مکالمه فعال را بر اساس ID پیدا می‌کنیم. این روش همیشه آپدیت است.
    const activeConversation = conversations.find(c => c.user.id === activeConversationId);
    // **پایان اصلاحیه اصلی**
    
    useEffect(() => {
        if (chatBoxRef.current) chatBoxRef.current.scrollTop = chatBoxRef.current.scrollHeight;
    }, [activeConversation?.messages?.length]);

    useEffect(() => {
        if (window.Echo) {
            const channel = window.Echo.private('admin-chat');
            const handleNewMessage = (e) => {
                const receivedMessage = e.formattedMessage;
                // اگر ادمین در حال مشاهده مکالمه مربوطه است، آن را "خوانده شده" علامت بزن
                if (activeConversationId && receivedMessage.user.id === activeConversationId) {
                    axios.post(route('dashboard.chat.markAsRead', { user: receivedMessage.user.id }));
                }
                router.reload({ only: ['chatData'], preserveState: true, preserveScroll: true });
            };
            channel.listen('\\App\\Events\\MessageSentToAdmin', handleNewMessage);
            return () => {
                channel.stopListening('\\App\\Events\\MessageSentToAdmin', handleNewMessage);
            };
        }
    }, [activeConversationId]); // به ID فعال وابسته است

    const handleConversationClick = (conversation) => {
        setActiveConversationId(conversation.user.id);
        if (conversation.unread_count > 0) {
            axios.post(route('dashboard.chat.markAsRead', { user: conversation.user.id }));
        }
    };

    const handleBackClick = () => {
        setActiveConversationId(null);
        router.reload({ only: ['chatData'], preserveState: true, preserveScroll: true });
    };

    const submit = (e) => {
        e.preventDefault();
        if (!activeConversationId || !newMessage.trim() || isSending) return;
        setIsSending(true);
        axios.post(route('dashboard.chat.send'), {
            message: newMessage,
            recipient_id: activeConversationId
        })
        .then(() => {
            setNewMessage('');
            router.reload({ only: ['chatData'], preserveState: true, preserveScroll: true });
        })
        .catch(error => {
            console.error("Failed to send message:", error);
            alert('ارسال پیام با خطا مواجه شد.');
        })
        .finally(() => setIsSending(false));
    };
    
    const filteredConversations = conversations.filter(convo =>
        convo.user.name.toLowerCase().includes(searchTerm.toLowerCase())
    );

    return (
        <div className="card" style={{ height: '550px', display: 'flex', flexDirection: 'column', overflow: 'hidden' }}>
            <div style={{ position: 'relative', width: '100%', height: '100%' }}>
                {/* نمای لیست مکالمات */}
                <div style={{
                    position: 'absolute', width: '100%', height: '100%', display: 'flex', flexDirection: 'column',
                    transform: activeConversation ? 'translateX(-100%)' : 'translateX(0)',
                    transition: 'transform 0.3s ease-in-out'
                }}>
                    <div style={{ padding: '15px', borderBottom: '1px solid #e8ebf1' }}>
                        <h5 className="card-title mb-2">مکالمات</h5>
                        <input type="text" className="form-control form-control-sm" placeholder="جستجوی کاربر..."
                            value={searchTerm} onChange={(e) => setSearchTerm(e.target.value)} />
                    </div>
                    <div style={{ flex: 1, overflowY: 'auto' }}>
                        {filteredConversations.length > 0 ? filteredConversations.map(convo => (
                            <ConversationItem key={convo.user.id} conversation={convo} onClick={() => handleConversationClick(convo)} isActive={activeConversation?.user.id === convo.user.id} />
                        )) : <p className="text-center text-muted p-3">نتیجه‌ای یافت نشد.</p>}
                    </div>
                </div>

                {/* نمای پنجره چت فعال */}
                <div style={{
                    position: 'absolute', width: '100%', height: '100%', display: 'flex', flexDirection: 'column',
                    transform: activeConversation ? 'translateX(0)' : 'translateX(100%)',
                    transition: 'transform 0.3s ease-in-out',
                    backgroundColor: 'white'
                }}>
                    {activeConversation ? (
                        <>
                            <div className="card-header bg-transparent d-flex align-items-center">
                                <button onClick={handleBackClick} className="btn btn-light btn-sm mr-2">
                                    <i className="fa fa-arrow-right"></i>
                                </button>
                                <img src={activeConversation.user.avatar} alt={activeConversation.user.name} style={{ width: 40, height: 40, borderRadius: '50%', marginLeft: '10px' }}/>
                                <h5 className="card-title mb-0">{activeConversation.user.name}</h5>
                            </div>
                            <div className="card-body chat-application" style={{ flex: '1 1 auto', overflowY: 'auto' }} ref={chatBoxRef}>
                                <div className="chats">
                                    {activeConversation.messages.map((msg, index) => (
                                        <div className={`chat${!msg.is_sender ? ' chat-left' : ''}`} key={msg.id || `msg-${index}`}>
                                            <div className="chat-avatar"><a className="avatar"><img src={msg.user.avatar} alt={msg.user?.name} className="rounded-circle" width="40" height="40"/></a></div>
                                            <div className="chat-body">
                                                <div className={`chat-content${msg.is_sender ? ' text-white bg-primary' : ''}`}>
                                                    {!msg.is_sender && <p className="text-muted font-weight-bold mb-1">{msg.user?.name}</p>}
                                                    <p className="mb-0">{msg.text}</p>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                            <div className="card-footer">
                                <form onSubmit={submit} className="chat-app-input">
                                    <div className="input-group">
                                        <input type="text" className="form-control" placeholder="پاسخ خود را بنویسید..." value={newMessage} onChange={e => setNewMessage(e.target.value)} disabled={isSending} />
                                        <div className="input-group-append">
                                            <button className="btn btn-primary" type="submit" disabled={isSending}>
                                                {isSending ? '...' : 'ارسال'}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </>
                    ) : null}
                </div>
            </div>
        </div>
    );
};

export default ChatBoxWidget;