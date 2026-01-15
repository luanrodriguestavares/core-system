import React from 'react';
import { createBrowserRouter } from 'react-router-dom';
import Layout from '../components/Layout.jsx';
import MasterApp from '../apps/master/MasterApp.jsx';
import TenantApp from '../apps/tenant/TenantApp.jsx';

export const router = createBrowserRouter([
  {
    path: '/',
    element: <Layout />,
    children: [
      {
        path: 'master/*',
        element: <MasterApp />,
      },
      {
        path: 'app/*',
        element: <TenantApp />,
      },
    ],
  },
]);
