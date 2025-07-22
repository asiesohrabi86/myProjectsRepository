import React from 'react';
import AdminLayout from './Layout/AdminLayout';
import StatsCards from './StatsCards';
import BestSeller from './BestSeller';
import OrderSummary from './OrderSummary';
import Widgets from './Widgets';
import Timeline from './Timeline';
import TopProductsTable from './TopProductsTable';
import ProjectsTable from './ProjectsTable';
import ChatBox from './ChatBox';
import ProjectStatus from './ProjectStatus';
import DashboardHeader from './DashboardHeader';
import ThemeSettings from './ThemeSettings';
import DashboardEarningCard from './DashboardEarningCard';
import DashboardBestSellerCard from './DashboardBestSellerCard';
import DashboardIncomeChart from './DashboardIncomeChart';
import DashboardOrderSummaryChart from './DashboardOrderSummaryChart';

const Dashboard = () => {
    return (
        <AdminLayout>
            <ThemeSettings />
            <DashboardHeader />
            <div className="row">
                <div className="col-md-6 box-margin height-card">
                    <DashboardEarningCard />
                </div>
                <div className="col-md-6 height-card box-margin">
                    <DashboardBestSellerCard />
                </div>
            </div>
            <div className="row">
                <div className="col-md-4 box-margin">
                    <DashboardIncomeChart />
                </div>
                <div className="col-md-8 box-margin">
                    <DashboardOrderSummaryChart />
                </div>
            </div>
        </AdminLayout>
    );
};

export default Dashboard;
