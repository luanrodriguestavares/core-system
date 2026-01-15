import React from 'react';
import { Routes, Route, Link } from 'react-router-dom';
import Login from './pages/Login.jsx';
import Tenants from './pages/Tenants.jsx';
import Plans from './pages/Plans.jsx';
import TenantBilling from './pages/TenantBilling.jsx';

export default function MasterApp() {
  return (
    <div>
      <h1>Master Admin</h1>
      <nav style={{ display: 'flex', gap: 12 }}>
        <Link to="login">Login</Link>
        <Link to="tenants">Tenants</Link>
        <Link to="plans">Plans</Link>
      </nav>
      <Routes>
        <Route path="login" element={<Login />} />
        <Route path="tenants" element={<Tenants />} />
        <Route path="plans" element={<Plans />} />
        <Route path="tenant/:id/billing" element={<TenantBilling />} />
      </Routes>
    </div>
  );
}
