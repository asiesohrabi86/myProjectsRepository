import React, { useState, useEffect, useRef } from 'react';
import { router, useForm, usePage } from '@inertiajs/react';

const ChatBoxWidget = () => {
    const { props } = usePage();
    const messages = props.chatData || [];
    
    const [activeRecipient, setActiveRecipient] = useState(null);
    const chatBoxRef = useRef(null);

    const { data, setData, post, processing, reset, errors } = useForm({
        message: '',
        recipient_id: '',
    });

    // افکت برای اسکرول
    useEffect(() => {
        if (chatBoxRef.current) chatBoxRef.current.scrollTop = chatBoxRef.current.scrollHeight;
    }, [messages.length]);

    // **شروع بخش جدید: Polling برای دریافت پیام‌های جدید**
    useEffect(() => {
        // هر ۱۰ ثانیه، پراپ chatData را دوباره بارگذاری کن
        const interval = setInterval(() => {
            router.reload({
                only: ['chatData'], // فقط همین پراپ را بگیر
                preserveState: true, // state فرم را حفظ کن
                preserveScroll: true, // اسکرول را حفظ کن
            });
        }, 10000); // ۱۰ ثانیه

        // تابع پاک‌سازی: در زمان unmount شدن کامپوننت، interval را متوقف کن
        return () => clearInterval(interval);
    }, []); // فقط یک بار اجرا شود

    // افکت برای پیدا کردن کاربر فعال
    useEffect(() => {
        const lastUserMessage = [...messages].reverse().find(msg => !msg.is_sender && msg.user);
        if (lastUserMessage) {
            setActiveRecipient(lastUserMessage.user);
            setData('recipient_id', lastUserMessage.user.id);
        }
    }, [messages]);

    const submit = (e) => {
        e.preventDefault();
        if (!activeRecipient) return;

        post(route('dashboard.chat.send'), {
            preserveScroll: true,
            onSuccess: () => reset('message'),
        });
    };
    
    return (
        <div className="card full-height d-flex flex-column">
            <div className="card-header bg-transparent"><h4 className="card-title">پشتیبانی زنده</h4></div>
            <div className="card-body chat-application" style={{ flex: '1 1 auto', overflowY: 'auto', minHeight: '300px' }} ref={chatBoxRef}>
                <div className="chats">
                    {messages.length > 0 ? messages.map((msg, index) => (
                        <div className={`chat${!msg.is_sender ? ' chat-left' : ''}`} key={msg.id || `msg-${index}`}>
                            <div className="chat-avatar"><a className="avatar"><img src={msg.user.avatar} alt={msg.user?.name} className="rounded-circle" width="40" height="40"/></a></div>
                            <div className="chat-body">
                                <div className={`chat-content${msg.is_sender ? ' text-white bg-primary' : ''}`}>
                                    {!msg.is_sender && <p className="text-muted font-weight-bold mb-1">{msg.user?.name}</p>}
                                    <p className="mb-0">{msg.text}</p>
                                </div>
                            </div>
                        </div>
                    )) : <p className="text-center text-muted">هیچ پیامی برای نمایش وجود ندارد.</p>}
                </div>
            </div>
            <div className="card-footer">
                <form onSubmit={submit} className="chat-app-input">
                    <fieldset>
                        <div className="input-group">
                            <input
                                type="text"
                                className="form-control"
                                placeholder={activeRecipient ? `پاسخ به ${activeRecipient.name}` : 'در انتظار پیام کاربر...'}
                                value={data.message}
                                onChange={e => setData('message', e.target.value)}
                                disabled={!activeRecipient || processing}
                            />
                            <div className="input-group-append">
                                <button className="btn btn-primary" type="submit" disabled={!activeRecipient || processing}>
                                    {processing ? 'در حال ارسال...' : 'ارسال'}
                                </button>
                            </div>
                        </div>
                        {/* نمایش خطاهای ولیدیشن از سمت سرور */}
                        {errors.recipient_id && <div className="text-danger mt-1 small">{errors.recipient_id}</div>}
                        {errors.message && <div className="text-danger mt-1 small">{errors.message}</div>}
                    </fieldset>
                </form>
            </div>
        </div>
    );
};

export default ChatBoxWidget;

