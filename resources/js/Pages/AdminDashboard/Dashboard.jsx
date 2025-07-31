import React from 'react';
// فرض می‌کنیم Layout شما در این مسیر است
import AdminLayout from './Layout/AdminLayout'; 
import DashboardHeader from './DashboardHeader'; 
import ThemeSettings from './ThemeSettings';
import DashboardEarningCard from './DashboardEarningCard';
import DashboardBestSellerCard from './DashboardBestSellerCard';
import DashboardIncomeChart from './DashboardIncomeChart';
import DashboardOrderSummaryChart from './DashboardOrderSummaryChart';
import AnnualSummaryBarChart from './AnnualSummaryBarChart';
import TopProductTable from './TopProductTable';
import NewUsers from './NewUsers';
import Notifications from './Notifications';
import ChatBoxWidget from './ChatBoxWidget';
import Widgets from './Widgets';
import { Head } from '@inertiajs/react';

// پراپ‌هایی که به صورت lazy لود می‌شوند (مثل weeklyEarnings) به اینجا اضافه خواهند شد
const Dashboard = (props) => {
    return (
        <AdminLayout>
            <Head title="داشبورد ادمین" />
            <ThemeSettings />
            <DashboardHeader />
            <div className="row">
                <div className="col-md-6 box-margin height-card">
                    {/* پراپ weeklyEarnings که به صورت lazy لود شده را به کامپوننت پاس می‌دهیم */}
                    <DashboardEarningCard earningsDataProp={props.weeklyEarnings} />
                </div>
                <div className="col-md-6 height-card box-margin">
                    <DashboardBestSellerCard bestSellerDataProp={props.bestSellerData} />
                </div>
            </div>
            <div className="row">
                <div className="col-md-8 box-margin">
                    <DashboardOrderSummaryChart orderSummaryDataProp={props.orderSummaryData} />
                </div>
                <div className="col-md-4 box-margin">
                    <DashboardIncomeChart totalIncomeDataProp={props.totalIncomeData} />
                </div>
            </div>
            
            <Widgets/>
            <div className="row">
                <div className="col-12 box-margin">
                    <AnnualSummaryBarChart/>
                </div>
                <div className="col-12 box-margin">
                    <TopProductTable products={props.topProducts} />
                </div>
                <div className="col-12 col-md-6 col-xl-4 box-margin">
                    <NewUsers />
                </div>
                <div className="col-12 col-md-6 col-xl-4 box-margin">
                    <Notifications />
                </div>
                <div className="col-12 col-md-6 col-xl-4 box-margin">
                    <ChatBoxWidget chatData={props.chatData} />
                </div>
            </div>
        </AdminLayout>
    );
};

export default Dashboard;