import React, { useState } from 'react';
import { apiClient } from '../../../api/client.js';

export default function Login() {
  const [email, setEmail] = useState('admin@saas.com');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = async (event) => {
    event.preventDefault();
    try {
      const data = await apiClient('master').post('/auth/login', { email, password });
      setMessage(`Token: ${data.token}`);
    } catch (error) {
      setMessage(error.message);
    }
  };

  return (
    <section>
      <h2>Login Master</h2>
      <form onSubmit={handleSubmit} style={{ display: 'grid', gap: 8, maxWidth: 320 }}>
        <input value={email} onChange={(e) => setEmail(e.target.value)} placeholder="Email" />
        <input value={password} onChange={(e) => setPassword(e.target.value)} placeholder="Senha" type="password" />
        <button type="submit">Entrar</button>
      </form>
      {message && <p>{message}</p>}
    </section>
  );
}
