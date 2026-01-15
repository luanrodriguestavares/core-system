import React from 'react';
import { Outlet, Link } from 'react-router-dom';

export default function Layout() {
  return (
    <div style={{ fontFamily: 'sans-serif', padding: 24 }}>
      <header style={{ display: 'flex', gap: 16, marginBottom: 24 }}>
        <Link to="/master/login">Master</Link>
        <Link to="/app/login">App</Link>
      </header>
      <Outlet />
    </div>
  );
}
