import React from 'react';
import { useParams } from 'react-router-dom';

export default function TenantBilling() {
  const { id } = useParams();

  return (
    <section>
      <h2>Billing do Tenant {id}</h2>
      <p>Status e histórico de cobranças.</p>
    </section>
  );
}
