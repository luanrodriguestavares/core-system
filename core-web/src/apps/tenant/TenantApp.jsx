import React from 'react';
import { Routes, Route, Link } from 'react-router-dom';
import Login from './pages/Login.jsx';
import Dashboard from './pages/Dashboard.jsx';
import Customers from './pages/Customers.jsx';
import Appointments from './pages/Appointments.jsx';
import Transactions from './pages/Transactions.jsx';
import Settings from './pages/Settings.jsx';

export default function TenantApp() {
  return (
    <div>
      <h1>Tenant App</h1>
      <nav style={{ display: 'flex', gap: 12 }}>
        <Link to="login">Login</Link>
        <Link to="dashboard">Dashboard</Link>
        <Link to="customers">Customers</Link>
        <Link to="appointments">Appointments</Link>
        <Link to="transactions">Transactions</Link>
        <Link to="settings">Settings</Link>
      </nav>
      <Routes>
        <Route path="login" element={<Login />} />
        <Route path="dashboard" element={<Dashboard />} />
        <Route path="customers" element={<Customers />} />
        <Route path="appointments" element={<Appointments />} />
        <Route path="transactions" element={<Transactions />} />
        <Route path="settings" element={<Settings />} />
      </Routes>
    </div>
  );
}
